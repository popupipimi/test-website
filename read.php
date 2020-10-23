<?php

session_start();

$db = mysqli_connect("localhost", "id15148377_root", "Cn*X@>0L*twkL5hx", "id15148377_raccoon_city_university");
$query = mysqli_query($db, "SELECT * FROM college_students ORDER BY name");

if(isset($_POST['search'])){
	$keyword = $_POST['keyword'];
	$query = mysqli_query($db, "SELECT * FROM college_students WHERE name LIKE '%$keyword%' OR age LIKE '%$keyword%' OR sex LIKE '%$keyword%' OR majors LIKE '%$keyword%' OR phone LIKE '%$keyword%'");
}

$data = [];
while($datas = mysqli_fetch_assoc($query)){
	$data[] = $datas;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="css/bootstrap.min.css">
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
	<title>List of Students - University Raccoon City</title>
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
			<?php if(isset($_SESSION['login'])) : ?>
			<li class="nav-item">
				<a class="nav-link" href="logout.php">Logout</a>
			</li>
			<?php endif; ?>
			<?php if(!isset($_SESSION['login'])) : ?>
			<li class="nav-item">
				<a class="nav-link" href="login.php">Login</a>
			</li>
			<?php endif; ?>
		</ul>
	</div>
</nav>
<div class="container">
	<div class="row">
		<div class="col-md-4 mt-4">
			<form action="" method="POST">
			  <div class="form-group">
			    <label for="keyword">Search student</label>
			    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Your keyword">
			  </div>
			  <div class="form-group">
			  	<button type="submit" name="search" class="btn btn-success">Search</button>
			  </div>
			</form>
			    <a href="read.php"><button class="btn btn-dark">Reset</button></a>
		</div>
		</form>
		<div class="col-md-8 mt-4">
		<table class="table table-responsive-lg table-hover" id='myTable'>
			<tr>
				<th>No.</th>
				<th>Name</th>
				<th>Photo</th>
				<th>Age</th>
				<th>Sex</th>
				<th>Majors</th>
				<?php if(isset($_SESSION['login'])) : ?>
					<th>Phone</th>
					<th>Modify</th>
				<?php endif; ?>
			</tr>
			<?php $i = 1 ?>
			<?php foreach($data as $d) :?>
				<tr>
					<td><?= $i ?></td>
					<td class="wrap"><?= $d["name"] ?></td>
					<td><img src="<?= $d["photo"] ?>" class="img-fluid photo"></td>
					<td ><?= $d["age"] ?></td>
					<td><?= $d["sex"]?></td>
					<td class="wrap"><?= $d["majors"]?></td>
					<?php if(isset($_SESSION['login'])) : ?>
						<td class="wrap"><?= $d["phone"]?></td>
						<td>
							<a href='delete.php?id=<?= $d["id"] ?>' class="d-block" onclick='return confirm("Are you sure you want to delete?")'>
							Delete</a>
							<a href='update.php?id=<?= $d["id"] ?>' class="d-block">Update</a>
						</td>
					<?php endif; ?>
				</tr>
				<?php $i++; ?>
			<?php endforeach; ?>
		</table>
		<a href="#" id="test" onClick="javascript:fnExcelReport();"><button class="btn btn-success mb-3">Excel This</button></a>
		</div>
	</div>
</div>
<script src="js/jquery-3.5.1.slim.min.js"></script>
<script>
	function fnExcelReport() {
	    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
	    tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';

	    tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';

	    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
	    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

	    tab_text = tab_text + "<table border='1px'>";
	    tab_text = tab_text + $('#myTable').html();
	    tab_text = tab_text + '</table></body></html>';

	    var data_type = 'data:application/vnd.ms-excel';
	    
	    var ua = window.navigator.userAgent;
	    var msie = ua.indexOf("MSIE ");
	    
	    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
	        if (window.navigator.msSaveBlob) {
	            var blob = new Blob([tab_text], {
	                type: "application/csv;charset=utf-8;"
	            });
	            navigator.msSaveBlob(blob, 'Test file.xls');
	        }
	    } else {
	        $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
	        $('#test').attr('download', 'Test file.xls');
	    }
	}
</script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>