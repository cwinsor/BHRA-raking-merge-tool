<?php

// reads team roster from sql database

function roster_select_all_from_database(
	$databasehost,
	$databasename,
	$databasetable,
	$databaseusername,
	$databasepassword)
{

	$db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
	$sql = "SELECT * FROM $databasetable";
	$result = mysqli_query($db, $sql);
	mysqli_close($db);
	return $result;
}
?>
