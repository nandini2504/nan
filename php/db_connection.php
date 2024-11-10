<?php
// Enter your Host, username, password, databasename below.
$con=mysqli_connect('localhost','root','','student_info') or die("connection failed : ".mysqli_connect_error());
if ($con) {
	//echo "Connection Established Successfully";
}
else{
	echo "Connection Could not be Established. Some Error has occured";
}
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>