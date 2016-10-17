<?php
require "aaaStandardIncludes.php";
$ini = parse_ini_file($GLOBALS['meatpacker_config_file']);
?>

<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>

    <?php
    ob_start();
    $url = $ini['publish_url'] . $ini['publish_schedule_filename'];
    header('Location: ' . $url);
    ob_end_flush();
    die();
    ?>

</html>
