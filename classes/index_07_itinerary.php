<?php
include_once "aaaStandardIncludes.php";
?>

<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php


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


    // handle the posts
    $postAssignRaker = "";
    foreach ($_POST as $postKey => $postVal) {
        list($firstTerm) = explode("_", $postKey);
        // see if there is a post assigning a raker to a team
        if (!is_null($firstTerm) && ($firstTerm == "assignRaker")) {
            $postAssignRaker = $postKey;
        }
    }


    echo "<br>postAssignRaker=" . $postAssignRaker . "<br>";


    //   if ($GLOBALS['debug']) {
    echo '<br>' . '--- PARAMETERS FROM POST ---' . '<br>';
    echo '<br>' . var_dump($_POST);
    echo '<br>';

    echo '<br>' . '--- PARAMETERS FROM GET ---' . '<br>';
    echo '<br>' . var_dump($_GET);
    echo '<br>';
    // }
    ?>

    <?php


    // get volunteer rakers from database
    $tableVolunteerRakers = new ControllerTable("volunteerspot_rakers", "VOLUNTEER RAKERS", new ControllerRowVolunteerSpotRaker());
    $tableVolunteerRakers->databaseRead();
    // handle posts
    if ($postAssignRaker) {
        echo "<br>zona1122 $postAssignRaker<br>";
        // assignRaker_row_date_starttime_team
        list($junk, $theRowNumber, $theDate, $theStartTime, $theTeamNumber) = explode("_", $postAssignRaker);
        $row = $tableVolunteerRakers->modelGetRow($theRowNumber);
        // remove row from database
        $tableVolunteerRakers->databaseDeleteItem($row);
        // update the local row copy with new assignment
        $row->assign($theDate, $theStartTime, $theTeamNumber);
        // write updated row to database
        $tableVolunteerRakers->databaseAddItem($row);

    }
    // re-read
    $tableVolunteerRakers->databaseRead();
    $tableVolunteerRakers->viewAsHtmlTable();

    // get customer appointments from database
    $tableAppointments = new ControllerTable("appointments", "APPOINTMENTS", new ControllerRowAppointment());
    $tableAppointments->databaseRead();
    $tableAppointments->viewAsHtmlTable();


    $days = ClassDateTime::allDays();
    $appointmentStartTimes = ClassDateTime::allTimes();
    $amPmList = ClassDatetime::allAmPm();


    $teamNumbers = ClassTeams::allTeams();


    // the order for final printout is  day / teamNumber / amPm
    // the order for task assignment is day / amPm / teamNumber


    ///////////////////////////////////////////
    // generate html
    echo "<form method = post> ";

    /***************************************************/
    /* THE FOLLOWING IS PRINTED SCHEDULE FORMAT        */
    /* THIS SHOWS TEAM_X AM/PM NEXT TO ONE ANOTHER     */
    /* THIS IS DONE TO MAKE THE EQUIPMENT HANDOFF EASY */
    /***************************************************/
    //
    // Saturday 7/4/2015 - TEAM_1 - AM
    //                                   cell          home
    // Supervisor    John White     978-621-2724    123-456-7890
    // Raker         Baker White    978-621-2724    123-456-7890
    // Raker         Jill Watkins   978-621-2724    123-456-7890
    // 8:30-9:00     Customer       Sonia Chernova  22 Fifers Lane      Boxborough   978-621-2724   Please do my back yard
    // 9:30-12:00    Customer       Sonia Chernova  22 Fifers Lane      Boxborough   978-621-2724   Please do my back yard

    // Saturday 7/4/2015 - TEAM_1 - PM
    //                                   cell          home
    // Supervisor    John White     978-621-2724    123-456-7890
    // Raker         Baker White    978-621-2724    123-456-7890
    // Raker         Jill Watkins   978-621-2724    123-456-7890
    // 8:30-9:00     Customer       Sonia Chernova  22 Fifers Lane      Boxborough   978-621-2724   Please do my back yard
    // 9:30-12:00    Customer       Sonia Chernova  22 Fifers Lane      Boxborough   978-621-2724   Please do my back yard

    /***************************************************/
    /* THE FOLLOWING IS PLANNING FORMAT                */
    /* THIS SHOWS AM TEAMS TOGETHER                    */
    /* THIS IS DONE TO MAKE PLANNING EASY */
    /***************************************************/
    //
    // Saturday 7/4/2015 - TEAM_1 - AM
    //                                   cell          home
    // Supervisor    John White     978-621-2724    123-456-7890
    // Raker         Baker White    978-621-2724    123-456-7890
    // Raker         Jill Watkins   978-621-2724    123-456-7890
    // 8:30-9:00     Customer       Sonia Chernova  22 Fifers Lane      Boxborough   978-621-2724   Please do my back yard
    // 9:30-12:00    Customer       Sonia Chernova  22 Fifers Lane      Boxborough   978-621-2724   Please do my back yard

    // Saturday 7/4/2015 - TEAM_2 - AM
    //                                   cell          home
    // Supervisor    John White     978-621-2724    123-456-7890
    // Raker         Baker White    978-621-2724    123-456-7890
    // Raker         Jill Watkins   978-621-2724    123-456-7890
    // 8:30-9:00     Customer       Sonia Chernova  22 Fifers Lane      Boxborough   978-621-2724   Please do my back yard
    // 9:30-12:00    Customer       Sonia Chernova  22 Fifers Lane      Boxborough   978-621-2724   Please do my back yard

    echo "<br><br>";
    foreach ($days as $day) {
        foreach ($amPmList as $amOrPm) {
            echo "<br><br><h3>" . ClassDateTime::prettyDate($day) . " " . $amOrPm . "</h3><br>";
            echo "\n<table> ";
            echo "\n<tbody>";
            // common header
            echo "\n<tr><th></th><th></th><th>cell</th><th>home</th><th></th><th></th><th></th></tr>";
            foreach ($teamNumbers as $teamNumber) {
                // team-specific header...
                echo "\n<tr><th>" . ClassTeams::pretty($teamNumber) . "</th>";
                echo "<th></th><th></th><th></th><th></th><th></th><th></th></tr>";


                // SUPERVISOR
                //     echo "<br>SUPERVISORS...<br>";
                //        foreach ($supervisors as $supervisor) {} ...
                // public function isAvailable($day, $startTime);
                // public function isAssigned($day, $startTime);
                // public function isAssignedTeam($day, $startTime, $teamNumber);
                // public function assign($day, $startTime, $teamNumber);
                // public function unAssign();


                // RAKERS
                foreach (ClassDateTime::allTimesAmOrPm($amOrPm) as $startTime) {
                    foreach ($tableVolunteerRakers->getTable() as $volunteerRaker) {
                        if ($volunteerRaker->isAssignedTeam($day, $startTime, $teamNumber)) {
                            // confirm they are (still) available !
                            echo "\n<tr>";
                            if ($volunteerRaker->isAvailable($day, $startTime)) {
                                echo "<td>RAKER</td>";
                            } else {
                                echo "<td>RAKER NOT AVAILABLE</td>";
                            }
                            echo "<td>" . $volunteerRaker->modelGetField('firstname') . " " . $volunteerRaker->modelGetField('lastname') . "</td>";
                            echo "\n<td></td> <td></td> <td></td> <td></td> <td></td></tr>";
                            echo "</tr>";
                        }
                    }
                }

                // CUSTOMERS
                foreach (ClassDateTime::allTimesAmOrPm($amOrPm) as $startTime) {
                    foreach ($tableAppointments->getTable() as $appointment) {
                        if ($appointment->isAssigned($day, $startTime, $teamNumber)) {
                            // confirm the reservation still is in place !
                            if ($appointment->isAvailable($day, $startTime)) {
                                echo "<td>CUSTOMER</td>";
                            } else {
                                echo "<td>CUSTOMER NOT AVAILABLE</td>";
                            }


                            echo "<td>$appointment->modelGetField('CustName')</td></tr>";
                        }
                    }
                }
                echo "\n<tr><th>-</th><th></th><th></th><th></th><th></th><th></th><th></th></tr>";
            }
            echo "\n </tbody > ";
            echo "\n </table > ";

            //////////////////////////
            // unassigned header
            echo "\n<table> ";
            echo "\n<tbody>";

            echo "\n<tr><br><h4>To-Be-Anassigned:</h4></tr>";
            echo "\n<tr></tr>";


            // SUPERVISORS


            // RAKERS
            foreach (ClassDateTime::allTimesAmOrPm($amOrPm) as $startTime) {
                foreach ($tableVolunteerRakers->getTable() as $rowNumber => $volunteerRaker) {
                    // if need to assign
                    if ($volunteerRaker->isAvailable($day, $startTime) && !$volunteerRaker->isAssigned($day, $startTime)) {
                        echo "\n<tr>";
                        echo "<td>RAKER</td>";
                        echo "<td>" . $volunteerRaker->modelGetField('firstname') . " " . $volunteerRaker->modelGetField('lastname') . "</td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td>";
                        foreach (ClassTeams::allTeams() as $team) {
                            // assignRaker_row_date_starttime_team
                            echo "<input type=submit name=assignRaker_" . $rowNumber . "_" . $day . "_" . $startTime . "_" . $team . " value=" . $team . ">";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                }
            }

            // CUSTOMERS
            //  echo " < br>UNASSIGNED CUSTOMERS...<br > ";
            foreach (ClassDateTime::allTimesAmOrPm($amOrPm) as $startTime) {
                foreach ($tableAppointments->getTable() as $appointment) {
                    // if need to assign
                    if ($appointment->isAvailable($day, $startTime) && !$appointment->isAssigned($day, $startTime)) {
                        echo "\n<tr>";
                        echo "<td>CUSTOMER</td>";
                        echo "<td>" . $appointment->modelGetField('CustName') . "</td>";
                        echo "<td>" . $appointment->modelGetField('ApptStart') . "</td>";
                        echo "<td>" . $appointment->modelGetField('ApptEnd') . "</td>";
                        echo "<td>";
                        foreach (ClassTeams::allTeams() as $team) {
                            echo "<input type=submit name=assign_appointment_" . $appointment->modelGetIdFieldValue() . "_id value=" . $team . ">";
                        }
                        echo "</td>";
                        echo "<tr>";
                    }
                }
            }
            echo "\n </tbody > ";
            echo "\n </table > ";
        }
    }

    echo "\n</form>";
    echo "<br><br>";


    ?>

</div>
</body>
</html>
