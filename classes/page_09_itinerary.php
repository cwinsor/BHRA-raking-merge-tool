<?php
include_once "aaaStandardIncludes.php";
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

    <p>This page lets you organize your raking resources (rakers and supervisors) into teams, and assign customers.</p>

    <?php


    // handle the posts
    $postAssignRaker = "";
    $postAssignAppointment = "";
    $postUnassignRaker = "";
    $postUnassignAppointment = "";
    foreach ($_POST as $postKey => $postVal) {
        list($firstTerm) = explode("_", $postKey);

        // see if there is a post assigning a raker to a team
        if (!is_null($firstTerm) && ($firstTerm == "assignRaker")) {
            $postAssignRaker = $postKey;
        }
        // see if there is a post assigning an appointment to a team
        if (!is_null($firstTerm) && ($firstTerm == "assignAppointment")) {
            $postAssignAppointment = $postKey;
        }
        // see if there is a post assigning a raker to a team
        if (!is_null($firstTerm) && ($firstTerm == "unassignRaker")) {
            $postUnassignRaker = $postKey;
        }
        // see if there is a post assigning an appointment to a team
        if (!is_null($firstTerm) && ($firstTerm == "unassignAppointment")) {
            $postUnassignAppointment = $postKey;
        }
    }

    // handle the gets
    $getShowDaysList = array();
    $getShowAmPmsList = array();
    $getShowTeamsList = array();

    foreach ($_GET as $getKey => $getVal) {

        // collect days to show
        if (($getKey == "showDays") && ($getVal != "ALL")) {
            array_push($getShowDaysList, $getVal);
        }

        // collect am/pm to show
        if (($getKey == "showAmPms") && ($getVal != "ALL")) {
            array_push($getShowAmPmsList, $getVal);
        }

        // make a list of Teams to show
        if (($getKey == "showTeams") && ($getVal != "ALL")) {
            array_push($getShowTeamsList, $getVal);
        }
    }
    // decode above
    // if nothing specific was requested then show all
    if (count($getShowDaysList) == 0) {
        $getShowDaysAll = true;
        $getShowDaysList = ClassDateTime::allDays();
    } else {
        $getShowDaysAll = false;
    }
    if (count($getShowAmPmsList) == 0) {
        $getShowAmPmsAll = true;
        $getShowAmPmsList = ClassDateTime::allAmPm();
    } else {
        $getShowAmPmsAll = false;
    }
    if (count($getShowTeamsList) == 0) {
        $getShowTeamsAll = true;
        $getShowTeamsList = ClassDateTime::allTimes();
    } else {
        $getShowTeamsAll = false;
    }


    if ($GLOBALS['debug']) {
        echo '<br>' . '--- PARAMETERS FROM POST ---' . '<br>';
        echo '<br>' . var_dump($_POST);
        echo '<br>';

        echo '<br>' . '--- PARAMETERS FROM GET ---' . '<br>';
        echo '<br>' . var_dump($_GET);
        echo '<br>';


        echo "<br>";
        var_dump($getShowDaysAll);
        echo "<br>";
        var_dump($getShowAmPmsAll);
        echo "<br>";
        var_dump($getShowTeamsAll);
        echo "<br>";
        var_dump($getShowDaysList);
        echo "<br> ";
        var_dump($getShowAmPmsList);
        echo "<br> ";
        var_dump($getShowTeamsList);


    }

    ?>

    <?php


    // get volunteer rakers from database
    $tableVolunteerRakers = new ControllerTable("volunteerspot_rakers", "VOLUNTEER RAKERS", new ControllerRowVolunteerSpotRaker());
    $tableVolunteerRakers->databaseRead();
    // handle posts
    if ($postAssignRaker) {
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
    if ($postUnassignRaker) {
        list($junk, $theRowNumber) = explode("_", $postUnassignRaker);
        $row = $tableVolunteerRakers->modelGetRow($theRowNumber);
        // remove row from database
        $tableVolunteerRakers->databaseDeleteItem($row);
        // update the local row copy with new assignment
        $row->unassign();
        // write updated row to database
        $tableVolunteerRakers->databaseAddItem($row);
    }
    // re-read
    $tableVolunteerRakers->databaseRead();
    if ($GLOBALS['debug']) {
        $tableVolunteerRakers->viewAsHtmlTable();
    }

    // get customer appointments from database
    $tableAppointments = new ControllerTable("appointments", "APPOINTMENTS", new ControllerRowAppointment());
    $tableAppointments->databaseRead();
    // handle posts
    if ($postAssignAppointment) {
        // assignAppointment_row_date_starttime_team
        list($junk, $theRowNumber, $theDate, $theStartTime, $theTeamNumber) = explode("_", $postAssignAppointment);
        $row = $tableAppointments->modelGetRow($theRowNumber);
        // remove row from database
        $tableAppointments->databaseDeleteItem($row);
        // update the local row copy with new assignment
        $row->assign($theDate, $theStartTime, $theTeamNumber);
        // write updated row to database
        $tableAppointments->databaseAddItem($row);
    }
    if ($postUnassignAppointment) {
        list($junk, $theRowNumber) = explode("_", $postUnassignAppointment);
        $row = $tableAppointments->modelGetRow($theRowNumber);
        // remove row from database
        $tableAppointments->databaseDeleteItem($row);
        // update the local row copy with new assignment
        $row->unassign();
        // write updated row to database
        $tableAppointments->databaseAddItem($row);
    }
    // re-read
    $tableAppointments->databaseRead();
    if ($GLOBALS['debug']) {
        $tableAppointments->viewAsHtmlTable();
    }

    // create a small menu at the top so user can choose what to view
    // day, am/pm, team
    echo "\n<form method=get>";
    echo "\nVIEW:";

    echo "\n<br><select name=showDays>";
    echo "\n<option value=ALL " . ($getShowDaysAll ? " selected" : "") . ">all days</option>";
    foreach (ClassDateTime::allDays() as $day) {
        echo "\n<option value=" . $day .
            ((($getShowDaysAll === false) && (array_search($day, $getShowDaysList)) !== false) ? " selected" : "") .
            ">" . ClassDateTime::prettyDate($day) . "</option>";
        //      echo "\n<option value=" . $day .
        //          (true ? " selected" : "") .
        //          ">" . ClassDateTime::prettyDate($day) . "</option>";

    }
    echo "\n</select>";

    echo "\n<br><select name=showAmPms>";
    echo "\n<option value=ALL " . ($getShowAmPmsAll ? " selected" : "") . ">all am/pm</option>";
    foreach (ClassDateTime::allAmPm() as $amPm) {
        echo "\n<option value=" . $amPm .
            ((($getShowAmPmsAll===false) && (array_search($amPm, $getShowAmPmsList)) !== false) ? " selected" : "") .
            ">" . $amPm . "</option>";
    }
    echo "\n</select>";


    echo "\n<br><select name=showTeam>";
    echo "\n<option value=ALL " . ($getShowTeamsAll ? " selected" : "") . ">all teams</option>";
    foreach (ClassTeams::allTeams() as $team) {
        echo "\n<option value=" . $team .
            ((($getShowTeamsAll===false) && (array_search($team, $getShowTeamsList)) !== false) ? " selected" : "") .
            ">" . ClassTeams::pretty($team) . "</option>";
    }
    echo "\n</select>";


    echo "\n<br> <input type=submit name=submit value=submit>";
    echo "\n</form > ";


    // the order for final printout is  day / teamNumber / amPm
    // the order for task assignment is day / amPm / teamNumber


    ///////////////////////////////////////////
    // generate html
    echo "<form method = post > ";

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

    echo "<br ><br > ";
    foreach ($getShowDaysList as $day) {
        foreach ($getShowAmPmsList as $amOrPm) {


            // used to make table sort-able
            echo '<script src=" ../content_mappable / sorttable . js"></script>';
            echo '<style> table {
              table-layout: fixed;
             border-collapse: collapse;
               width: 100%;
              border: 1px solid black;
              font-size: 0.9em;
              word-wrap: break-word;
            }
            td {
                border: 1px solid black;
            }
            th {
                border: 1px solid black;
            }
            </style>';

            echo '<br>';
            echo '<table class=sortable>';

            echo " <caption><h3 > " . ClassDateTime::prettyDate($day) . " " . $amOrPm . " </h3 ></caption > ";
            echo "\n <tbody>";
            // common header
            echo "\n <tr><th ></th ><th ></th ><th > cell</th ><th > home</th ><th ></th ><th ></th ><th ></th ></tr > ";
            foreach ($getShowTeamsList as $teamNumber) {
                // team-specific header...
                echo "\n <tr><th > " . ClassTeams::pretty($teamNumber) . "</th > ";
                echo "<th ></th ><th ></th ><th ></th ><th ></th ><th ></th ><th ></th ></tr > ";


                // SUPERVISOR
                //     echo "<br > SUPERVISORS...<br > ";
                //        foreach ($supervisors as $supervisor) {} ...
                // public function isAvailable($day, $startTime);
                // public function isAssigned($day, $startTime);
                // public function isAssignedTeam($day, $startTime, $teamNumber);
                // public function assign($day, $startTime, $teamNumber);
                // public function unAssign();


                // RAKERS
                foreach (ClassDateTime::allTimesAmOrPm($amOrPm) as $startTime) {
                    foreach ($tableVolunteerRakers->getTable() as $rowNumber => $volunteerRaker) {
                        if ($volunteerRaker->isAssignedTeam($day, $startTime, $teamNumber)) {
                            // confirm they are (still) available !
                            echo "\n <tr>";
                            if ($volunteerRaker->isAvailable($day, $startTime)) {
                                echo " <td>RAKER </td > ";
                            } else {
                                echo "<td > RAKER NOT AVAILABLE </td > ";
                            }
                            echo "<td > " . $volunteerRaker->modelGetField('firstname') . " " . $volunteerRaker->modelGetField('lastname') . " </td > ";
                            echo "\n <td></td > <td ></td > <td ></td > <td ></td > ";

                            echo "<td ><input type = submit name = unassignRaker_" . $rowNumber . " value = unassign ></td > ";
                            echo "</tr > ";
                        }
                    }
                }

                // CUSTOMERS
                foreach (ClassDateTime::allTimesAmOrPm($amOrPm) as $startTime) {
                    foreach ($tableAppointments->getTable() as $rowNumber => $appointment) {
                        if ($appointment->isAssignedTeam($day, $startTime, $teamNumber)) {
                            // confirm the reservation still is in place !
                            if ($appointment->isAvailable($day, $startTime)) {
                                echo "<td > CUSTOMER</td > ";
                            } else {
                                echo "<td > CUSTOMER NOT AVAILABLE </td > ";
                            }
                            echo "<td > " . $appointment->modelGetField('CustName') . " " . " </td > ";
                            echo "<td > " . $appointment->modelGetField('ApptStart') . " to " . $appointment->modelGetField('ApptEnd') . " </td > ";
                            echo "\n <td></td > <td ></td > <td ></td > ";
                            echo "<td ><input type = submit name = unassignAppointment_" . $rowNumber . " value = unassign ></td > ";
                            echo "</tr > ";
                        }
                    }
                }
                echo "\n <tr><th > -</th ><th ></th ><th ></th ><th ></th ><th ></th ><th ></th ><th ></th ></tr > ";
            }
            echo "\n </tbody > ";
            echo "\n </table > ";

            //////////////////////////
            // unassigned header
            echo "\n <table> ";
            echo " <caption><h3>To-Be-Assigned</h3 ></caption > ";
            echo "\n <tbody>";
            echo "\n <tr></tr > ";


            // SUPERVISORS


            // RAKERS
            foreach (ClassDateTime::allTimesAmOrPm($amOrPm) as $startTime) {
                foreach ($tableVolunteerRakers->getTable() as $rowNumber => $volunteerRaker) {
                    // if need to assign
                    if ($volunteerRaker->isAvailable($day, $startTime) && !$volunteerRaker->isAssigned($day, $startTime)) {
                        echo "\n <tr>";
                        echo " <td>RAKER </td > ";
                        echo "<td > " . $volunteerRaker->modelGetField('firstname') . " " . $volunteerRaker->modelGetField('lastname') . " </td > ";
                        echo "<td ></td > ";
                        echo "<td ></td > ";
                        echo "<td > ";
                        foreach (ClassTeams::allTeams() as $team) {
                            // assignRaker_row_date_starttime_team
                            echo "<input type = submit name = assignRaker_" . $rowNumber . "_" . $day . "_" . $startTime . "_" . $team . " value = " . $team . " > ";
                        }
                        echo "</td > ";
                        echo "</tr > ";
                    }
                }
            }

            // CUSTOMERS
            //  echo " <br > UNASSIGNED CUSTOMERS...<br > ";
            foreach (ClassDateTime::allTimesAmOrPm($amOrPm) as $startTime) {
                foreach ($tableAppointments->getTable() as $rowNumber => $appointment) {
                    // if need to assign
                    if ($appointment->isAvailable($day, $startTime) && !$appointment->isAssigned($day, $startTime)) {
                        echo "\n <tr>";
                        echo " <td>CUSTOMER </td > ";
                        echo "<td > " . $appointment->modelGetField('CustName') . "</td > ";
                        echo "<td > " . $appointment->modelGetField('ApptStart') . " to " . $appointment->modelGetField('ApptEnd') . " </td > ";
                        echo "<td ></td > ";
                        echo "<td > ";
                        foreach (ClassTeams::allTeams() as $team) {
                            // assignAppointment_row_date_starttime_team
                            echo "<input type = submit name = assignAppointment_" . $rowNumber . "_" . $day . "_" . $startTime . "_" . $team . " value = " . $team . " > ";
                        }
                        echo "</td > ";
                        echo "<tr > ";
                    }
                }
            }
            echo "\n </tbody > ";
            echo "\n </table > ";
        }
    }

    echo "\n </form > ";
    echo "<br ><br > ";


    ?>

</div>
</body>
</html>
