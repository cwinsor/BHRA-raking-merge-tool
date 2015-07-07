<?php
readfile('navigation.tmpl.html');
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

		$db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
		$sql = "SELECT * FROM $databasetable";
		$result = mysqli_query($db, $sql);
		mysqli_close($db);

		foreach ($result as $row) {
			printf("\n");
			printf('
				<li>
				<a href="roster_update_id.php?id=%s">update</a>
				<a href="roster_delete_id.php?id=%s">delete</a>
				%d %s %s
				</li>',
				htmlspecialchars($row['id']),
				htmlspecialchars($row['id']),
				htmlspecialchars($row['id']),
				htmlspecialchars($row['r_firstname']),
				htmlspecialchars($row['r_lastname'])
				);
		}
		?>
	</ul>
</body>
</html>
