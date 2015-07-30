
<div id="navigation">
	<?php
include '../navigation/functions.php';
Navigation();
?>
</div>


<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php
// reads volunteer list from .csv file into sql database
// reference:
// http://stackoverflow.com/questions/20876043/php-script-to-import-csv-data-into-mysql
$msg = '';

// back to roster
if (isset($_POST['roster']))
{
    header('Location: roster.php');
}

if (! array_key_exists('fileName', $_POST))
{
    $msg .= "no file specified";
} else
{
    $csvfile = '../upload/' . $_POST['fileName'];
    if (! file_exists($csvfile))
    {
        $msg = "File not found. Make sure you specified the correct path." . $csvfile;
    } else
    {
        $fieldseparator = ",";
        $lineseparator = "\n";

        include '../.env_database_password';
        $databasetable = "roster_raw";

        try
        {
            $pdo = new PDO("mysql:host=$databasehost;dbname=$databasename", $databaseusername, $databasepassword, array(
                PDO::MYSQL_ATTR_LOCAL_INFILE => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ));
        } catch (PDOException $e)
        {
            trigger_error("database connection failed: " . $e->getMessage(), E_USER_ERROR);
        }
        
        $affectedRows = $pdo->exec("
			LOAD DATA LOCAL INFILE " . $pdo->quote($csvfile) . " INTO TABLE `$databasetable`
			FIELDS TERMINATED BY " . $pdo->quote($fieldseparator) . "
			LINES TERMINATED BY " . $pdo->quote($lineseparator));
        
        $msg = "Loaded a total of $affectedRows records";
    }
}
?>



<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html;  charset=utf-8">
<link href="../navigation/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="navigation"></div>

	<div id="content">
		<form action="roster.add.from.file.php" method="post">
			<fieldset>
				<legend> Files: </legend>
				<?php
    $d = dir('../upload');
    // DEBUG
    // echo "Handle: " . $d->handle . "<br>";
    // echo "Path: " . $d->path . "<br>";
    while (false !== ($entry = $d->read()))
    {
        if ($entry != "." && $entry != "..")
        {
            printf("
							<br><label> <input type=radio name=fileName value=\"%s\"> %s  </label> \n", $entry, $entry);
        }
    }
    $d->close();
    echo '<p><input type=submit name=submit value=Submit>';
    echo '<p><input type=submit name=roster value=Roster>';
    echo '<p>' . $msg;
    ?>
				</fieldset>
		</form>
	</div>
</body>
</html>
