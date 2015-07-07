<?php

require_once("my_error_handler.php");
set_error_handler("my_error_handler");
$value = 5;
$text = "yucky";

trigger_error("this is notice with $text message about $value", E_USER_NOTICE);
trigger_error("this is warning with $text message about $value", E_USER_WARNING);
trigger_error("this is error with $text message about $value", E_USER_ERROR);
?>

