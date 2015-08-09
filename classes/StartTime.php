<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

abstract class Workshift extends BasicEnum
{

    const T_8_30 = "8:30";

    const T_10_00 = "10:00";

    const T_10_30 = "10:30";

    const T_11_30 = "11:30";

    const T_1_00 = "1:00";

    const T_2_30 = "2:30";

    const T_3_00 = "3:00";

    const T_4_00 = "4:00";

    /*
     * convert to an AmPm
     */
    public static function toAmPm($in)
    {
        if (($in == T_8_30) || ($in == T_10_00) || ($in == T_10_30) || ($in == T_11_30))
        {
            return AmPm::AM;
        }
        if (($in == T_1_00) || ($in == T_2_30) || ($in == T_3_00) || ($in == T_4_00))
        {
            return AmPm::PM;
        }
        trigger_error("error when trying to convert $in to AM/PM", E_USER_ERROR);
        return null;
    }
}