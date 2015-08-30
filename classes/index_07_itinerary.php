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


    // get customer appointments from database
    $tableAppointments = new ControllerTable("appointments", "APPOINTMENTS");
    $tableAppointments->databaseRead(new ControllerRowAppointment());
    $tableAppointments->viewAsHtmlTable();

    // get assignments from database
    $tableAssignments = new ControllerTable("assignments", "ASSIGNMENTS");
    $tableAssignments->databaseRead(new ControllerRowAssignment());
    $tableAssignments->viewAsHtmlTable();

    // prepare to update database based on posts
    $matchUppableClass = new MatchUppableClassToAssignmentsDbFromAppointmentsDb();
    $matchUppableClass->setAB($tableAppointments, $tableAssignments);
    $matchUppableClass->performGetAndPostFunctions();

    // re-acquire from database (may have changed as a result of the posts)
    $tableAssignments->databaseRead(new ControllerRowAssignment());
    $matchUppableClass = new MatchUppableClassToAssignmentsDbFromAppointmentsDb();
    $matchUppableClass->setAB($tableAppointments, $tableAssignments);
    $matchUppableClass->performMatching();

    $matchUppableClass->viewAsHtmlInAonly();
    $matchUppableClass->viewAsHtmlInBonly();
    $matchUppableClass->viewAsHtmlInABwithDataMismatch();
    $matchUppableClass->viewAsHtmlInABwithDataMatch();


    ?>

</div>
</body>
</html>
