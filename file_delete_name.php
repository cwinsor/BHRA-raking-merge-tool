<?php
require_once("my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php
if (isset($_GET['filename']))
{
	$filename = $_GET['filename'];
	unlink("upload/$filename");
}
// delete is done - redirect
header('Location: file_select.php');
?>


<?php
readfile('navigation.file.html');
?>

<!DOCTYPE html>
<html>
<head>
	<title>BHRA Leaf Raking</title>
</head>
<body>
</body>
</html>

