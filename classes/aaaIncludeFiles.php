<?php
$GLOBALS['debug'] = 0;
date_default_timezone_set('America/New_York');

// config file is located outside the web root
$GLOBALS['meatpacker_config_file'] = $_SERVER["DOCUMENT_ROOT"] . "/../meatpacker_config.ini";
require_once("../common_functions/my_error_handler.php");
set_error_handler("my_error_handler");
include_once "../common_functions/pickup_post_pickup_get.php";
include_once "../common_functions/cleanse.php";
include_once "ClassDateTime.php";
include_once "ClassTeams.php";
include_once "InterfaceRowDatabase.php";
include_once "InterfaceRowCsv.php";
include_once "InterfaceRowSchedulable.php";
include_once "InterfaceTableDatabase.php";
include_once "InterfaceTableCsv.php";
include_once "InterfaceTableView.php";
include_once "MatchUppableInterface.php";
include_once "MatchUppableClass.php";
include_once "MatchUppableClassToAssignmentsDbFromAppointmentsDb.php";
include_once "MatchUppableClassToAssignmentsDbFromRakersDb.php";
include_once "MatchUppableClassToAssignmentsDbFromSupervisorsDb.php";
include_once "MatchUppableClassRosterCsvToRakersDb.php";
include_once "MatchUppableClassRosterCsvToParentsDb.php";
include_once "MatchUppableClassSupersaasCsvToAppointmentsDb.php";
include_once "MatchUppableClassVolunteerspotRakersCsvToVolunteerspotRakersDb.php";
include_once "ControllerRow.php";
include_once "ControllerRowRosterRaker.php";
include_once "ControllerRowRosterParent.php";
include_once "ControllerRowVolunteerspotRaker.php";
include_once "ControllerRowAppointment.php";
include_once "ControllerTable.php";
// danger - enabling this content will preclude redirect since this content
// shows up early in the .html, and redirect is required to occur before any
// content.  Thus debug messages like these, before content, will cause redirect
// to not work.
//    echo '<br>' . '--- PARAMETERS FROM POST ---' . '<br>';
//    echo '<br>' . var_dump($_POST);
//    echo '<br>';
//
//    echo '<br>' . '--- PARAMETERS FROM GET ---' . '<br>';
//    echo '<br>' . var_dump($_GET);
//    echo '<br>';
//}
?>