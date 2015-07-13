<?php
readfile('navigation.file.html');
?>

<!DOCTYPE html>
<html>
<head>
	<title>BHRA Leaf Raking</title>
</head>
<body>
	<?php

echo '<fieldset><legend> Available: </legend>';
	$d = dir('upload');
// DEBUG
//echo "Handle: " . $d->handle . "<br>";
//echo "Path: " . $d->path . "<br>";
while (false !== ($entry = $d->read())) {
	  if($entry != "." && $entry != "..") {

printf("
	  	<br><label> <input type=checkbox name=topping value=bacon> %s </label>",
	  	$entry
	);


//printf("
//	  	<br><label> <input type=checkbox name=topping value=bacon> Bacon </label>"
//	);
//
//				printf("
//				<li><a href=file_delete_name.php?filename=%s>delete </a>%s</li>",
//					$entry,$entry
//				);
		}
}

	<input type="submit" name="delete" value="Delete">
	<input type="submit" name="delete" value="Delete">

echo '</fieldset>';




//			<li><a href=roster_populate_from_csv.php?filename=%s>addRoster</a>%s</li>
//				<li><a href=volunteer_supervisors_populate_from_csv.php?filename=%s>addVolSupervisor</a>%s</li>
//				<li><a href=volunteer_rakers_populate_from_csv.php?filename=%s>addVolRaker</a>%s</li>",
//				$entry,$entry,
//				$entry,$entry,
//				$entry,$entry,

$d->close();
?>
</body>
</html>

