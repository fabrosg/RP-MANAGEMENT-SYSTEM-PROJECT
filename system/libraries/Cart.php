<?php

 
defined('BASEPATH') OR exit('No direct script access allowed');


class CI_Cart {


	 
	 * @var string
	
	public $product_id_rules = '\.a-z0-9_-';

	
	 * @var string
	
	public $product_name_rules = '\w \-\.\:';

	
	 * @var bool
	 */
	public $product_name_safe = TRUE;

	
	
	 * @var object
	 */
	protected $CI;

	/**
	 * Contents of the cart
	 *
	 * @var array
	 */
	protected $_cart_contents = array();

	/**
	 * Shopping Class Constructor
	 *
	 * The constructor loads the Session class, used to store the shopping cart contents.
	 *
	 * @param	array
	 * @return	void
	 */
	public function __construct($params = array())
	{
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();

		// Are any config settings being passed manually?  If so, set them
		$config = is_array($params) ? $params : array();

		// Load the Sessions class
		$this->CI->load->driver('session', $config);

		// Grab the shopping cart array from the session table
		$this->_cart_contents = $this->CI->session->userdata('cart_contents');
		if ($this->_cart_contents === NULL)
		{
			// No cart exists so we'll set some base values
			$this->_cart_contents = array('cart_total' => 0, 'total_items' => 0);
		}

		log_message('info', 'Cart Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Insert items into the cart and save it to the session table
	 *
	 * @param	array
	 * @return	bool
	 */
	public function insert($items = array())
	{
		// Was any cart data passed? No? Bah...
		if ( ! is_array($items) OR count($items) === 0)
		{
			log_message('error', 'The insert method must be passed an array containing data.');
			return FALSE;
		}

		// You can either insert a single product using a one-dimensional array,
		// or multiple products using a multi-dimensional one. The way we
		// determine the array type is by looking for a required array key named "id"
		// at the top level. If it's not found, we will assume it's a multi-dimensional array.

		$save_cart = FALSE;
		if (isset($items['id']))
		{
			if (($rowid = $this->_insert($items)))
			{
				$save_cart = TRUE;
			}
		}
		else
		{
			foreach ($items as $val)
			{
				if (is_array($val) && isset($val['id']))
				{
					if ($this->_insert($val))
					{
						$save_cart = TRUE;
					}
				}
			}
		}

	
		if ($save_cart === TRUE)
		{
			$this->_save_cart();
			return isset($rowid) ? $rowid : TRUE;
		}

		return FALSE;
	}


	 * Insert
	 *
	 * @param	array
	 * @return	bool
	 */
	protected function _insert($items = array())
	{
		
		if ( ! is_array($items) OR count($items) === 0)
		{
			log_message('error', 'The insert method must be passed an array containing data.');
			return FALSE;
		}

	
		if ( ! isset($items['id'], $items['qty'], $items['price'], $items['name']))
		{
			log_message('error', 'The cart array must contain a product ID, quantity, price, and name.');
			return FALSE;
		}

		$items['qty'] = (float) $items['qty'];

		// If the quantity is zero or blank there's nothing for us to do
		if ($items['qty'] == 0)
		{
			return FALSE;
		}

		if ( ! preg_match('/^['.$this->product_id_rules.']+$/i', $items['id']))
		{
			log_message('error', 'Invalid product ID.  The product ID can only contain alpha-numeric characters, dashes, and underscores');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Validate the product name. It can only be alpha-numeric, dashes, underscores, colons or periods.
		// Note: These can be user-specified by setting the $this->product_name_rules variable.
		if ($this->product_name_safe && ! preg_match('/^['.$this->product_name_rules.']+$/i'.(UTF8_ENABLED ? 'u' : ''), $items['name']))
		{
			log_message('error', 'An invalid name was submitted as the product name: '.$items['name'].' The name can only contain alpha-numeric characters, dashes, underscores, colons, and spaces');
			return FALSE;
		}

		
		$items['price'] = (float) $items['price'];

		
		if (isset($items['options']) && count($items['options']) > 0)
		{
			$rowid = md5($items['id'].serialize($items['options']));
		}
		else
		{
			
			$rowid = md5($items['id']);
		}
		$old_quantity = isset($this->_cart_contents[$rowid]['qty']) ? (int) $this->_cart_contents[$rowid]['qty'] : 0;

		
		$items['rowid'] = $rowid;
		$items['qty'] += $old_quantity;
		$this->_cart_contents[$rowid] = $items;

		return $rowid;
	}


	 * @param	array
	 * @return	bool
	 */
	public function update($items = array())
	{
		// Was any cart data passed?
		if ( ! is_array($items) OR count($items) === 0)
		{
			return FALSE;
		}

		$save_cart = FALSE;
		if (isset($items['rowid']))
		{
			if ($this->_update($items) === TRUE)
			{
				$save_cart = TRUE;
			}
		}
		else
		{
			foreach ($items as $val)
			{
				if (is_array($val) && isset($val['rowid']))
				{
					if ($this->_update($val) === TRUE)
					{
						$save_cart = TRUE;
					}
				}
			}
		}

		if ($save_cart === TRUE)
		{
			$this->_save_cart();
			return TRUE;
		}

		return FALSE;
	}


	 * @param	array
	 * @return	bool
	 */
	protected function _update($items = array())
	{
		
		if ( ! isset($items['rowid'], $this->_cart_contents[$items['rowid']]))
		{
			return FALSE;
		}

		
		if (isset($items['qty']))
		{
			$items['qty'] = (float) $items['qty'];
			
			if ($items['qty'] == 0)
			{
				unset($this->_cart_contents[$items['rowid']]);
				return TRUE;
			}
		}


		$keys = array_intersect(array_keys($this->_cart_contents[$items['rowid']]), array_keys($items));
		
		if (isset($items['price']))
		{
			$items['price'] = (float) $items['price'];
		}

		// product id & name shouldn't be changed
		foreach (array_diff($keys, array('id', 'name')) as $key)
		{
			$this->_cart_contents[$items['rowid']][$key] = $items[$key];
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	
	 * @return	bool
	
	protected function _save_cart()
	{
	
		$this->_cart_contents['total_items'] = $this->_cart_contents['cart_total'] = 0;
		foreach ($this->_cart_contents as $key => $val)
		{
			
			if ( ! is_array($val) OR ! isset($val['price'], $val['qty']))
			{
				continue;
			}

			$this->_cart_contents['cart_total'] += ($val['price'] * $val['qty']);
			$this->_cart_contents['total_items'] += $val['qty'];
			$this->_cart_contents[$key]['subtotal'] = ($this->_cart_contents[$key]['price'] * $this->_cart_contents[$key]['qty']);
		}

		
		if (count($this->_cart_contents) <= 2)
		{
			$this->CI->session->unset_userdata('cart_contents');

		
			return FALSE;
		}

		
		$this->CI->session->set_userdata(array('cart_contents' => $this->_cart_contents));

		return TRUE;
	}

	
	 @return	int

	public function total()
	{
		return $this->_cart_contents['cart_total'];
	}

	
	 * @param	int
	 * @return	bool
	 
	 public function remove($rowid)
	 {
		// unset & save
		unset($this->_cart_contents[$rowid]);
		$this->_save_cart();
		return TRUE;
	 }


	 *
	 * @return	int
	
	public function total_items()
	{
		return $this->_cart_contents['total_items'];
	}

	
	 * @param	bool
	 * @return	array
	
	public function contents($newest_first = FALSE)
	{

		$cart = ($newest_first) ? array_reverse($this->_cart_contents) : $this->_cart_contents;

		
		unset($cart['total_items']);
		unset($cart['cart_total']);

		return $cart;
	}

	
	
	 * @param	string	$row_id
	 * @return	array
	
	public function get_item($row_id)
	{
		return (in_array($row_id, array('total_items', 'cart_total'), TRUE) OR ! isset($this->_cart_contents[$row_id]))
			? FALSE
			: $this->_cart_contents[$row_id];
	}

	// --------------------------------------------------------------------

	
	 * @param	string	$row_id = ''
	 * @return	bool
	
	public function has_options($row_id = '')
	{
		return (isset($this->_cart_contents[$row_id]['options']) && count($this->_cart_contents[$row_id]['options']) !== 0);
	}

	
	 * @param	string	$row_id = ''
	 * @return	array
	
	public function product_options($row_id = '')
	{
		return isset($this->_cart_contents[$row_id]['options']) ? $this->_cart_contents[$row_id]['options'] : array();
	}

	
	 * @param	float
	 * @return	string
	
	public function format_number($n = '')
	{
		return ($n === '') ? '' : number_format( (float) $n, 2, '.', ',');
	}


	 * @return	void
	
	public function destroy()
	{
		$this->_cart_contents = array('cart_total' => 0, 'total_items' => 0);
		$this->CI->session->unset_userdata('cart_contents');
	}

}
