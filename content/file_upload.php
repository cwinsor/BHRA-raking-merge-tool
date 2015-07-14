<!-- 
	reference:  http://codular.com/php-file-uploads
-->

<div  id="navigation">
	<?php
	include '../navigation/functions.php';
	Navigation();
	?>
</div>


<?php
require_once("../my_error_handler.php");
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
	if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], '../upload/' . $_FILES['file_upload']['name'])){
		$msg .= 'Error uploading file - check destination is writeable.';		
		// die('Error uploading file - check destination is writeable.');
	}
}
?>



<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html;  charset=utf-8">
	<link href="../navigation/style.css" rel="stylesheet"  type="text/css" />
</head>
<body>
	<div id="navigation"></div>

	<div id="content">

		<form action="file_upload.php" method="post" enctype="multipart/form-data">
	
		<fieldset><legend> Files: </legend>
<!--		<style>
		nav>ul { list-style-type: none; }
		nav>ul>li { display: inline; }
		</style>
	-->
			<ul>
			<?php
			$d = dir('../upload');
// DEBUG
//echo "Handle: " . $d->handle . "<br>";
//echo "Path: " . $d->path . "<br>";
			while (false !== ($entry = $d->read())) {
				if($entry != "." && $entry != "..") {
					printf("<li>%s</li>",$entry);
				}
			}
			$d->close();
			?>
			</ul>
		</fieldset>

		<fieldset><legend> Upload: </legend>
		(C:\Users\cwinsor\Documents\me\BHRA_2015\Leaf Raking)
		<br><label>File<input type="file" name="file_upload" multiple></label>
		<br><input type="submit" name="submit" value="Submit">
		</fieldset>

		</form>
		</div>
		<br>
			<?php
			if (isset($_POST['submit'])) {
				echo ($msg=='') ? 'upload done' : $msg;
			}
			?>

		</body>
		</html>
