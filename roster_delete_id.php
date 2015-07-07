<?php

// deletes an individual record given ID

function roster_delete_id(
	$databasehost,
	$databasename,
	$databasetable,
	$databaseusername,
	$databasepassword,
	$id)
{

	$db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
	$sql = "DELETE FROM $databasetable WHERE id=$id";
	mysqli_query($db, $sql);
	mysqli_close($db);
}
?>
