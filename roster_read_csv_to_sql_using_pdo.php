<?php

// reads team roster from .csv file into sql database
//
// reference:
// http://stackoverflow.com/questions/20876043/php-script-to-import-csv-data-into-mysql

function roster_read_csv_to_sql_using_pdo(
	$csvfile,
	$fieldseparator,
	$lineseparator,
	$databasehost,
	$databasename,
	$databasetable,
	$databaseusername,
	$databasepassword)
{

//trigger_error("File not found. Make sure you specified the correct path.".$
// trigger_error("this is notice with $text message about $value", E_USER_NOTICE);

//$textline = printf("reading from %s <br>\n into %s %s %s",
//	$csvfile,
//	$databasehost,
//	$databasename,
//	$databasetable);
// trigger_error($textline, E_USER_NOTICE);
	printf("reading %s <br>\ninto %s %s %s<br>\n",
		$csvfile,
		$databasehost,
		$databasename,
		$databasetable);



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

	echo "Loaded a total of $affectedRows records from this csv file.\n";
}
?>
