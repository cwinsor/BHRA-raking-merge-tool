<?php
require_once("my_error_handler.php");
set_error_handler("my_error_handler");
?>



<?php


function check_anynonemptystring($candidate, &$fail_string, $err_msg)
{
	if ($candidate &&
		($candidate != ''))
	{
		return $candidate;
	}
	$fail_string += " bad " . $err_msg;
	return null;
}

function check_anystring($candidate, &$fail_string, $err_msg)
{
	if ($candidate)
	{
		return $candidate;
	}
	$fail_string += " bad " . $err_msg;
	return null;
}

function check_r_cox($candidate, &$fail_string)
{
	if ($candidate &&
		($candidate === '') || ($candidate == 'coxswain'))
	{
		return $candidate;
	}
	$fail_string += " bad r_cox";
	return null;
}

function check_r_team($candidate, &$fail_string)
{
	if ($candidate &&
		($candidate === 'Novice') || ($candidate == 'Varsity'))
	{
		return $candidate;
	}
	$fail_string += " bad r_team";
	return null;
}

function check_r_gender($candidate, &$fail_string)
{
	if ($candidate &&
			($candidate === 'Male') || ($candidate == 'Female'))
	{
		return $candidate;
	}
		$fail_string += " bad gender";
	return null;
}

function check_r_school($candidate, &$fail_string)
{
	if ($candidate &&
			($candidate === 'Acton-Boxborough') || ($candidate == 'Bromfield') || ($candidate == 'Littleton'))
	{
		return $candidate;
	}
		$fail_string += " bad school";
	return null;
}

function check_r_grade($candidate, &$fail_string)
{
	if ($candidate &&
			($candidate >= 6) && ($candidate <= 12))
	{
		return $candidate;
	}
		$fail_string += " bad grade";
	return null;
}

?>




