<?php

session_start();

if(!isset($_GET['id'])){
	header("Location:read.php");
}

if(!isset($_SESSION['login'])){
	header("Location:index.php");
}

//code for showing a data which want to be updated
$db = mysqli_connect("localhost", "id15148377_root", "Cn*X@>0L*twkL5hx", "id15148377_raccoon_city_university");
$idData = $_GET["id"];
$query = mysqli_query($db, "SELECT * FROM college_students WHERE id=$idData");
$data = [];
while($datas = mysqli_fetch_assoc($query)){
	$data[] = $datas;
}
// end of code for showing a data which want to be updated

// update section
if(isset($_POST['submit'])){
    // photo section
    if(isset($_FILES['photo'])){
    	// if theres no new photo given
	    if($_FILES['photo']['error'] === 4){
	        global $data;
	        $img = $data[0]['photo'];
	    }
	    // if theres a new photo given
    	else if($_FILES['photo']['error'] === 0){

		    // check the size of photo
		    $imageSize = $_FILES['photo']['size'];
		    if($imageSize > 102400){
			    echo "<script>alert('Image must be under 100kb')</script>";
			    echo "<a href='create.php'>Go back and try again</a>";
			    exit;
		    }
		    // check the photo type extension
	    	$imageTypeValid = ['jpg', 'png', 'jpeg'];
	    	$imageType = explode('.', $_FILES['photo']['name']);
	    	$imageType = end($imageType);
	    	$imageType = strtolower($imageType);
	    	if(!in_array($imageType, $imageTypeValid)){
	    		echo "<script>alert('Image must be jpg or png')</script>";
	    		echo "<a href='create.php'>Go back and try again</a>";
	    		exit;
	    	}
	    	// generate random name for photo
	    	$imageName = uniqid(); 
	    	$imageName = $imageName . '.' . $imageType;
	    
	    	// rename and move photo
	    	$imageTemp = $_FILES['photo']['tmp_name'];
	    	move_uploaded_file($imageTemp, 'image/' . $imageName);
	    	$img = 'image/' . $imageName;
	    }
        // end of else if
    }
    // variables
	$name = htmlspecialchars($_POST['name']);
	$age = $_POST['age'];
	$photo = $img;
	$sex = htmlspecialchars($_POST['sex']);
	$phone = htmlspecialchars($_POST['phone']);
	$majors = $_POST['majors'];
	
    // 	insert to database
	$db = mysqli_connect("localhost", "id15148377_root", "Cn*X@>0L*twkL5hx", "id15148377_raccoon_city_university");
	$update = "UPDATE college_students SET name = '$name', photo = '$photo', sex = '$sex', age = $age, majors = '$majors', phone = '$phone' WHERE id='$idData'";
	$query = mysqli_query($db, $update);
	header("Location:read.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<title>Update Student Data - University Raccoon City</title>
	<style>
	    .photo{
	        max-height:100px;
	        max-width:100px;
	    }
	    .wrap{
	        max-width:100px;
	        word-wrap:break-word;
	    }
	</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
	<a class="navbar-brand" href="index.php">University of Raccoon City</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" href="create.php">Register</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="read.php">List of Students</a>
			</li>
		</ul>
	</div>
</nav>
<div class="container min-vh-100">
	<div class="row min-vh-100 justify-content-center align-items-center">
		<div class="col-md-12 col-lg-8">
			<table class="table table-hover table-responsive-lg">
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Photo</th>
					<th scope="col">Age</th>
					<th scope="col">Sex</th>
					<th scope="col">Majors</th>
					<th scope="col">Phone</th>
				</tr>
				<tr>
					<td class="wrap"><?=$data[0]["name"]?></td>
					<td><img src="<?=$data[0]['photo']?>" class="img-fluid photo"></td>
					<td><?=$data[0]["age"]?></td>
					<td><?=$data[0]["sex"]?></td>
					<td class="wrap"><?=$data[0]["majors"]?></td>
					<td class="wrap"><?=$data[0]["phone"]?></td>
				</tr>
			</table>
		</div>
		<div class="col-md-12 col-lg-4 mt-3">
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Your name" value="<?=$data[0]['name']?>" required>
				</div>
				<div class="form-group">
				    <label for="photo">Photo</label>
				    <input type="file" class="form-control-file" id="photo" name="photo">
		        </div>
				<div class="form-group">
				    <label for="age">Age</label>
				    <input type="number" class="form-control" id="age" name="age" min="12" max="100" value="<?=$data[0]['age']?>" required>
				</div>
				<div class="mb-3">
					<label for="">Sex</label>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="sex" id="sex" value="Male" required>
						<label class="form-check-label" for="sex">Male</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="sex" id="sex" value="Female">
						<label class="form-check-label" for="sex">Female</label>
					</div>
				</div>
				<div class="form-group">
				    <label for="majors">Majors</label>
				    <select class="form-control" id="majors" name="majors" required>
				    	<option value="<?=$data[0]['majors']?>"><?=$data[0]['majors']?></option>
				    	<option value="Economics">Economics</option>
				    	<option value="English Language and Literature">English Language and Literature</option>
				    	<option value="Chemical Engineering">Chemical Engineering</option>
				    	<option value="Political Science">Political Science</option>
				    </select>
				</div>
				<div class="form-group">
					<label for="phone">Phone</label>
					<input type="text" class="form-control" id="phone" name="phone" value="<?=$data[0]['phone']?>" required>
				</div>
				<div class="form-group">
					<button type="submit" name="submit" class="btn btn-success">Submit</button>
				</div>
			</form>
			<a href="read.php"><button class="btn btn-secondary">Cancel</button></a>
		</div>
	</div>
</div>
<script src="js/jquery-3.5.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>