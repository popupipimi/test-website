<?php

session_start();

?>

<!DOCTYPE HTML>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>University of Raccoon City</title>
  </head>
  <body class="bg-success">
  	<div class="container text-light min-vh-100">
  		<div class="row min-vh-100 justify-content-center align-items-center">
	  		<div class="col-md-6 text-center">
	  			<h1 class="">University of Raccoon City</h1>
	  			<small>Just a fictional university for VSGA Project - Zuhal Mughni</small>
	  		</div>
	  		<div class="col-md-6">
	  			<div class="row">
		  			<div class="col-lg-4 text-center my-3">
		  			<?php if(!isset($_SESSION['login'])) : ?>
                    <a href="login.php"><button class="btn btn-outline-dark font-weight-bold">Login Admin</button></a>
			        <?php endif; ?>
		  			</div>
		  			<div class="col-lg-4 text-center my-3">
		  			<a href="create.php"><button class="btn btn-outline-dark font-weight-bold">Register</button></a>
		  			</div>
		  			<div class="col-lg-4 text-center my-3">
		  			<a href="read.php"><button class="btn btn-outline-dark font-weight-bold">List of Students</button></a>
		  			</div>
	  			</div>
	  		</div>
  		</div>
  	</div>
  </body>
  <script src="js/jquery-3.5.1.slim.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  </html>