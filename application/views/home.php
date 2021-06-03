<?php include 'inc/header.php'; ?>
<body>


	<div class="container">
		<div class="jumbotron">
		<h3 class="display-3" style="text-align: center;color:skyblue">RWANDA POLYTECHNIC</h3>
			<h3 class="display-3" style="text-align: center;color:black">Admin</h3>
			<hr>
			<div class="my-4">
				<div class="row">
					<div class="col-lg-4">
						
					</div>
					<div class="col-lg-4">
						<?php echo anchor("welcome/login", "Admin Login", ['class'=>'btn btn-primary']); ?>
						<?php echo anchor("welcome/adminRegister", "Admin Register", ['class'=>'btn btn-primary']); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	</body>

<?php include 'inc/footer.php'; ?>
