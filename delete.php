<?php

session_start();

if(!isset($_GET['id'])){
	header("Location:read.php");
}

if(isset($_SESSION['login'])){
	header("Location:index.php");
}

$db = mysqli_connect("localhost", "id15148377_root", "Cn*X@>0L*twkL5hx", "id15148377_raccoon_city_university");
$id = $_GET["id"];
$query = mysqli_query($db, "DELETE FROM college_students WHERE id=$id");
header("Location:read.php");

?>