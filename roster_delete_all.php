<?php
require_once("my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php
	// SUBMIT BUTTON
if (isset($_POST['submit'])) {

	$databasehost = "localhost"; 
	$databasename = "bhra_raking_merge"; 
	$databasetable = "roster_raw"; 
	$databaseusername="root"; 
	$databasepassword = ""; 

	$db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
	$sql = "DELETE FROM $databasetable";
	mysqli_query($db, $sql);
	mysqli_close($db);

// delete is done - redirect
	header('Location: roster_select.php');
}
?>



<?php
readfile('navigation.roster.html');
?>
<!DOCTYPE html>
<html>
<head>
	<title>BHRA Leaf Raking</title>
</head>
<body>

	<form action="roster_delete_all.php" method="post">
		<p><label>Confirm (delete all): <input type="submit" name="submit" value="Submit"></label></p>
	</form>

</body>
</html>
