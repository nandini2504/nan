<!DOCTYPE html>
<html>
<head>
	<title>insert records</title>
</head>
<body>
<div class="row text-center">
	<div class="container">
		<h1>Insert Student Information</h1>
	<form action="home_page.php" method="post">
	<b> Roll Number :     </b> <input type="text" name="Roll_Number" placeholder="Enter Roll Number"><br><br>
	<b> Student Name:    </b><input type="text" name="Student_Name" placeholder="Enter Student Name"><br><br>
	<b> Class :                 </b><input type="text" name="Class" placeholder="Enter Class Name (TE A or TE B)"><br><br>
	<b> Subject :     </b><input type="text" name="Subject" placeholder="Enter Subject Name"><br><br>
	<b> Marks Obtained : </b><input type="text" name="Marks" placeholder="Enter Marks Obtained"><br><br>
	<input type="submit" name="submit" value="Add Student Record"><br><br>
	</form>
<button><a href="show_record.php">Show Students Records</a></button>
	</div>
</div>
</body>
</html>
<?php
error_reporting(0);
include 'db_connection.php';
if (isset($_POST['submit'])) {
	$Roll_Number = $_POST['Roll_Number'];
	$Student_Name = $_POST['Student_Name'];
	$Class = $_POST['Class'];
	$Subject = $_POST['Subject'];
	$Marks = $_POST['Marks'];
	$sql = "INSERT INTO `te_2023` VALUES ('$Roll_Number','$Student_Name','$Class','$Subject','$Marks')";
	$data=mysqli_query($con,$sql);
	if ($data) {
		echo "Student Record Inserted Sucessfully";
	}else
	{
		echo "Record Could not be inserted. Some Error Occured";
	}
}
?>