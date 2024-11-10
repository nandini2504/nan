<!DOCTYPE html>
<html>
<head>
	<title>update</title>
</head>
<body>
<form action="" method="get">
	<input type="text" name="roll_no" placeholder="Enter Roll Number" value="<?php echo $_GET['roll_no']; ?>"><br><br>
	<input type="text" name="studentname" placeholder="Enter Student Name" value="<?php echo $_GET['studentname']; ?>" ><br><br>
	<input type="text" name="class" placeholder="Enter Class" value="<?php echo $_GET['class']; ?>"><br><br>
	<input type="text" name="subject" placeholder="Enter Subject Name" value="<?php echo $_GET['subject']; ?>"><br><br>
	<input type="text" name="marks" placeholder="Enter Marks Obtained" value="<?php echo $_GET['marks']; ?>"><br><br>
	<input type="submit" name="submit" value="Update Record">
</form>
<?php
error_reporting(0);
include ('db_connection.php');

if ($_GET['submit'])
{
	$roll_no = $_GET['roll_no'];
	$studentname = $_GET['studentname'];
	$class = $_GET['class'];
	$subject = $_GET['subject'];
	$marks = $_GET['marks'];
 	$sql="UPDATE te_2023 SET Roll_No='$roll_no' , Student_Name='$studentname', Class='$class' , Subject='$subject', Marks_Obtained='$marks'   WHERE Roll_No='$roll_no'";
 	$data=mysqli_query($con, $sql);
 	if ($data) {
 		echo "Record Updated Successfully";
 		header('location:show_record.php');
 	}
 	else{
 		echo "Record is not updated";
 	}
}
else
{
	echo "Click on  button to save the changes";
}
?>
</body>
</html>