<?php

session_start();

if(isset($_SESSION['login'])){
	header("Location:read.php");
}

if(isset($_POST['login'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$database = mysqli_connect("localhost", "id15148377_root", "Cn*X@>0L*twkL5hx", "id15148377_raccoon_city_university");
	$query = mysqli_query($database, "SELECT * FROM users WHERE username='$username'");
	if($data = mysqli_fetch_assoc($query)){
		if(password_verify($password, $data['password'])){
			$_SESSION['login'] = true;
			header("Location:read.php");
		} else{
			$desc = "Username or Password is incorrect";
		}
	} else{
		$desc = "Username or Password is incorrect";
	}
}

?>


<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<title>University Raccoon City</title>
</head>
<body class="bg-success">
	<!--  -->
	<div class="container min-vh-100">
		<div class="row min-vh-100 justify-content-center align-items-center">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header text-center">
					<a href="index.php" class="text-decoration-none"><h1>University Raccoon City</h1></a>
					<h3>Login Page for Admin</h3>
				</div>
				<div class="card-body">
					<form action="" method="POST">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" name="username" placeholder="Username" autofocus>
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" name="password" placeholder="Password">
						</div>
						<p><?php if(isset($desc)) : ?>
							<?= $desc; ?>
						<?php endif; ?></p>
						<p class="desc"></p>
						<button type="submit" class="btn btn-success" name="login">Login</button>
					</form>
					<br>
					<a class="d-block text-left" href="read.php">You may proceed without login, but unable to modify data and to see personal data such as phone number.</a>
				</div>
			</div>
		</div>
		</div>
	</div>

	<!-- scripts -->

	<script src="js/jquery-3.5.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
  </html>