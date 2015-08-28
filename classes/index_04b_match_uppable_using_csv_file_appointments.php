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

    <h3>Customer Appointments</h3>

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
    // if a file has been chosen ...
    if ($getFilename) {
        // get rakers from .csv
        $controllerTableAppointments1 = new ControllerTableAppointments($getFilename, "CSV");
        $controllerTableAppointments1->csvRead(new ControllerRowAppointment());

        // get from database
        $controllerTableAppointments2 = new ControllerTableAppointments("appointments", "DB");
        $controllerTableAppointments2->databaseRead(new ControllerRowAppointment());

        // prepare to update database based on posts
        $matchUppableClass = new MatchUppableClass();
        $matchUppableClass->setAB($controllerTableAppointments1, $controllerTableAppointments2);
        $matchUppableClass->performGetAndPostFunctions();

        // re-acquire from database (may have changed as a result of the posts)
        $controllerTableAppointments2->databaseRead(new ControllerRowAppointment());
        $matchUppableClass = new MatchUppableClass();
        $matchUppableClass->setAB($controllerTableAppointments1, $controllerTableAppointments2);
        $matchUppableClass->performMatching();

//        $matchUppableClass->viewAsHtmlBasicSummary();

        $matchUppableClass->viewAsHtmlInAonly();
        $matchUppableClass->viewAsHtmlInBonly();
        $matchUppableClass->viewAsHtmlInABwithDataMismatch();
        $matchUppableClass->viewAsHtmlInABwithDataMatch();

    } else {
        echo "\n<form method=get>";

        $d = dir('../upload/SuperSAAS');
        while (false !== ($entry = $d->read())) {
            if ($entry != "." && $entry != "..") {
                echo "\n <br><label> <input type=radio name=filename value=\"../upload/SuperSAAS/" . $entry . "\">" . $entry . "</label>";
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
