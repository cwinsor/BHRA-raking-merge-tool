<!-- used to make table sort-able -->
<script src="sorttable.js"></script>


<?php
include_once "aaaStandardIncludes.php";
?>

<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php

// //////////////////////
// recover previous session or start a new session
session_start();

// if there is a request to kill the sesson
// or the session started above is not proper
// then kill and restart
// a session has an ID and a database table
if ((isset($_POST["restartSession"])) || (!isset($_SESSION['id']))) {
$sessionRestarted = 1;
    // kill the sesson
    session_unset();
    session_destroy();

    // start a proper session
    session_start();
    $date = new DateTime();
    // $_SESSION['id'] = $date->getTimestamp();
    // setlocale(LC_TIME, "de_DE"); // only necessary if the locale isn't already set
    // $formatted_time = strftime("%a %e.%l.%Y", $mytime->getTimestamp());
    // $formatted_time = strftime("%a %e.%l.%Y", $date->getTimestamp());
    $_SESSION['id'] = $date->format('Y-m-d H:i:s');
} else {
    $sessionRestarted = 0;
}

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
        />

</head>
<body>

<div id="navigation">
    <?php
    include '../navigation/functions.php';
    Navigation();
    ?>
</div>


<!-- <div id="content" display:table;"> -->
<div id="content">

    <?php
    // function to evaluate POST attribute, return it's value if set, otherwise return ""
    function pickupPostIfSet($attribute, &$rtn)
    {
        $rtn = isset($_POST[$attribute]) ? $_POST[$attribute] : "";
    }

    // function to evaluate POST attribute, return specified value if set, otherwise return ""
    function pickupPostIfSetWithVal($attribute, $valueIfSet, &$rtn)
    {
        $rtn = isset($_POST[$attribute]) ? $valueIfSet : "";
    }

    // function to evaluate GET attribute, return it's value if set, otherwise return ""
    function pickupGetIfSet($attribute, &$rtn)
    {
        $rtn = isset($_GET[$attribute]) ? $_GET[$attribute] : "";
    }

    // function to evaluate GET switch, return "selected" set, otherwise return ""
    function pickupGetSwitch($attribute, $switchValue, &$rtn)
    {
        $rtn = (isset($_GET[$attribute]) && ($_GET[$attribute] == $switchValue)) ? "selected" : "";
    }

    // function to evaluate GET attribute, return specified value if set, otherwise return ""
    function pickupGetIfSetWithVal($attribute, $valueIfSet, &$rtn)
    {
        $rtn = isset($_GET[$attribute]) ? $valueIfSet : "";
    }

    ?>


    <?php
    $getContextRakers = "blah";

    // /////////////////
    // print POST and GET parameters

    echo '<br>' . '--- PARAMETERS FROM POST ---' . '<br>';
    var_dump($_POST);
    echo '<br>';

    echo '<br>' . '--- PARAMETERS FROM GET ---' . '<br>';
    var_dump($_GET);
    echo '<br>';

    echo '<br>' . '--- SESSION ---' . '<br>';
    var_dump($_SESSION['id']);

    // /////////////////////////
    // pick up POSTs and GETs
    pickupPostIfSet("readDatabase", $postReadDatabase);
    pickupPostIfSet("modifyEntry", $postModifyEntry);
    pickupPostIfSet("restartSession", $postRestartSession);

    pickupGetSwitch("context", "contextNone", $getContextNone);
    pickupGetSwitch("context", "contextRakers", $getContextRakers);
    pickupGetSwitch("context", "contextSupervisors", $getContextSupervisors);
    pickupGetSwitch("context", "contextAppointments", $getContextAppointments);
    pickupGetSwitch("context", "contextTeams", $getContextTeams);

    echo '<br> getContextRakers=' . $getContextRakers . "<br>";

    pickupGetIfSet("optionalShowSessionId", $getOptionalShowSessionId);
    pickupGetIfSet("optionalShowSessionData", $getOptionalShowSessionData);

    echo "<br> getContextRakers = " . $getContextRakers . "<br>";

    // /////////////////
    // rakers
    if ($getContextRakers) {
        // get rakers from database
        $controllerTableRakers = new ControllerTableRakers("rakers");
        $controllerTableRakers->databaseRead(new ControllerRowRaker()); // give example to clone

        // modify an entry and post to database
        if ($postModifyEntry) {
            $id = 1;
            $myRaker = $controllerTableRakers->modelGetById($id);
            echo "<br> before... <br>";
            echo $myRaker->modelGetField('cellphone');
            $myRaker->modelSetField('cellphone', "Barr");
            echo "<br> after... <br>";
            echo $myRaker->modelGetField('cellphone');
            echo "<br>";
            $myRaker->databaseUpdateRowAllFields("rakers");
        }

        // get resulting data from database for display
        $controllerTableRakers = new ControllerTableRakers("rakers");
        $controllerTableRakers->databaseRead(new ControllerRowRaker());
        echo '<br>' . '--- RAKERS ---' . '<br>';
        $controllerTableRakers->viewAsHtmlTable();

        // var_dump($controllerTableRakers);
    } elseif ($getContextNone) {
        echo '<br> Please choose a context(1)';
    } else {
        echo '<br> Please choose a context(2)';
    }

    ?>

    <?php
    echo '<br>' . '--- TEST ---' . '<br>';
    echo "<br> getContextRakers = " . $getContextRakers . "<br>";
    ?>


    <br>
    <br>
    // GET FORM
    <form
        method="get"
        action=""
        ><br> Context: <select name=context>
            <option
                value=contextNone
                <?php if ($getContextNone) echo(" selected=selected"); ?>
                >select...
            </option>
            <option
                value=contextRakers
                <?php if ($getContextRakers) echo(" selected=selected"); ?>
                >Rakers
            </option>
            <option
                value=contextSupervisors
                <?php if ($getContextSupervisors) echo(" selected=selected"); ?>
                >Supervisors
            </option>
            <option
                value=contextAppointments
                <?php if ($getContextAppointments) echo(" selected=selected"); ?>
                >Appointments
            </option>
            <option
                value=contextTeams
                <?php if ($getContextTeams) echo(" selected=selected"); ?>
                >Teams
            </option>
        </select> <br> <input
            type="checkbox"
            name="optionalShowSessionId"
            > Show session ID <br> <input
            type="checkbox"
            name="optionalShowSessionData"
            > Show session data <br> <input
            type="submit"
            name="submit"
            value="submit"
            ></form>


    <br>
    // POST FORM
    <form
        method="post"
        action=""
        ><br> <input
            type="submit"
            name="readDatabase"
            value="readDatabase"
            > <br> <input
            type="submit"
            name="modifyEntry"
            value="modifyEntry"
            > <br> <input
            type="submit"
            name="restartSession"
            value="restartSession"
            ></form>


</div>
</body>
</html>
