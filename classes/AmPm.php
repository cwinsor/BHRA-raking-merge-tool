<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

abstract class AmPm extends BasicEnum
{

    const AM = 30;

    const PM = 31;
}