<?php
readfile('navigation.tmpl.html');
?>

<!DOCTYPE html>
<html>
<head>
	<title>BHRA Leaf Raking</title>
</head>
<body>
	<?php
	$d = dir('upload');
echo "Handle: " . $d->handle . "<br>";
echo "Path: " . $d->path . "<br>";
while (false !== ($entry = $d->read())) {
 //  echo $entry."<br>";
			printf("\n");
			printf('
				<li>
				<a href="file_delete_name.php?filename=%s">delete</a>
				%s
				</li>',
				$entry,
				$entry
				);
		}

$d->close();
?>
</body>
</html>

