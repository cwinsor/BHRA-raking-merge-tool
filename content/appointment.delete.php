
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
if (isset($_GET['id']) && ctype_digit($_GET['id']))
{
    $id = $_GET['id'];
} else
{
   header('Location: appointments.php');
}
?>


<?php
include '../.env_database_password';
$databasetable = "appointments";

$db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
$sql = "DELETE FROM $databasetable WHERE id_appt=$id";
mysqli_query($db, $sql);
mysqli_close($db);

// delete is done - redirect
header('Location: appointments.php');
?>

