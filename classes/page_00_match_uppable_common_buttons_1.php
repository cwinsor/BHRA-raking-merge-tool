<?php

$skipFirstLine = $getDisplayVerbose = "";
$skipFirstLineErr = $getDisplayVerboseErr = "";

// GET parameter to skip first line of input
if (empty($_GET["skipFirstLine"])) {
    $skipFirstLine = $skipFirstLineDefault;
} else {
    test_input($_GET["skipFirstLine"]);
    $skipFirstLine = strcmp(test_input($_GET["skipFirstLine"]), "yes") ? 0 : 1;
}

// GET parameter for verbose
if (empty($_GET["verbose"])) {
    $getDisplayVerbose = 0;
} else {
    test_input($_GET["verbose"]);
    $getDisplayVerbose = strcmp(test_input($_GET["verbose"]), "yes") ? 0 : 1;
}

?>