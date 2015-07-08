
<?php
//
// reference:
// http://codular.com/php-file-uploads
//
require_once("my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php
readfile('navigation.tmpl.html');
?>
<!DOCTYPE html>
<html>
<head>
	<title>BHRA Leaf Raking</title>
</head>
<body>
	
	<form action="roster_file_accept.php" method="post" enctype="multipart/form-data">
		File: <input type="file" name="file_upload">
		<input type="submit" name="submit" value="Submit">
	</form>
</body>
</html>



