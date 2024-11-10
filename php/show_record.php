<!DOCTYPE html>
<html>
<head>
	<title>show records</title>
</head>
<body>
<?php
include ('db_connection.php');
$sql ="select * from te_2023";
$data =mysqli_query($con,$sql);
$total=mysqli_num_rows($data);
if ($total=mysqli_num_rows($data)) {
?>
	<table border="2">
<tr>
<th>Roll Number</th>
<th>Student Name</th>
<th>Class</th>
<th>Subject</th>
<th>Marks Obtained</th>
<th>Update Record</th>
<th>Delete Record</th>
</tr>
	<?php
	while ($result = mysqli_fetch_array($data)) {
		echo "
			<tr>
				<td>".$result['Roll_No']."</td>
				<td>".$result['Student_Name']."</td>
				<td>".$result['Class']."</td>
				<td>".$result['Subject']."</td>
				<td>".$result['Marks_Obtained']."</td>
				<td><a href='update_record.php?roll_no=$result[Roll_No] & studentname=$result[Student_Name] & class=$result[Class] & subject=$result[Subject] & marks=$result[Marks_Obtained]'> Update </a></td>
				<td><a href='delete_record.php?roll_no=$result[Roll_No] '>Delete </a></td>
			</tr>
		";
	}
}
else
{
 	echo "no record found";
}
?>
</table>
</body>
</html>