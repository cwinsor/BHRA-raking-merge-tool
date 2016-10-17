<?php
$GLOBALS['meatpacker_config_file'] = $_SERVER["DOCUMENT_ROOT"] . "/../meatpacker_config.ini";
$ini = parse_ini_file($GLOBALS['meatpacker_config_file']);

$url = $ini['publish_url'] . $ini['publish_schedule_filename'];
header('Location:' . $url);
die();
?>
