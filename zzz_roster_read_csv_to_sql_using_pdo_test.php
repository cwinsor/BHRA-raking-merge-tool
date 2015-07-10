<?php
require_once("my_error_handler.php");
require_once("roster_read_csv_to_sql_using_pdo.php");
set_error_handler("my_error_handler");
?>

<!DOCTYPE html>
<html>
<head>
	<title>BHRA Leaf Raking</title>
</head>
<body>

		<?php
$csvfile = "filename.csv";
$csvfile = "C:\Users\cwinsor\Documents\me\BHRA_2015\Leaf Raking Development Merge Tool\Spring 2015 roster March 8x.csv";

$fieldseparator = ","; 
$lineseparator = "\n";
$databasehost = "localhost"; 
$databasename = "bhra_raking_merge"; 
$databasetable = "roster_raw"; 
$databaseusername="root"; 
$databasepassword = ""; 

roster_read_csv_to_sql_using_pdo (
	$csvfile,
	$fieldseparator,
	$lineseparator,
	$databasehost,
	$databasename,
	$databasetable,
	$databaseusername,
	$databasepassword);


		?>
</body>
</html>
