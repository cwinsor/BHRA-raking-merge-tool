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

    <?php
    echo '<br>' . '--- PARAMETERS FROM GET ---' . '<br>';
    echo '<br>' . var_dump($_GET);
    echo '<br>';
    ?>


    <?php
    // if a file has been chosen ...
    var_dump($getFilename);
    echo "<br>";
    if ($getFilename) {
        // get rakers from .csv
        $controllerTableRakers1 = new ControllerTableRakers("rakers_roster(csv file)");
        $controllerTableRakers1->csvRead(new ControllerRowRaker(), $getFilename);
        $controllerTableRakers1->viewAsHtmlTable();

        // get rakers from database
        $controllerTableRakers2 = new ControllerTableRakers("rakers");
        $controllerTableRakers2->databaseRead(new ControllerRowRaker());
        $controllerTableRakers2->viewAsHtmlTable();

        $matchUppableClass = new MatchUppableClass();
        $matchUppableClass->setAB($controllerTableRakers1, $controllerTableRakers2);
        $matchUppableClass->performMatching();

        //    $matchUppableClass->viewAsHtmlBasicSummary();

        $matchUppableClass->viewAsHtmlInABwithDataMatch();
        $matchUppableClass->viewAsHtmlInABwithDataMismatch();
        $matchUppableClass->viewAsHtmlInAonly();
        $matchUppableClass->viewAsHtmlInBonly();
    } else {

        echo "\n<form method=get>";
        $d = dir('../upload/roster');
        // DEBUG
        // echo "Handle: " . $d->handle . "<br>";
        // echo "Path: " . $d->path . "<br>";
        while (false !== ($entry = $d->read())) {
            if ($entry != "." && $entry != "..") {
                echo "\n <br><label> <input type=radio name=filename value=\"../upload/roster/" . $entry . "\">" . $entry . "</label>";
              //                   printf("
              //  			<br><label> <input type=radio name=fileName value=\"%s\"> %s  </label> \n", $entry, $entry);
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
