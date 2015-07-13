<?php
readfile('navigation.file.html');
?>

<!DOCTYPE html>
<html>
<head>
	<title>BHRA Leaf Raking</title>
</head>
<body>
<p>Host:</p>
	<?php
	$d = dir('upload');
// DEBUG
echo "Handle: " . $d->handle . "<br>";
echo "Path: " . $d->path . "<br>";
while (false !== ($entry = $d->read())) {
 //  echo $entry."<br>";
			printf("\n");
			printf('<li><a href="file_delete_name.php?filename=%s">delete</a>%s</li>',
				$entry,
				$entry
				);
		}
$d->close();
?>

<p>Host:</p>

<?php
$path = 'upload';
$dh = opendir($path);
$i=1;
while (($file = readdir($dh)) !== false) {
    if($file != "." && $file != "..") {
        echo "$i. <a href='$path/$file'>$file</a><br />";
        $i++;
    }
}
closedir($dh);
?>



</body>
</html>

