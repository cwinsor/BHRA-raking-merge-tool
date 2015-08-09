
<div id="navigation">
<?php
include '../navigation/functions.php';
Navigation();
?>
</div>
<?php
include_once "MappingTool.php";
include_once "rowList.php";
include_once "RowSingle.php";
include_once "RowSingleStudent.php";
?>


<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php
// recover previous session
session_start();

// if there is a request to kill the sesson
// or the session started above is not proper
// then kill and restart
if ((isset($_POST["restartSession"])) || (! isset($_SESSION['id'])))
{
    // kill the sesson
    $sessionRestarted = 1;
    session_unset();
    session_destroy();
    
    // create an instance of MappingTool
    $rowList1 = new RowList('Things1');
    $rowList1->addRowSingle(new RowSingleStudent("Apple", "Baker", 1));
    $rowList1->addRowSingle(new RowSingleStudent("Charley", "Dogma", 2));
    $rowList2 = new RowList('Things2');
    $rowList2->addRowSingle(new RowSingleStudent("Elvis", "Franklin", 3));
    $rowList2->addRowSingle(new RowSingleStudent("Greg", "House", 4));
    $rowList2->addRowSingle(new RowSingleStudent("Inka", "Joule", 5));
    $mappingTool = new MappingTool($rowList1, $rowList2);
    
    // start a proper session
    session_start();
    $date = new DateTime();
    // $_SESSION['id'] = $date->getTimestamp();
    // setlocale(LC_TIME, "de_DE"); // only necessary if the locale isn't already set
    // $formatted_time = strftime("%a %e.%l.%Y", $mytime->getTimestamp());
    // $formatted_time = strftime("%a %e.%l.%Y", $date->getTimestamp());
    $_SESSION['id'] = $date->format('Y-m-d H:i:s');
    
    // add mappingTool to the session
    $_SESSION['mappingTool'] = $mappingTool;
} else
{
    $sessionRestarted = 0;
}
?>




<?php
// evaluate POST attribute, return it's value if set, otherwise return ""
function pickupPostIfSet($attribute, &$rtn)
{
    $rtn = isset($_POST[$attribute]) ? $_POST[$attribute] : "";
}
// evaluate POST attribute, return specified value if set, otherwise return ""
function pickupPostIfSetWithVal($attribute, $valueIfSet, &$rtn)
{
    $rtn = isset($_POST[$attribute]) ? $valueIfSet : "";
}

// evaluate GET attribute, return it's value if set, otherwise return ""
function pickupGetIfSet($attribute, &$rtn)
{
    $rtn = isset($_GET[$attribute]) ? $_GET[$attribute] : "";
}
// evaluate GET attribute, return specified value if set, otherwise return ""
function pickupGetIfSetWithVal($attribute, $valueIfSet, &$rtn)
{
    $rtn = isset($_GET[$attribute]) ? $valueIfSet : "";
}
?>


<?php
// pick up POST and GET parameters
pickupPostIfSet("killSession", $postKillSession);
pickupPostIfSet("incrementSessionId", $postIncrementSessionId);
echo "<br> postIncrementSessionId = $postIncrementSessionId";
pickupPostIfSet('back', $postBack);
pickupPostIfSet('cars', $postCars);
pickupPostIfSetWithVal("vehicleBike", "checked", $postVehicleBike);
pickupPostIfSetWithVal("vehicleCar", "checked", $postVehicleCar);

pickupGetIfSet("makeSession", $getMakeSession);
pickupGetIfSet('back', $getBack);
pickupGetIfSet('cars', $getCars);
pickupGetIfSetWithVal("vehicleBike", "checked", $getVehicleBike);
pickupGetIfSetWithVal("vehicleCar", "checked", $getVehicleCar);
?>

   <?php
