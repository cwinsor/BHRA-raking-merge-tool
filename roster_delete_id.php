<?php
require_once("my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
	$id = $_GET['id'];
} else {
	header('Location: roster_select.php');
}
?>


<?php
$databasehost = "localhost"; 
$databasename = "bhra_raking_merge"; 
$databasetable = "roster_raw"; 
$databaseusername="root"; 
$databasepassword = ""; 

$db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
$sql = "DELETE FROM $databasetable WHERE id=$id";
mysqli_query($db, $sql);
mysqli_close($db);

// delete is done - redirect
header('Location: roster_select.php');
?>


<?php
readfile('navigation.tmpl.html');
?>

<!DOCTYPE html>
<html>
<head>
	<title>BHRA Leaf Raking</title>
</head>
<body>
</body>
</html>
