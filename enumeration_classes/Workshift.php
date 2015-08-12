<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

abstract class Workshift extends BasicEnum
{

    const NOV_1_AM = 20;

    const NOV_1_PM = 21;

    const NOV_2_AM = 22;

    const NOV_2_PM = 23;

    const NOV_8_AM = 24;

    /*
     * convert to an AmPm
     */
    public static function toAmPm($in)
    {
        if ($in == NOV_1_AM)
        {
            return AmPm::AM;
        }
        if ($in == NOV_1_PM)
        {
            return AmPm::PM;
        }
        if (this == NOV_2_AM)
        {
            return AmPm::AM;
        }
        if (this == NOV_2_PM)
        {
            return AmPm::PM;
        }
        trigger_error("error when trying to convert $in to AM/PM", E_USER_ERROR);
        return null;
    }
}