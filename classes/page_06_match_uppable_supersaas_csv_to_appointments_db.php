<?php
include_once "aaaStandardIncludes.php";
?>

<?php
pickupGetIfSet("filename", $getFilename);
pickupGetIfSet("skipFirstLine", $skipFirstLine);
pickupGetIfSet("verbose", $getDisplayVerbose);
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

    <h3>Customer Appointments</h3>

    <p>This page lets you get the latest customer appointments from a SuperSAAS file.</p>

    <?php

    echo "\n<form method=get>";

    /////////////////////////
    // user to choose a file
    echo "Choose file:";
    $dirName = '../upload/SuperSAAS/';
    $d = dir($dirName);
    while (false !== ($entry = $d->read())) {
        if ($entry != "." && $entry != "..") {
            if ($getFilename == ($dirName . $entry)) {
                echo "\n <br><label> <input type=radio name=filename value=\"" . $dirName . $entry . "\" checked>" . $entry . "</label>";
            } else {
                echo "\n <br><label> <input type=radio name=filename value=\"" . $dirName . $entry . "\">" . $entry . "</label>";
            }
        }
    }
    $d->close();
    echo "\n<br><input type=submit value=Submit>";

    ///////////////////////////////////////////
    // user option to skip first line of .csv file (frequently a header line)
    echo "<br>";
    if ($skipFirstLine == "checked") {
        echo "<br><input type=checkbox name=skipFirstLine value=checked checked>";
    } else {
        echo "<br><input type=checkbox name=skipFirstLine value=checked>";
    }
    echo "Skip first line (header)";

    ///////////////////////////////////////////
    // user option to set verbose (see all data fields)
    echo "<br>";
    if ($getDisplayVerbose == "checked") {
        echo "<br><input type=checkbox name=verbose value=checked checked>";
    } else {
        echo "<br><input type=checkbox name=verbose value=checked>";
    }
    echo "Verbose";
    echo "<br><input type=submit value=Submit>";
    echo "\n</form >";

    echo "\n<form method=post>";
    echo "<br><input type=checkbox name=del_all_from_db>";
    echo "Delete everything in database (NOTE - will result in loss of itinerary and team assignments)";
    echo "<br><input type=checkbox name=add_all_from_csv>";
    echo "Add everything from .csv file";
    echo "<br><input type=submit value=Submit>";
    echo "\n</form >";


    if ($getFilename) {
        // get rakers from .csv
        $controllerTableAppointments1 = new ControllerTable($getFilename, "CSV", new ControllerRowAppointment());
        $controllerTableAppointments1->csvRead($skipFirstLine);

        // get from database
        $controllerTableAppointments2 = new ControllerTable("appointments", "DB", new ControllerRowAppointment());
        $controllerTableAppointments2->databaseRead();

        // prepare to update database based on posts
        $matchUppableClass = new MatchUppableClassSupersaasCsvToAppointmentsDb();
        $matchUppableClass->setAB($controllerTableAppointments1, $controllerTableAppointments2);
        $matchUppableClass->performMatching();
        $matchUppableClass->performGetAndPostFunctions();

        // re-acquire from database (may have changed as a result of the posts)
        $controllerTableAppointments2->databaseRead();
        $matchUppableClass = new MatchUppableClassSupersaasCsvToAppointmentsDb();
        $matchUppableClass->setAB($controllerTableAppointments1, $controllerTableAppointments2);
        $matchUppableClass->performMatching();

//        $matchUppableClass->viewAsHtmlBasicSummary();

        $matchUppableClass->viewAsHtmlInAonly($getDisplayVerbose);
        $matchUppableClass->viewAsHtmlInBonly($getDisplayVerbose);
        $matchUppableClass->viewAsHtmlInABwithDataMismatch($getDisplayVerbose);
        $matchUppableClass->viewAsHtmlInABwithDataMatch($getDisplayVerbose);

    }

    ?>

</div>
</body>
</html>
