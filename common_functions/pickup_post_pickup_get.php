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

