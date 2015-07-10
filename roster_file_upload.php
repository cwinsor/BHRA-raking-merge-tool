
<?php
//
// reference:
// http://codular.com/php-file-uploads
//
require_once("my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php
$msg = '';

// SUBMIT BUTTON
if (isset($_POST['submit']))
{

//echo '<br>';
//	var_dump($_FILES);
//echo '<br>';

	// Check if there are any errors in the upload
	if($_FILES['file_upload']['error'] > 0){
		$msg .= 'An error ocurred when uploading.';
		// die('An error ocurred when uploading.');
	}

	// Check if the file type is allowed
//	if($_FILES['file_upload']['type'] != 'application/vnd.ms-excel'){
//		$msg .= 'Unsupported filetype uploaded.';
//		// die('Unsupported filetype uploaded.');
//	}

	// Check that the file is under our file size limit
	if($_FILES['file_upload']['size'] > 500000){
		$msg .= 'File uploaded exceeds maximum upload size.';
		// die('File uploaded exceeds maximum upload size.');
	}

	// Check that the file doesn't already exist (based on name)
	if(file_exists('upload/' . $_FILES['file_upload']['name'])){
		$msg .= 'File with that name already exists.';
		// die('File with that name already exists.');
	}

	// Finally upload the file
	if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], 'upload/' . $_FILES['file_upload']['name'])){
		$msg .= 'Error uploading file - check destination is writeable.';		
		// die('Error uploading file - check destination is writeable.');
	}
}
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
	
	<form action="roster_file_upload.php" method="post" enctype="multipart/form-data">
	<p><label>File: <input type="file" name="file_upload"></label></p>
		<input type="submit" name="submit" value="Submit">
	</form>

<p><?php
if (isset($_POST['submit'])) {
 echo ($msg=='') ? 'upload done' : $msg;
}
?>

</body>
</html>



