<?php
include_once "aaaStandardIncludes.php";
?>

<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php
pickupGetIfSet("filename", $getFilename);
?>


<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta
        http-equiv="content-type"
        content="text/html;  charset=utf-8"
        >
    <link
        href="../navigation/style.css"
        rel="stylesheet"
        type="text/css"
        >

</head>
<body>


<div id="navigation">
    <?php
    include '../navigation/functions.php';
    Navigation();
    ?>
</div>


<div id="content">

    <h3>Itinerary</h3>

    <?php
    if ($GLOBALS['debug']) {
        echo '<br>' . '--- PARAMETERS FROM POST ---' . '<br>';
        echo '<br>' . var_dump($_POST);
        echo '<br>';

        echo '<br>' . '--- PARAMETERS FROM GET ---' . '<br>';
        echo '<br>' . var_dump($_GET);
        echo '<br>';
    }
    ?>

    <?php


    // get volunteer rakers from database
    $tableVolunteerRakers = new ControllerTable("volunteerspot_rakers", "VOLUNTEER RAKERS");
    $tableVolunteerRakers->databaseRead(new ControllerRowVolunteerSpotRaker());
    $tableVolunteerRakers->viewAsHtmlTable();

    // get customer appointments from database
    $tableAppointments = new ControllerTable("appointments", "APPOINTMENTS");
    $tableAppointments->databaseRead(new ControllerRowAppointment());
    $tableAppointments->viewAsHtmlTable();


    $days = array(
        "2011-9-2014 14:30:00",
        "2011-10-2014 14:30:00");
    $teamNumbers = array(
        "TEAM1",
        "TEAM2");
    $amPms = array(
        "AM",
        "PM");
    $appointmentStartTimes = array(
        "08:00:00",
        "08:30:00",
        "09:00:00",
        "09:30:00",
        "10:00:00",
        "10:30:00",
        "11:00:00",
        "11:30:00",
        "12:00:00",
        "12:30:00",
        "13:00:00",
        "13:30:00",
        "14:00:00",
        "14:30:00",
        "15:00:00",
        "15:30:00",
        "16:00:00",
        "16:30:00",
        "17:00:00",
        "17:30:00");


    // the order for final printout is  day / teamNumber / amPm
    // the order for task assignment is day / amPm / teamNumber

    foreach ($days as $day) {


        foreach (array("AM", "PM") as $amPmm) {
            echo "<br>---------- $day --- $amPmm ----------<br>";

            $shiftStartTime = ($amPmm == "AM") ? "08:30:00" : "12:00:00";

            echo "<br>CURRENT ASSIGNMENTS:<br>";
            foreach ($teamNumbers as $teamNumber) {
                echo "<br>$teamNumber<br>";

                // SUPERVISOR
           //     echo "<br>SUPERVISORS...<br>";
                //        foreach ($supervisors as $supervisor) {} ...
                // public function isAvailable($day, $startTime);
                // public function isAssigned($day, $startTime);
                // public function isAssignedTeam($day, $startTime, $teamNumber);
                // public function assign($day, $startTime, $teamNumber);
                // public function unAssign();


                // RAKERS
                echo "<br>RAKERS...<br>";
                foreach ($tableVolunteerRakers->getTable() as $volunteerRaker) {
                    if ($volunteerRaker->isAssignedTeam($day, $shiftStartTime, $teamNumber)) {
                        // confirm they are (still) available !
                        if ($volunteerRaker->isAvailable($day, $shiftStartTime)) {
                            echo "<br>RAKER " . $volunteerRaker->modelGetField('firstname') . " " . $volunteerRaker->modelGetField('lastname') . "<br>";
                        } else {
                            echo "<br>RAKER NO LONGER AVAILABLE -> " . $volunteerRaker->modelGetField('firstname') . " " . $volunteerRaker->modelGetField('lastname') . "<br>";
                        }
                    }
                }

                // CUSTOMERS
                echo "<br>CUSTOMERS...<br>";
                foreach ($appointmentStartTimes as $appointmentStartTime) {
                    foreach ($tableAppointments->getTable() as $appointment) {
                        if ($appointment->isAssigned($day, $appointmentStartTime, $teamNumber)) {
                            // confirm the reservation still is in place !
                            if ($appointment->isAvailable($day, $appointmentStartTime)) {

                                echo "<br>CUSTOMER " . $appointment->modelGetField('CustName') . "<br>";
                            } else {
                                echo "<br>CUSTOMER NO LONGER AVAILABLE -> " . $appointment->modelGetField('CustName') . "<br>";

                            }
                        }
                    }
                }
            }

            echo "<br>UNASSIGNED:<br>";

            // SUPERVISOR
            //     echo "<br>UNASSIGNED SUPERVISORS...<br>";
            //        foreach ($supervisors as $supervisor) {} ...

            // RAKERS
            echo "<br>UNASSIGNED RAKERS...<br>";
            foreach ($tableVolunteerRakers->getTable() as $volunteerRaker) {
                // need to assign
                if ($volunteerRaker->isAvailable($day, $shiftStartTime) && !$volunteerRaker->isAssigned($day, $shiftStartTime)) {
                    echo "<br>RAKER " . $volunteerRaker->modelGetField('firstname') . " " . $volunteerRaker->modelGetField('lastname') . "<br>";
                }
            }

            // CUSTOMERS
            echo "<br>UNASSIGNED CUSTOMERS...<br>";
            foreach ($appointmentStartTimes as $appointmentStartTime) {
                foreach ($tableAppointments->getTable() as $appointment) {
                    if ($appointment->isAvailable($day, $appointmentStartTime) && !$appointment->isAssigned($day, $appointmentStartTime)) {
                        echo "<br>CUSTOMER " . $appointment->modelGetField('CustName') . "<br>";
                    }
                }


            }
        }
    }


    ?>

</div>
</body>
</html>
