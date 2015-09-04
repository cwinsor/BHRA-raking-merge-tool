<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

/**
 *  Teams
 */
class ClassTeams
{

    public static function allTeams()
    {
        return array(
            "T1",
            "T2",
            "T3");
    }

    public static function pretty($in)
    {
        if ($in == "T1") return "TEAM_1";
        if ($in == "T2") return "TEAM_2";
        if ($in == "T3") return "TEAM_3";
        if ($in == "T4") return "TEAM_4";
        if ($in == "T5") return "TEAM_5";
        if ($in == "T6") return "TEAM_6";
        if ($in == "T7") return "TEAM_7";
        if ($in == "T8") return "TEAM_8";
        if ($in == "T9") return "TEAM_9";
        if ($in == "T10") return "TEAM_10";
    }


}
    
   