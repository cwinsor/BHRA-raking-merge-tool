<?php
include_once "aaaStandardIncludes.php";
?>

<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
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
    // get rakers from database
    $controllerTableRakers1 = new ControllerTableRakers("rakers_test_1");
    $controllerTableRakers1->databaseRead(new ControllerRowRaker());
    $controllerTableRakers1->viewAsHtmlTable();

    // get rakers from database
    $controllerTableRakers2 = new ControllerTableRakers("rakers_test_2");
    $controllerTableRakers2->databaseRead(new ControllerRowRaker());
    $controllerTableRakers2->viewAsHtmlTable();

    $matchUppableClass = new MatchUppableClass();
    $matchUppableClass->setAB($controllerTableRakers1, $controllerTableRakers2);
    $matchUppableClass->performMatching();

    $matchUppableClass->viewAsHtmlBasicSummary();

    $matchUppableClass->viewAsHtmlInABwithDataMatch();
    $matchUppableClass->viewAsHtmlInABwithDataMismatch();
    $matchUppableClass-> viewAsHtmlInAonly();
     $matchUppableClass->viewAsHtmlInBonly();





    ?>

</div>
</body>
</html>
