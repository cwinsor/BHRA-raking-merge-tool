<?php
include_once "aaaStandardIncludes.php";
?>

<?php

/**
 * the following function is used to make customer address easier to match
 * it is used when trying to match up customer address with parent address
 * when searching for parents-as-customers
 */
function refine($in)
{
    $work = strtolower($in);
    $work = str_replace(" street", "", $work);
    $work = str_replace(" road", "", $work);
    $work = str_replace(" rd", "", $work);
    $work = str_replace(" lane", "", $work);
    $work = str_replace(" circle", "", $work);
    $work = str_replace(" ", "", $work);
    $work = str_replace(" ", "", $work);
    $work = str_replace(" ", "", $work);
    $work = str_replace(",", "", $work);
    $work = str_replace(".", "", $work);
    $work = str_replace("\n", "", $work);
    $work = str_replace("\r", "", $work);
    return $work;
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


    ///////////////////////////
    ///////////////////////////
    // get customer emails from appointments database
    $custEmail = array();
    $custAddress = array();
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

    while ($rowAssociativeArray = $result->fetch_assoc()) {
        $rowEntity = clone $itemToClone;
        $rowEntity->populateFromDatabaseTableAssociativeArray($rowAssociativeArray);
        array_push($custEmail, $rowEntity->modelGetField("CustEmail"));
        $temp = refine($rowEntity->modelGetField("CustStreet"));
        if ($temp !== "x") {
            array_push($custAddress, $temp);
        }
    }
    echo "<br>-------------------------<br>";
    echo "<br>there are " . count($custEmail) . " customer emails";
    echo "<br>there are " . count($custAddress) . " customer streets";
    //    foreach ($custEmail as $email) {
    //       echo "<br>" . $email;
    //    }
    //    foreach ($custAddress as $address) {
    //        echo "<br>" . $address;
    //    }


    ///////////////////////////
    ///////////////////////////
    // get parent and kid emails from roster database
    $parentsAndKidsEmail = array();
    $parentsAndKidsAddress = array();

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
        $temp = refine($rowEntity->modelGetField("address"));
        if ($temp !== "x") {
            array_push($parentsAndKidsAddress, $temp);
        }
    }

    echo "<br>-------------------------<br>";
    echo "<br>there are " . count($parentsAndKidsEmail) . " parent/rower emails";
    echo "<br>there are " . count($parentsAndKidsAddress) . " parent/rower addresses";
    //    foreach ($parentsAndKidsEmail as $email) {
    //        echo "<br>" . $email;
    //    }
    //   foreach ($parentsAndKidsAddress as $address) {
    //       echo "<br>" . $address;
    //   }


    echo "<br>---------matchups----------------<br>";
    ////////////////////////
    // look for an email match
    foreach ($parentsAndKidsEmail as $pkEmail) {
        if (in_array($pkEmail, $custEmail)) {
            echo "<br>found match -> " . $pkEmail . "<br>";
        }
    }

    /////////////////////////
    // look for a street address match
    foreach ($parentsAndKidsAddress as $pkAddr) {
        foreach ($custAddress as $cAddr) {
          //  if (strpos("squirrel", $pkAddr) !== false) {
          //      echo "<br>checking " . $pkAddr . " and " . $cAddr . "<br>";
          //  }

            if (strpos($cAddr, $pkAddr) !== false) {
                echo "<br>found match -> " . $pkAddr . " --> " . $cAddr . "<br>";
            }
        }
    }


    ////////////////
    // roster as a street address
    // customer appointment has an entire address streeet, town
    // see if roster address shows up in any of the customer addresses


    ?>

</div>
</body>
</html>



