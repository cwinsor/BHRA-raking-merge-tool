<?php
require_once("my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php
// reads team roster from .csv file into sql database
//
// reference:
// http://stackoverflow.com/questions/20876043/php-script-to-import-csv-data-into-mysql


// SUBMIT BUTTON
$msg = '';

if (isset($_POST['submit']))
{

// DEBUG
//	echo '<br>';
//	var_dump($_FILES);
//	echo '<br>';

	// Check if there are any errors in the upload
	if($_FILES['file']['error'] > 0){
		die('An error ocurred when accessing.');
	}

	// Check if the file type is allowed
	if($_FILES['file']['type'] != 'application/vnd.ms-excel'){
		die('Unsupported file type.');
	}

	// Check that the file is under our file size limit
	if($_FILES['file']['size'] > 500000){
		die('File exceeds maximum size.');
	}

	$csvfile = $_FILES['file']['tmp_name'];

	$fieldseparator = ","; 
	$lineseparator = "\n";
	$databasehost = "localhost"; 
	$databasename = "bhra_raking_merge"; 
	$databasetable = "roster_raw"; 
	$databaseusername="root"; 
	$databasepassword = ""; 

// DEBUG
	$message = sprintf("reading %s <br>\ninto %s %s %s<br>\n",
		$csvfile,
		$databasehost,
		$databasename,
		$databasetable);
	echo $message;

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

	$msg = "Loaded a total of $affectedRows records from this csv file.";
}
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

	<form action="roster_file_read_csv_to_sql_using_pdo.php" method="post" enctype="multipart/form-data">
		<label for="file">Filename:</label>
		<input type="file" name="file" id="file"> 
		<br>
		<input type="submit" name="submit" value="Submit">
	</form>

	<p><?php echo $msg;?></p>

</p>
</body>
</html>

