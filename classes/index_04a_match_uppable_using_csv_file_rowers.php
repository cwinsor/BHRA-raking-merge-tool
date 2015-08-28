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


    <h3>Volunteer Rakers</h3>

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
        $controllerTableRakers1 = new ControllerTableRakers($getFilename, "CSV");
        $controllerTableRakers1->csvRead(new ControllerRowRaker());
        // DEBUG       $controllerTableRakers1->viewAsHtmlTable();

        // get rakers from database
        $controllerTableRakers2 = new ControllerTableRakers("rakers", "DB");
        $controllerTableRakers2->databaseRead(new ControllerRowRaker());
        // DEBUG        $controllerTableRakers2->viewAsHtmlTable();

        // prepare to update database based on posts
        $matchUppableClass = new MatchUppableClass();
        $matchUppableClass->setAB($controllerTableRakers1, $controllerTableRakers2);
        $matchUppableClass->performGetAndPostFunctions();

        // re-acquire from database (may have changed as a result of the posts)
        $controllerTableRakers2->databaseRead(new ControllerRowRaker());
        $matchUppableClass = new MatchUppableClass();
        $matchUppableClass->setAB($controllerTableRakers1, $controllerTableRakers2);
        $matchUppableClass->performMatching();

//        $matchUppableClass->viewAsHtmlBasicSummary();

        $matchUppableClass->viewAsHtmlInAonly();
        $matchUppableClass->viewAsHtmlInBonly();
        $matchUppableClass->viewAsHtmlInABwithDataMismatch();
        $matchUppableClass->viewAsHtmlInABwithDataMatch();

    } else {
        echo "\n<form method=get>";

        $d = dir('../upload/roster');
        while (false !== ($entry = $d->read())) {
            if ($entry != "." && $entry != "..") {
                echo "\n <br><label> <input type=radio name=filename value=\"../upload/roster/" . $entry . "\">" . $entry . "</label>";
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
