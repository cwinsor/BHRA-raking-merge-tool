<?php
include_once "aaaStandardIncludes.php";
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

    <h3>Customer Appointments</h3>
    <p>This page lets you get the latest customer appointments from a SuperSAAS file.</p>


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
    // if a file has been chosen ...
    if ($getFilename) {
        // get rakers from .csv
        $controllerTableAppointments1 = new ControllerTable($getFilename, "CSV", new ControllerRowAppointment());
        $controllerTableAppointments1->csvRead();

        // get from database
        $controllerTableAppointments2 = new ControllerTable("appointments", "DB", new ControllerRowAppointment());
        $controllerTableAppointments2->databaseRead();

        // prepare to update database based on posts
        $matchUppableClass = new MatchUppableClassSupersaasCsvToAppointmentsDb();
        $matchUppableClass->setAB($controllerTableAppointments1, $controllerTableAppointments2);
        $matchUppableClass->performGetAndPostFunctions();

        // re-acquire from database (may have changed as a result of the posts)
        $controllerTableAppointments2->databaseRead();
        $matchUppableClass = new MatchUppableClassSupersaasCsvToAppointmentsDb();
        $matchUppableClass->setAB($controllerTableAppointments1, $controllerTableAppointments2);
        $matchUppableClass->performMatching();

//        $matchUppableClass->viewAsHtmlBasicSummary();

        $matchUppableClass->viewAsHtmlInAonly();
        $matchUppableClass->viewAsHtmlInBonly();
        $matchUppableClass->viewAsHtmlInABwithDataMismatch();
        $matchUppableClass->viewAsHtmlInABwithDataMatch();

    } else {
        echo "\n<form method=get>";

        $dirName = '../upload/SuperSAAS/';
        $d = dir($dirName);
        while (false !== ($entry = $d->read())) {
            if ($entry != "." && $entry != "..") {
                echo "\n <br><label> <input type=radio name=filename value=\"" . $dirName . $entry . "\">" . $entry . "</label>";
            }
        }
        $d->close();
        echo "\n<br><input type=submit name=submit value=Submit>";
        echo "\n</form>";
    }
    ?>

</div>
</body>
</html>
