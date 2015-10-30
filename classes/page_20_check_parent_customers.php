<?php
include_once "aaaStandardIncludes.php";
?>

<?php

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

    <h3>Check for Parent=Customer</h3>

    <p>This page checks for Parents that have signed up to be Customers</p>

    <?php

    //////////////////
    // get customer emails from appointments database
    $databaseTableOrFileName = "appointments";
    $itemToClone = new ControllerRowAppointment();

    include "../.env_database_password";
    $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
    $sql = "SELECT * FROM $databaseTableOrFileName";
    $result = mysqli_query($db, $sql);
    mysqli_close($db);
    if (!$result) {
        trigger_error("database query failed (appts): ", E_USER_ERROR);
    }

    $custEmail = array();
    while ($rowAssociativeArray = $result->fetch_assoc()) {
        $rowEntity = clone $itemToClone;
        $rowEntity->populateFromDatabaseTableAssociativeArray($rowAssociativeArray);
        // echo "<br>zona " . $rowEntity->modelGetField("CustEmail");
        array_push($custEmail, $rowEntity->modelGetField("CustEmail"));
    }
    echo "<br>there are " . count($custEmail) . " customer emails";
    //foreach ($custEmail as $email) {
    //    echo "<br>" . $email . "<br>";
    //}


    //////////////////
    // get parent and kid emails from roster database
    $parentsAndKidsEmail = array();

    /////////////////////
    // first the kids
    $databaseTableOrFileName = "roster_kids";
    $itemToClone = new ControllerRowRosterRaker();

    include "../.env_database_password";
    $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
    $sql = "SELECT * FROM $databaseTableOrFileName";
    $result = mysqli_query($db, $sql);
    mysqli_close($db);
    if (!$result) {
        trigger_error("database query failed (roster): ", E_USER_ERROR);
    }

    while ($rowAssociativeArray = $result->fetch_assoc()) {
        $rowEntity = clone $itemToClone;
        $rowEntity->populateFromDatabaseTableAssociativeArray($rowAssociativeArray);
        array_push($parentsAndKidsEmail, $rowEntity->modelGetField("email"));
    }


    /////////////////////
    // then the parents
    $databaseTableOrFileName = "roster_parents";
    $itemToClone = new ControllerRowRosterParent();

    include "../.env_database_password";
    $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
    $sql = "SELECT * FROM $databaseTableOrFileName";
    $result = mysqli_query($db, $sql);
    mysqli_close($db);
    if (!$result) {
        trigger_error("database query failed (roster): ", E_USER_ERROR);
    }

    while ($rowAssociativeArray = $result->fetch_assoc()) {
        $rowEntity = clone $itemToClone;
        $rowEntity->populateFromDatabaseTableAssociativeArray($rowAssociativeArray);
        array_push($parentsAndKidsEmail, $rowEntity->modelGetField("p1_email"));
        array_push($parentsAndKidsEmail, $rowEntity->modelGetField("p2_email"));
    }

    echo "<br>there are " . count($parentsAndKidsEmail) . " parent/rower emails";
    //foreach ($parentsAndKidsEmail as $email) {
    //    echo "<br>" . $email . "<br>";
    //}


    ////////////////////////
    // OK - now see if any of them match
    foreach ($parentsAndKidsEmail as $pkEmail) {
        if (in_array($pkEmail, $custEmail)) {
            echo "<br>found match -> " . $pkEmail . "<br>";
        }
    }


    ?>

</div>
</body>
</html>