// processing of the mappable content
// if ($sessionRestarted)
// {
// $rowList1 = new RowList('Things1');
// $rowList1->addRowSingle(new RowSingleStudent("Apple", "Baker", 1));
// $rowList1->addRowSingle(new RowSingleStudent("Charley", "Dogma", 2));
// $rowList2 = new RowList('Things2');
// $rowList2->addRowSingle(new RowSingleStudent("Elvis", "Franklin", 3));
// $rowList2->addRowSingle(new RowSingleStudent("Greg", "House", 4));
// $rowList2->addRowSingle(new RowSingleStudent("Inka", "Joule", 5));
// $_SESSION['mappingTool'] = new MappingTool($rowList1, $rowList2);
// }
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
    <div id="navigation"></div>
    <div id="content">

    
	<?php
// print everything out...

echo '<br>' . '--- PARAMETERS FROM POST ---' . '<br>';
echo '<br>' . var_dump($_POST);
echo '<br>' . $postKillSession;
echo '<br>' . $postIncrementSessionId;
echo '<br>' . $postBack;
echo '<br>' . $postCars;
echo '<br>' . $postVehicleBike;
echo '<br>' . $postVehicleCar;

echo '<br>' . '--- PARAMETERS FROM GET ---' . '<br>';
echo '<br>' . var_dump($_GET);
echo '<br>' . $getMakeSession;
echo '<br>' . $getBack;
echo '<br>' . $getCars;
echo '<br>' . $getVehicleBike;
echo '<br>' . $getVehicleCar;
echo '<br>';

echo '<br>' . '---';
echo "<br> sessionRestarted = $sessionRestarted";
echo '<br>';
var_dump($_SESSION);

?>
  <br>
        -------------------------------------------------------
        <br>
        <br>
        --- VIEW (GET FORM)---
        <form
            method="get"
            action=""
        ><br> <input
            type="submit"
            name="showCars"
            value="showCars"
        > <br> <input
            type="submit"
            name="showBikes"
            value="showBikes"
        > <br> <input
            type="submit"
            name="showSkateboards"
            value="showSkateboards"
        > <br> Show drivers of: <select name="toShow">
                <option value="volvo drivers">Volvo</option>
                <option value="saab drivers">Saab</option>
                <option value="fiat drivers">Fiat></option>
                <option value="audi drivers">Audi</option>
        </select> <br> <input
            type="checkbox"
            name="vehicleBike"
        > Show bikes <br> <input
            type="checkbox"
            name="vehicleSkateboard"
            checked
        > Show skateboards <br> <input
            type="submit"
            name="submit"
            value="submit"
        ></form>


        <br>
        ---POST FORM---
        <form
            method="post"
            action=""
        ><br> My Car Is A: <select name="cars">
                <option value="volvo">Volvo</option>
                <option value="saab">Saab</option>
                <option value="fiat">Fiat</option>
                <option value="audi">Audi</option>
        </select> <br> <input
            type="checkbox"
            name="vehicleBike"
        > I have a bike <br> <input
            type="checkbox"
            name="vehicleSkateboard"
            checked
        > I have a skateboard <br> <input
            type="submit"
            name="submit"
            value="submit"
        > <br> <input
            type="submit"
            name="restartSession"
            value="restartSession"
        ></form>


        <br>
        ---POST FORM 2---
        <?php
        echo '<form method=post>';
        for ($row = 0; $row < 3; $row ++)
        
        {
            echo '
    <br>';
            for ($col = 0; $col < 5; $col ++)
            {
                $isChecked = ($row == $col) ? "checked" : "";
                echo "<input type=checkbox name=r_$row" . "_c_$col" . " $isChecked>";
            }
        }
        echo '
    <br>';
        echo '<input type="submit" name="submit" value="submit">';
        echo '</form>';
        ?>

        
        <br>
        ---POST FORM 3---
        <?php
        echo '<form method=post>';
        for ($row = 0; $row < 3; $row ++)
        {
            echo '
    <br>';
            for ($col = 0; $col < 5; $col ++)
            {
                $isPushed = ($row == $col);
                // echo '<input type="submit" name=r_$row_c_$col src=' . $isPushed ? 'submitedYes.gif' : 'submittedNo.gif' . '>';
                echo '<input type="submit" name=r_' . $row . '_c_' . $col . ($isPushed ? ' value=1>' : ' value=0>');
            }
        }
        echo '
    <br>';
        echo '</form>';
        ?>
        
        

    </div>
</body>
</html>