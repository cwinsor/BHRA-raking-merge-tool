<?php

/**
 * Date/Time
 */
class ClassDateTime
{


    /***********************************************************************/
    /* "standard format" is the format used internally for all date/times  */
    /* i.e.                                                                */
    /* 2015-12-30 13:30                                                    */
    /***********************************************************************/


    /***********************************************************************/
    /* enumerations                                                        */
    /***********************************************************************/

    public static function allDays()
    {
        return array(
            "2015-11-7",
            "2015-11-8",
            "2015-11-14",
            "2015-11-15"
        );
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

            exit ("programming error 33224455");
        }
    }

    public static function allAmPm()
    {
        return array(
            "AM",
            "PM");
    }


    /***********************************************************************/
    /* Methods to convert proprietary formats to standard format           */
    /* These are used when reading in .csv files                           */
    /***********************************************************************/


    public static function dateFromVolunteerspotFormat($inDate)
    {
        /**
         * return standard format date given VolunteerSpot format date
         * input:
         *  2015-11-07
         * output:
         *  2015-11-7  <- no leading zero
         */
        list($year, $month, $day) = explode("-", $inDate);

        // remove leading zero on date
        $day = preg_replace('/0(\d+)/', '${1}', $day);

        return ($year . "-" . $month . "-" . $day);
    }

    /**
     * return standard format time given VolunteerSpot format time
     * input:
     *   8:00 AM   (or "am")
     *  12:30 PM
     *   1:30 PM
     * output:
     *  13:30
     */
    public static function timeFromVolunteerspotFormat($inTime)
    {

        list($hr_min, $am_pm) = explode(" ", $inTime);
        list($hour, $minute) = explode(":", $hr_min);
        if ((($am_pm == "PM") || ($am_pm == "pm")) && ($hour != 12)) {
            $hour += 12;
        }
        return ($hour . ":" . $minute);

    }

    /**
     * return standard format date given SuperSAAS format date/time
     * input:
     *  11/7/2015 2:30pm
     * output:
     *  2015-11-7   <- no leading zero
     */
    public static function dateFromSupersaasFormat($in)
    {
        if ($in == "X") {
            echo "<br>error 3322554466 when attempting to get date<br>";
            exit;
        }
        if ($in == "") {
            echo "<br>error 33445544 when attemptign to get date<br>";
            exit;
        }

        list($date, $time) = explode(" ", $in);
        list($month, $day, $year) = explode("/", $date);

        return ($year . "-" . $month . "-" . $day);
    }

    /**
     * return standard format time given SuperSAAS format date/time
     * input:
     *  11/7/2015 2:00pm
     * output:
     *  13:30
     */
    public
    static function timeFromSupersaasFormat($in)
    {
        list($date, $time) = explode(" ", $in);

        // regular expression match...
        preg_match("/^(\d+)(:)(\d+)((am)|(pm))$/", $time, $keywords);
        $hour = $keywords[1];
        $minute = $keywords[3];
        if (($keywords[4] == "pm") && ($hour != 12)) {
            $hour += 12;
        }
        return ($hour . ":" . $minute);
    }



    /*************************************************************************/
    /* Methods to convert internal format into nonstandard "pretty" formats  */
    /* These methods are used only for printing, not storing                 */
    /*************************************************************************/

    // given standard format date/time - return a pretty format date
    public static function prettyDate($in)
    {
        list($year, $month, $day) = explode("-", $in);

        $myDateTime = new DateTime;
        $myDateTime->setDate($year, $month, $day);

        return $myDateTime->format('l, d-M-Y');
    }

    // given standard format date/time - return a pretty format time
    public static function prettyTime($in)
    {
        list($hour24, $minute) = explode(":", $in);

        if ($hour24 > 12) {
            return ($hour24 - 12) . ":" . $minute;
        }
        return $hour24 . ":" . $minute;
    }
}
    
   