<?php
include ('db_connection.php');
$id = $_GET['roll_no'];
$sql ="DELETE FROM `te_2023` WHERE Roll_No='$id'";
$data = mysqli_query($con,$sql);
if ($data) {
	echo "deleted";
	header('location:show_record.php');
}else
{
	echo "error";
}
 ?>