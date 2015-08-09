<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

abstract class Role extends BasicEnum
{

    const RAKER = 30;

    const SUPERVISOR = 31;

    const CUSTOMER = 32;
}