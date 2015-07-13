<?php
require_once("my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php
require_once("roster_checking_functions.php");
?>


<?php
	$r_cox = '';
	$r_team = '';
	$r_firstname = '';
	$r_lastname = '';
	$r_gender = '';
	$r_school = '';
	$r_grade = '';
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

// SUBMIT BUTTON
	if (isset($_POST['submit'])) {

		// check the content of the form
		$fail = '';
		check_string_against_list    ($_POST['r_cox'], 'r_cox', $r_cox, $fail, array('','coxswain'));
		check_string_against_list    ($_POST['r_team'], 'r_team', $r_team, $fail, array('Novice','Varsity'));
		check_string_empty_string_bad($_POST['r_firstname'], 'r_firstname', $r_firstname, $fail);
		check_string_empty_string_bad($_POST['r_lastname'], 'r_lastname', $r_lastname, $fail);
		check_string_against_list    ($_POST['r_gender'], 'r_gender', $r_gender, $fail, array('Male','Female'));
		check_string_against_list    ($_POST['r_school'], 'r_school', $r_school, $fail, array('Bromfield','Acton-Boxborough','Littleton'));
		check_string_against_list    ($_POST['r_grade'], 'r_grade', $r_grade, $fail, array('12','11','10','9','8','7'));

		check_string_empty_string_bad($_POST['r_email'], 'r_email', $r_email, $fail);
		check_string_empty_string_bad($_POST['r_cellphone'], 'r_cellphone', $r_cellphone, $fail);
		check_string_empty_string_bad($_POST['r_homephone'], 'r_homephone', $r_homephone, $fail);
		check_string_empty_string_bad($_POST['r_street'], 'r_street', $r_street, $fail);
		check_string_empty_string_bad($_POST['r_town'], 'r_town', $r_town, $fail);
		check_string_empty_string_bad($_POST['r_cellphone'], 'r_cellphone', $r_cellphone, $fail);
		check_string_empty_string_bad($_POST['r_state'], 'r_state', $r_state, $fail);
		check_string_empty_string_bad($_POST['r_zip'], 'r_zip', $r_zip, $fail);

		check_string_empty_string_bad($_POST['p1_firstname'], 'p1_firstname', $p1_firstname, $fail);
		check_string_empty_string_bad($_POST['p1_lastname'], 'p1_lastname', $p1_lastname, $fail);
		check_string_empty_string_bad($_POST['p1_email'], 'p1_email', $p1_email, $fail);
		check_string_empty_string_bad($_POST['p1_cellphone'], 'p1_cellphone', $p1_cellphone, $fail);

		check_string_empty_string_bad($_POST['p2_firstname'], 'p2_firstname', $p2_firstname, $fail);
		check_string_empty_string_bad($_POST['p2_lastname'], 'p2_lastname', $p2_lastname, $fail);
		check_string_empty_string_bad($_POST['p2_email'], 'p2_email', $p2_email, $fail);
		check_string_empty_string_bad($_POST['p2_cellphone'], 'p2_cellphone', $p2_cellphone, $fail);

		// if contents of form are bad - print msg
		if ($fail!='') {
			printf('bad input: %s', $fail);
		} else
		// if contents of the form are good - send to database
		{
			
			$databasehost = "localhost"; 
			$databasename = "bhra_raking_merge"; 
			$databasetable = "roster_raw"; 
			$databaseusername="root"; 
			$databasepassword = ""; 

			$db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
			$sql = sprintf("INSERT INTO $databasetable (
				r_cox,
				r_team,
				r_firstname,
				r_lastname,
				r_gender,

				r_school,
				r_grade,

				r_email,
				r_cellphone,
				r_homephone,

				r_street,
				r_town,
				r_state,
				r_zip,

				p1_firstname,
				p1_lastname,
				p1_email,
				p1_cellphone,

				p2_firstname,
				p2_lastname,
				p2_email,
				p2_cellphone) VALUES (
				'%s','%s','%s','%s','%s',
				'%s','%s',
				'%s','%s','%s',
				'%s','%s','%s','%s',
				'%s','%s','%s','%s',
				'%s','%s','%s','%s');",
			mysqli_real_escape_string($db, $r_cox),
			mysqli_real_escape_string($db, $r_team),
			mysqli_real_escape_string($db, $r_firstname),
			mysqli_real_escape_string($db, $r_lastname),
			mysqli_real_escape_string($db, $r_gender),

			mysqli_real_escape_string($db, $r_school),
			mysqli_real_escape_string($db, $r_grade),

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
			mysqli_real_escape_string($db, $p2_cellphone));

$rtn = mysqli_query($db, $sql);
mysqli_close($db);
// DEBUG
//trigger_error("to database: $sql", E_USER_NOTICE);
if (!$rtn)
{
	trigger_error("database was not happy: $sql", E_USER_NOTICE);
} else
{
// insert is done - redirect to select
	header('Location: roster_select.php');
}
}
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
<form method="post" actions="">

	r_cox : <input type="text" name="r_cox" value="<?php echo htmlspecialchars($r_cox);?>"><br>
	r_team: <input type="text" name="r_team" value="<?php echo htmlspecialchars($r_team);?>"><br>
	r_firstname: <input type="text" name="r_firstname" value="<?php echo htmlspecialchars($r_firstname);?>"><br>
	r_lastname: <input type="text" name="r_lastname" value="<?php echo htmlspecialchars($r_lastname);?>"><br>
	r_gender: <input type="text" name="r_gender" value="<?php echo htmlspecialchars($r_gender);?>"><br>
	r_school: <input type="text" name="r_school" value="<?php echo htmlspecialchars($r_school);?>"><br>
	r_grade: <input type="text" name="r_grade" value="<?php echo htmlspecialchars($r_grade);?>"><br>
	r_email: <input type="text" name="r_email" value="<?php echo htmlspecialchars($r_email);?>"><br>
	r_cellphone: <input type="text" name="r_cellphone" value="<?php echo htmlspecialchars($r_cellphone);?>"><br>
	r_homephone: <input type="text" name="r_homephone" value="<?php echo htmlspecialchars($r_homephone);?>"><br>
	r_street: <input type="text" name="r_street" value="<?php echo htmlspecialchars($r_street);?>"><br>
	r_town: <input type="text" name="r_town" value="<?php echo htmlspecialchars($r_town);?>"><br>
	r_state: <input type="text" name="r_state" value="<?php echo htmlspecialchars($r_state);?>"><br>
	r_zip: <input type="text" name="r_zip" value="<?php echo htmlspecialchars($r_zip);?>"><br>
	p1_firstname: <input type="text" name="p1_firstname" value="<?php echo htmlspecialchars($p1_firstname);?>"><br>
	p1_lastname: <input type="text" name="p1_lastname" value="<?php echo htmlspecialchars($p1_lastname);?>"><br>
	p1_email: <input type="text" name="p1_email" value="<?php echo htmlspecialchars($p1_email);?>"><br>
	p1_cellphone: <input type="text" name="p1_cellphone" value="<?php echo htmlspecialchars($p1_cellphone);?>"><br>
	p2_firstname: <input type="text" name="p2_firstname" value="<?php echo htmlspecialchars($p2_firstname);?>"><br>
	p2_lastname: <input type="text" name="p2_lastname" value="<?php echo htmlspecialchars($p2_lastname);?>"><br>
	p2_email: <input type="text" name="p2_email" value="<?php echo htmlspecialchars($p2_email);?>"><br>
	p2_cellphone: <input type="text" name="p2_cellphone" value="<?php echo htmlspecialchars($p2_cellphone);?>"><br>

	<input type="submit" name="submit" value="Submit">

</form>
</body>
</html>
