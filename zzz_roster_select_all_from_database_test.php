<?php
require_once("my_error_handler.php");
set_error_handler("my_error_handler");
?>

<!DOCTYPE html>
<html>
<head>
	<title>BHRA Leaf Raking</title>
</head>
<body>
	<ul>

		<?php
		$databasehost = "localhost"; 
		$databasename = "bhra_raking_merge"; 
		$databasetable = "roster_raw"; 
		$databaseusername="root"; 
		$databasepassword = ""; 

		$result = roster_select_all_from_database (
			$databasehost,
			$databasename,
			$databasetable,
			$databaseusername,
			$databasepassword);

		foreach ($result as $row) {
			printf("\n");
			printf('<li> %d %s %s
				<a href="form_update.php?id=%s">edit</a>
				<a href="form_delete.php?id=%s">delete</a>
				<a href="form_admin_create_login.php?id=%s">create_login</a>
				<a href="form_admin_email_login.php?id=%s">email_login</a>
				</li>',
				htmlspecialchars($row['id']),
				htmlspecialchars($row['r_firstname']),
				htmlspecialchars($row['r_lastname']),
				htmlspecialchars($row['id']),
				htmlspecialchars($row['id']),
				htmlspecialchars($row['id']),
				htmlspecialchars($row['id'])
				);
		}

		?>
	</ul>
</body>
</html>
