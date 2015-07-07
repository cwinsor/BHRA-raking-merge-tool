<?php
require_once("my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php
function check_r_cox($candidate, &$fail_string)
{
	// can be empty string
	// can be submitted as ''
	// can be submitted as 'coxswain'
	if 	((!$candidate) || 
		($candidate && ($candidate == '')) ||
		($candidate && ($candidate == 'coxswain')))
	{
		return $candidate;
	}
	$fail_string .= " r_cox=" . $candidate;
		return '';
}
?>


<?php
function check_anynonemptystring($candidate, &$fail_string, $err_msg)
{
	// can be any non-empty string
	if ($candidate && ($candidate != ''))
	{
		return $candidate;
	}
	$fail_string .= " " . $err_msg . "=" . $candidate;
	return '';
}
?>


<?php
function check_anystring($candidate)
{
	return $candidate;
}
?>


<?php
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
	$id = $_GET['id'];
} else {
	trigger_error("id was not set", E_USER_ERROR);
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>BHRA Leaf Raking</title>
</head>
<body>
	<p><?php

	$r_cox = '';
	$r_firstname = '';
	$r_street = '';

	// SUBMIT BUTTON
	if (isset($_POST['submit'])) {

		// check the content of the form
		$fail = '';
		$r_cox = check_r_cox($_POST['r_cox'], $fail);
		$r_firstname = check_anynonemptystring($_POST['r_firstname'], $fail, 'r_firstname');
		$r_street = check_anystring($_POST['r_street']);

		// if contents of form are bad - print msg
		if ($fail!='') {
			printf('bad input: %s', $fail);
		} else
		// if contents of the form are good - send to database
		{
			
			$databasehost = "localhost"; 
			$databasename = "bhra_raking_merge"; 
			$databasetable = "xx_test"; 
			$databaseusername="root"; 
			$databasepassword = ""; 

			$db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
			$sql = sprintf("UPDATE $databasetable SET
				r_cox='%s',
				r_firstname='%s',
				r_street='%s'
				WHERE id=%d",
				mysqli_real_escape_string($db, $r_cox),
				mysqli_real_escape_string($db, $r_firstname),
				mysqli_real_escape_string($db, $r_street),
				$id);
			mysqli_query($db, $sql);
			mysqli_close($db);
// DEBUG
trigger_error("to database: $sql", E_USER_NOTICE);
		}
	} else
	// NO SUBMIT BUTTON
	{
		// create the form.. pre-filling fields from the database
		// prefill the fields using current values from database
		$databasehost = "localhost"; 
		$databasename = "bhra_raking_merge"; 
		$databasetable = "xx_test"; 
		$databaseusername="root"; 
		$databasepassword = ""; 

		$db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
		$sql = sprintf('SELECT * FROM %s WHERE id=%d', $databasetable, $id);
		$result = mysqli_query($db, $sql);
		mysqli_close($db);
// DEBUG
//trigger_error("to database: $sql", E_USER_NOTICE);

		foreach ($result as $row) {
			$r_cox = $row['r_cox'];
			$r_firstname = $row['r_firstname'];
			$r_street = $row['r_street'];
		}
	}
	?>
</p>
<form method="post" actions="">
	r_cox : <input type="text" name="r_cox" value="<?php echo htmlspecialchars($r_cox);?>"><br>
	r_firstname : <input type="text" name="r_firstname" value="<?php echo htmlspecialchars($r_firstname);?>"><br>
	r_street : <input type="text" name="r_street" value="<?php echo htmlspecialchars($r_street);?>"><br>
	<input type="submit" name="submit" value="Submit">

</form>
</body>
</html>