<?php
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
	$id = $_GET['id'];
} else {
	header('Location: roster_select.php');
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
	$r_team = '';
	$r_firstname = '';
	$r_lastname = '';
	$r_gender = '';
	$r_school = '';
	$r_grade = 0;
	$r_email = '';
	$r_cellphone = '';
	$r_homephone = '';
	$r_street = '';
	$r_town = '';
	$r_state = '';
	$r_zip = '';
	$p1_firstname = '';
	$p1_lastname = '';
	$p1_email = '';
	$p1_cellphone = '';
	$p2_firstname = '';
	$p2_lastname = '';
	$p2_email = '';
	$p2_cellphone = '';

	// post
	if (isset($_POST['submit'])) {
		$fail = "";

		$r_cox = check_r_cox($_POST['r_cox'], $fail);

		$r_team = check_r_team('r_team', $fail);
		$r_firstname = check_anynonemptystring('r_firstname', $fail);
		$r_lastname = check_anynonemptystring('r_lastname', $fail);
		$r_gender = check_r_gender('r_gender', $fail);
		$r_school = check_r_school('r_school', $fail);
		$r_grade = check_r_grade('r_grade', $fail);
		$r_email = check_anynonemptystring('r_email', $fail);
		$r_cellphone = check_anynonemptystring('r_cellphone', $fail);
		$r_homephone = check_anynonemptystring('r_homephone', $fail);
		$r_street = check_anynonemptystring('r_street', $fail);
		$r_town = check_anynonemptystring('r_town', $fail);
		$r_state = check_anynonemptystring('r_state', $fail);
		$r_zip = check_anynonemptystring('r_zip', $fail);
		$p1_firstname = check_anynonemptystring('p1_firstname', $fail);
		$p1_lastname = check_anynonemptystring('p1_lastname', $fail);
		$p1_email = check_anynonemptystring('p1_email', $fail);
		$p1_cellphone = check_anynonemptystring('p1_cellphone', $fail);
		$p2_firstname = check_anynonemptystring('p2_firstname', $fail);
		$p2_lastname = check_anynonemptystring('p2_lastname', $fail);
		$p2_email = check_anynonemptystring('p2_email', $fail);
		$p2_cellphone = check_anynonemptystring('p2_cellphone', $fail);

		if ($fail!="") {
			printf('bad input: %s',$fail);
		} else {

			// post to database
			$databasehost = "localhost"; 
			$databasename = "bhra_raking_merge"; 
			$databasetable = "roster_raw"; 
			$databaseusername="root"; 
			$databasepassword = ""; 

			$db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
			$sql = sprintf("UPDATE $databasetable SET 
				r_cox='%s',
				r_team='%s',
				r_firstname='%s',
				r_lastname='%s',
				r_gender='%s',

				r_school='%s',
				r_grade=%d,

				r_email='%s',
				r_cellphone='%s',
				r_homephone='%s',

				r_street='%s',
				r_town='%s',
				r_state='%s',
				r_zip='%s',

				p1_firstname='%s',
				p1_lastname='%s',
				p1_email='%s',
				p1_cellphone='%s',

				p2_firstname='%s',
				p2_lastname='%s',
				p2_email='%s',
				p2_cellphone='%s',
				WHERE id='%s';",
				mysqli_real_escape_string($db, $r_cox),
				mysqli_real_escape_string($db, $r_team),
				mysqli_real_escape_string($db, $r_firstname),
				mysqli_real_escape_string($db, $r_lastname),
				mysqli_real_escape_string($db, $r_gender),

				mysqli_real_escape_string($db, $r_school),
				$r_grade,

				mysqli_real_escape_string($db, $r_email),
				mysqli_real_escape_string($db, $r_cellphone),
				mysqli_real_escape_string($db, $r_homephone),

				mysqli_real_escape_string($db, $r_street),
				mysqli_real_escape_string($db, $r_town),
				mysqli_real_escape_string($db, $r_state),
				mysqli_real_escape_string($db, $r_zip),

				mysqli_real_escape_string($db, $p1_firstname),
				mysqli_real_escape_string($db, $p1_lastname),
				mysqli_real_escape_string($db, $p1_email),
				mysqli_real_escape_string($db, $p1_cellphone),

				mysqli_real_escape_string($db, $p2_firstname),
				mysqli_real_escape_string($db, $p2_lastname),
				mysqli_real_escape_string($db, $p2_email),
				mysqli_real_escape_string($db, $p2_cellphone),
				$id);

mysqli_query($db, $sql);
mysqli_close($db);
}

} else {
// GET
// if not post then prefill the fields
// using current values from database

	$databasehost = "localhost"; 
	$databasename = "bhra_raking_merge"; 
	$databasetable = "roster_raw"; 
	$databaseusername="root"; 
	$databasepassword = ""; 

	$db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
	$sql = sprintf('SELECT * FROM %s WHERE id=%s', $databasetable, $id);
	$result = mysqli_query($db, $sql);
	mysqli_close($db);

	foreach ($result as $row) {
		$r_cox = $row['r_cox'];
		$r_team = $row['r_team'];
		$r_firstname = $row['r_firstname'];
		$r_lastname = $row['r_lastname'];
		$r_gender = $row['r_gender'];
		$r_school = $row['r_school'];
		$r_grade = $row['r_grade'];
		$r_email = $row['r_email'];
		$r_cellphone = $row['r_cellphone'];
		$r_homephone = $row['r_homephone'];
		$r_street = $row['r_street'];
		$r_town = $row['r_town'];
		$r_state = $row['r_state'];
		$r_zip = $row['r_zip'];
		$p1_firstname = $row['p1_firstname'];
		$p1_lastname = $row['p1_lastname'];
		$p1_email = $row['p1_email'];
		$p1_cellphone = $row['p1_cellphone'];
		$p2_firstname = $row['p2_firstname'];
		$p2_lastname = $row['p2_lastname'];
		$p2_email = $row['p2_email'];
		$p2_cellphone = $row['p2_cellphone'];
	}
}
?>


</p>
<form method="post" actions="">

	r_cox : <input type="text" name="r_cox" value="<?php echo htmlspecialchars($r_cox); ?>"><br>
	r_team: <input type="text" name="r_team" value="<?php echo htmlspecialchars($r_team); ?>"><br>
	r_firstname: <input type="text" name="r_firstname" value="<?php echo htmlspecialchars($r_firstname); ?>"><br>
	r_lastname: <input type="text" name="r_lastname" value="<?php echo htmlspecialchars($r_lastname); ?>"><br>
	r_gender: <input type="text" name="r_gender" value="<?php echo htmlspecialchars($r_gender); ?>"><br>
	r_school: <input type="text" name="r_school" value="<?php echo htmlspecialchars($r_school); ?>"><br>
	r_grade: <input type="text" name="r_grade" value="<?php echo htmlspecialchars($r_grade); ?>"><br>
	r_email: <input type="text" name="r_email" value="<?php echo htmlspecialchars($r_email); ?>"><br>
	r_cellphone: <input type="text" name="r_cellphone" value="<?php echo htmlspecialchars($r_cellphone); ?>"><br>
	r_homephone: <input type="text" name="r_homephone" value="<?php echo htmlspecialchars($r_homephone); ?>"><br>
	r_street: <input type="text" name="r_street" value="<?php echo htmlspecialchars($r_street); ?>"><br>
	r_town: <input type="text" name="r_town" value="<?php echo htmlspecialchars($r_town); ?>"><br>
	r_state: <input type="text" name="r_state" value="<?php echo htmlspecialchars($r_state); ?>"><br>
	r_zip: <input type="text" name="r_zip" value="<?php echo htmlspecialchars($r_zip); ?>"><br>
	p1_firstname: <input type="text" name="p1_firstname" value="<?php echo htmlspecialchars($p1_firstname); ?>"><br>
	p1_lastname: <input type="text" name="p1_lastname" value="<?php echo htmlspecialchars($p1_lastname); ?>"><br>
	p1_email: <input type="text" name="p1_email" value="<?php echo htmlspecialchars($p1_email); ?>"><br>
	p1_cellphone: <input type="text" name="p1_cellphone" value="<?php echo htmlspecialchars($p1_cellphone); ?>"><br>
	p2_firstname: <input type="text" name="p2_firstname" value="<?php echo htmlspecialchars($p2_firstname); ?>"><br>
	p2_lastname: <input type="text" name="p2_lastname" value="<?php echo htmlspecialchars($p2_lastname); ?>"><br>
	p2_email: <input type="text" name="p2_email" value="<?php echo htmlspecialchars($p2_email); ?>"><br>
	p2_cellphone: <input type="text" name="p2_cellphone" value="<?php echo htmlspecialchars($p2_cellphone); ?>"><br>

	<input type="submit" name="submit" value="Submit">
</form>
<?php echo "<br>$sql<br>"; ?>

</body>

</html>

