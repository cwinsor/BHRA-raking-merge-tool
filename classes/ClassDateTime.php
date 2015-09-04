<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

/**
 * Date/Time
 */
class ClassDateTime
{


    /*
     * Construct using a given date/time in standard internal format
    * 2015-12-30 13:30
          */
    function __construct($in)
    {
        $this->dateTime = new DateTime();

        if ($in != "") {
            list($year_month_day, $hr_min) = explode(" ", $in);
            $this->setDate($year_month_day);
            $this->setTime($hr_min);
        }
    }

    public function setDate($in)
    {
        list($year, $month, $day) = explode("-", $in);
        $this->dateTime->setDate($year, $month, $day);
    }

    public function setTime($in)
    {
        list($hour, $minute) = explode(":", $in);
        $this->dateTime->setTime($hour, $minute);
    }

    /**
     * get date/time - standard internal format
     * 2015-12-30 13:30
     */
    public function get()
    {
        return $this->dateTime->format('d-M-y H:i');
    }

    public function getDate()
    {
        return $this->dateTime->format('d-M-y');
    }

    public function getTime()
    {
        return $this->dateTime->format('H:i');
    }


    /**
     * get date/time - pretty format
     * Monday, 15-Aug-2005 15:52)
     */
    public function getPretty()
    {
        return $this->dateTime->format('l, d-M-Y H:i');
    }

    public function getPrettyDate()
    {
        return $this->dateTime->format('l, d-M-Y');
    }

    public function getPrettyTime()
    {
        return $this->dateTime->format('H:i');
    }


    /**
     * return standard format date given input which is VolunteerSpot format date
     * input:
     * 7/20/2015
     * output:
     * 2015-12-30
     */
    public static function dateFromVolunteerspotFormat($inDate)
    {
        $temp = explode("/", $inDate);
        if (count($temp) != 3) {
            throw new Exception('in --> dateFromVolunteerspotFormat');
        }
        list($month, $day, $year) = explode("/", $inDate);
        return ($year . "-" . $month . "-" . $day);
    }


    /**
     * return standard format time given input which is VolunteerSpot format time
     * input:
     *   8:00 AM
     *  12:30 PM
     *   1:30 PM
     * output:
     *  13:30
     */
    public static function timeFromVolunteerspotFormat($inTime)
    {

        list($hr_min, $am_pm) = explode(" ", $inTime);
        list($hour, $minute) = explode(":", $hr_min);
        if (($am_pm == "PM") && ($hour != 12)) {
            $hour += 12;
        }
        return ($hour . ":" . $minute);
    }


    /**
     * return standard format date given input which is SuperSAAS format date/time
     * input:
     *  11/9/2014 14:30
     * output:
     *  2015-12-30
     */
    public static function dateFromSupersaasFormat($in)
    {
        echo "<br>zona 443344";
        var_dump($in);
        echo "<br>zona 443344";

        list($date, $time) = explode(" ", $in);
        list($month, $day, $year) = explode("/", $date);

        return ($year . "-" . $month . "-" . $day);
    }

    /**
     * return standard format time given input which is SuperSAAS format date/time
     * input:
     *  11/9/2014 14:30
     * output:
     *  13:30
     */
    public static function timeFromSupersaasFormat($in)
    {
        list($date, $time) = explode(" ", $in);
        list($hour, $minute) = explode(":", $time);

        return ($hour . ":" . $minute);
    }


    public static function allDays()
    {
        return array(
            "2015-7-4",
            "2015-7-5");
    }


    public static function allTimes()
    {
        return array_merge(ClassDateTime::allTimesAmOrPm("AM"), ClassDateTime::allTimesAmOrPm("PM"));
    }

    public static function allTimesAmOrPm($amOrPm)
    {
        if ($amOrPm == "AM") {
            return array(
                "8:00",
                "8:30",
                "9:00",
                "9:30",
                "10:00",
                "10:30",
                "11:00",
                "11:30");
        }
        if ($amOrPm == "PM") {
            return array(
                "12:00",
                "12:30",
                "13:00",
                "13:30",
                "14:00",
                "14:30",
                "15:00",
                "15:30",
                "16:00",
                "16:30",
                "17:00",
                "17:30");

            exit ("zona 25546 programming error");
        }
    }

    public
    static function allAmPm()
    {
        return array(
            "AM",
            "PM");
    }
}
    
   