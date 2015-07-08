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
<p><?php

// SUBMIT BUTTON
if (isset($_POST['submit']))
{

echo '<br>';
	var_dump($_FILES);
echo '<br>';

	// Check if there are any errors in the upload
	if($_FILES['file_upload']['error'] > 0){
		die('An error ocurred when uploading.');
	}

	// Check if the file type is allowed
	if($_FILES['file_upload']['type'] != 'application/vnd.ms-excel'){
		die('Unsupported filetype uploaded.');
	}

	// Check that the file is under our file size limit
	if($_FILES['file_upload']['size'] > 500000){
		die('File uploaded exceeds maximum upload size.');
	}

	// Check that the file doesn't already exist (based on name)
	//if(file_exists('upload/' . $_FILES['file_upload']['name'])){
	//	die('File with that name already exists.');
	//}

	// Finally upload the file
	if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], 'upload/' . $_FILES['file_upload']['name'])){
		die('Error uploading file - check destination is writeable.');
	}
}
?>

</p>
</body>
</html>






