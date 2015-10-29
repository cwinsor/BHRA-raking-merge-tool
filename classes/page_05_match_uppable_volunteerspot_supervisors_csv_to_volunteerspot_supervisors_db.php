<?php
include_once "aaaStandardIncludes.php";
?>

<?php
pickupGetIfSet("filename", $getFilename);

//////////////
// common code...
// GET parameters for verbose, skip line of input, etc
include_once "page_00_match_uppable_common_buttons_1.php";

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

    <h3>Supervisor Availability</h3>

    <p>This page lets you get the latest supervisor availability from a VolunteerSpot file.</p>

    <?php

    echo "\n<form method=get>";

    /////////////////////////
    // user to choose a file
    echo "Choose file:";
    $dirName = '../upload/VolunteerSpot/supervisors/';
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

    //////////////
    // common code...
    // buttons on page for verbose, skip line of input, etc
    include_once "page_00_match_uppable_common_buttons_2.php";

    // submit button for GET form
    echo "<br><input type=submit value=Submit>";
    echo "\n</form >";

    echo "\n<form method=post>";

    echo "<br><input type=checkbox name=del_all_from_db>";
    echo "Delete everything in database (NOTE - will result in loss of itinerary and team assignments)";
    echo "<input type=checkbox name=del_all_im_sure>";
    echo "I'm sure";

    echo "<br><input type=checkbox name=add_all_from_csv>";
    echo "Add everything from .csv file";
    echo "<br><input type=submit value=Submit>";
    echo "\n</form >";


    if ($getFilename) {

        // get rakers from .csv
        $controllerTableSupervisors1 = new ControllerTable($getFilename, "CSV", new ControllerRowVolunteerspotRaker());
        $controllerTableSupervisors1->csvRead($skipFirstLine);
        //  $controllerTableRakers1->viewAsHtmlTable();

        // get rakers from database
        $controllerTableSupervisors2 = new ControllerTable("volunteerspot_supervisors", "DB", new ControllerRowVolunteerspotRaker());
        $controllerTableSupervisors2->databaseRead();
        //     $controllerTableRakers2->viewAsHtmlTable();

        // prepare to update database based on posts
        $matchUppableClass = new MatchUppableClassVolunteerspotRakersCsvToVolunteerspotRakersDb();
        $matchUppableClass->setAB($controllerTableSupervisors1, $controllerTableSupervisors2);
        $matchUppableClass->performMatching();
        $matchUppableClass->performGetAndPostFunctions();

        // re-acquire from database (may have changed as a result of the posts)
        $controllerTableSupervisors2->databaseRead();
        $matchUppableClass = new MatchUppableClassVolunteerspotRakersCsvToVolunteerspotRakersDb();
        $matchUppableClass->setAB($controllerTableSupervisors1, $controllerTableSupervisors2);
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
