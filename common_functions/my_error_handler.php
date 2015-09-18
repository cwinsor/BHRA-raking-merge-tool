<?php

//error function
//reference:
//http://php.net/manual/en/function.set-error-handler.php
//
// example:
// require_once("my_error_handler.php");
// set_error_handler("my_error_handler");
// $value = 5;
// $text = "yucky";
// trigger_error("this is error with $text message about $value", E_USER_ERROR);
// trigger_error("this is warning with $text message about $value", E_USER_WARNING);
// trigger_error("this is notice with $text message about $value", E_USER_NOTICE);

function my_error_handler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
        echo "<br><b>My ERROR</b> $errstr<br>\n";
        echo "  On line $errline of $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br>\n";
        echo "Aborting...<br />\n";
        exit(1);
        break;

    case E_USER_WARNING:
        echo "<br><b>My WARNING</b> $errstr<br>\n";
        echo "  On line $errline of $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br>\n";
        break;

    case E_USER_NOTICE:
        echo "<br><b>My NOTICE</b> $errstr<br>\n";
        echo "  On line $errline of $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br>\n";
        break;

    default:
        echo "<br><b>My UNKNOWN ERROR TYPE</b>: (errno=$errno) $errstr<br>\n";
        echo "  On line $errline of $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br>\n";
        return false;
        break;
    }

    /* Don't execute PHP internal error handler */
    return true;
}

?>