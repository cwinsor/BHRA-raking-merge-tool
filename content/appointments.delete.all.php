
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
var_dump($_GET);
var_dump($_POST);

// SUBMIT BUTTON
if (isset($_GET['DELETE_ALL']))
{
    include '../.env_database_password';
    $databasetable = "appointments";

    $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
    $sql = "DELETE FROM $databasetable";
    mysqli_query($db, $sql);
    mysqli_close($db);
}

// delete is done - redirect
header('Location: appointments.php');

?>

