<?php
include_once "aaaStandardIncludes.php";
?>

<?php
pickupGetIfSet("filename", $getFilename);
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

    <h3>Raker Data From Roster</h3>

    <p>This page lets you pull in raker data from the team roster.</p>

    <p>The roster is used for information like age, gender, phone, etc.</p>

    <?php

    echo "\n<form method=get>";

    /////////////////////////
    // user to choose a file
    echo "Choose file:";
    $dirName = '../upload/roster/';
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
    // user option to set verbose (see all data fields)
    echo "<br><br>Verbose?";
    if ($getDisplayVerbose == "checked") {
        echo "\n<br><input type=checkbox name=verbose value=checked checked>";
    } else {
        echo "\n<br><input type=checkbox name=verbose value=checked>";
    }
    echo "\n<br><input type=submit value=Submit>";
    echo "\n</form >";

    if ($getFilename) {
        // get rakers from .csv
        $controllerTableRakers1 = new ControllerTable($getFilename, "CSV", new ControllerRowRosterRaker());
        $controllerTableRakers1->csvRead();
        // DEBUG       $controllerTableRakers1->viewAsHtmlTable();

        // get rakers from database
        $controllerTableRakers2 = new ControllerTable("roster_rakers", "DB", new ControllerRowRosterRaker());
        $controllerTableRakers2->databaseRead();
        // DEBUG        $controllerTableRakers2->viewAsHtmlTable();

        // prepare to update database based on posts
        $matchUppableClass = new MatchUppableClassRosterCsvToRakersDb();
        $matchUppableClass->setAB($controllerTableRakers1, $controllerTableRakers2);
        $matchUppableClass->performGetAndPostFunctions();

        // re-acquire from database (may have changed as a result of the posts)
        $controllerTableRakers2->databaseRead();
        $matchUppableClass = new MatchUppableClassRosterCsvToRakersDb();
        $matchUppableClass->setAB($controllerTableRakers1, $controllerTableRakers2);
        $matchUppableClass->performMatching();

        // DEBUG
//        echo "<br> here 3322165 <br";
//       $matchUppableClass->viewAsHtmlBasicSummary();
//        echo "<br> here 3322165 <br";

        $matchUppableClass->viewAsHtmlInAonly($getDisplayVerbose);
        $matchUppableClass->viewAsHtmlInBonly($getDisplayVerbose);
        $matchUppableClass->viewAsHtmlInABwithDataMismatch($getDisplayVerbose);
        $matchUppableClass->viewAsHtmlInABwithDataMatch($getDisplayVerbose);

    }
    ?>

</div>
</body>
</html>
