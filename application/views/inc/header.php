<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>RP MANAGEMENT SYSTEM</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		</head>
	<body >

		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		
		  <a href="#" class="navbar-brand" style="color: #fff;"> RWANDA POLYTECHNIC</a>
       
			<div class="col-lg-2 ml-auto" style="margin-top: 15px;" id="">
				<div class="btn btn-group btn-light btn-sm">
					<a href="#" class="btn btn-sm">Profile</a>
					<a href="#" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<?php
							$user_id = $this->session->userdata('user_id');
						?>
						<?php if($user_id == 1): ?>
							<li class="btn btn-lg"><?php echo anchor("admin/dashboard", 'Dashboard'); ?></li>
							<li class="btn btn-lg"><?php echo anchor("admin/moderator", 'Moderator'); ?></li>
							<li class="btn btn-lg"><?php echo anchor("welcome/logout", 'Logout'); ?></li>
						<?php else: ?>
							<li class="btn btn-lg"><?php echo anchor("welcome/logout", 'Logout'); ?></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>

		</nav>
