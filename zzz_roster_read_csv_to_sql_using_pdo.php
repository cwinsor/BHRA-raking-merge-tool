<?php
require_once("my_error_handler.php");
require_once("roster_read_csv_to_sql_using_pdo.php");
set_error_handler("my_error_handler");
?>


<?php
// reads team roster from .csv file into sql database
//
// reference:
// http://stackoverflow.com/questions/20876043/php-script-to-import-csv-data-into-mysql

$csvfile = "C:\Users\cwinsor\Documents\me\BHRA_2015\Leaf Raking Development Merge Tool\Spring 2015 roster March 8x.csv";

$fieldseparator = ","; 
$lineseparator = "\n";
$databasehost = "localhost"; 
$databasename = "bhra_raking_merge"; 
$databasetable = "roster_raw"; 
$databaseusername="root"; 
$databasepassword = ""; 

// DEBUG
$msg = sprintf("reading %s <br>\ninto %s %s %s<br>\n",
	$csvfile,
	$databasehost,
	$databasename,
	$databasetable);
echo $msg;

if(!file_exists($csvfile)) {
	trigger_error("File not found. Make sure you specified the correct path.".$csvfile,E_USER_ERROR);
}

try {
	$pdo = new PDO("mysql:host=$databasehost;dbname=$databasename", 
		$databaseusername, $databasepassword,
		array(
			PDO::MYSQL_ATTR_LOCAL_INFILE => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			)
		);
} catch (PDOException $e) {
	trigger_error("database connection failed: ".$e->getMessage(), E_USER_ERROR);
}

$affectedRows = $pdo->exec("
	LOAD DATA LOCAL INFILE ".$pdo->quote($csvfile)." INTO TABLE `$databasetable`
	FIELDS TERMINATED BY ".$pdo->quote($fieldseparator)."
	LINES TERMINATED BY ".$pdo->quote($lineseparator));

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
	<p><?php
	echo "Loaded a total of $affectedRows records from this csv file.\n";
	?>
</p>
</body>
</html>

