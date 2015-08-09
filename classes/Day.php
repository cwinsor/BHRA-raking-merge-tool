<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

abstract class Day extends BasicEnum
{

    const NOV_1 = "11/1/15";

    const NOV_2 = "11/2/15";

    const NOV_8 = "11/8/15";
}