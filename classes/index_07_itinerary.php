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
    // DEBUG ...
    //    echo '<br>' . '--- PARAMETERS FROM POST ---' . '<br>';
    //    echo '<br>' . var_dump($_POST);
    //    echo '<br>';
    //    ?>
    <?php
    //    echo '<br>' . '--- PARAMETERS FROM GET ---' . '<br>';
    //    echo '<br>' . var_dump($_GET);
    //    echo '<br>';
    //    ?>


    <?php

        // get data from database...
        //  roster raker
        //  roster supervisor
        //  volunteer raker
        //  volunteer supervisor

        $controllerTableRosterRaker = new ControllerTableAppointments("roster_rakers", "Roster Rakers");
        $controllerTableAppointments2->databaseRead(new ControllerRakerRoster());

        $controllerTableRosterRaker = new ControllerTableAppointments("volunteerspot_rakers", "Roster Rakers");
        $controllerTableAppointments2->databaseRead(new ControllerrakerVolunteerSpot());

exit ("not implemented.. in progress 0896");

    ?>

</div>
</body>
</html>
