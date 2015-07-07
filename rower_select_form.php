
<?php
//readfile('tmpl_navigation.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>BHRA Leaf Raking</title>
</head>
<body>
	<ul>
		<?php
// database code
		$db = mysqli_connect('localhost', 'root', '', 'bhra_raking_merge');
		$sql = "SELECT * FROM roster_raw";
		$result = mysqli_query($db, $sql);

		foreach ($result as $row) {
			printf("\n");
			printf('<li> %d %s %s
				<a href="rower_update_form.php?id=%s">edit</a>
				<a href="rower_delete_function.php?id=%s">delete</a>
								</li>',
				htmlspecialchars($row['id']),
				htmlspecialchars($row['r_firstname']),
				htmlspecialchars($row['r_lastname']),
				htmlspecialchars($row['id']),
				htmlspecialchars($row['id'])
				);
		}
		mysqli_close($db);
		?>
	</ul>
</body>
</html>
