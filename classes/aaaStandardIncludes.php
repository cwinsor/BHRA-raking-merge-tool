<?php

$GLOBALS['debug'] = 0;

include_once "../common_functions/pickup_post_pickup_get.php";
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
include_once "MatchUppableClassSupersaasCsvToAppointmentsDb.php";
include_once "MatchUppableClassVolunteerspotRakersCsvToVolunteerspotRakersDb.php";
include_once "ControllerRow.php";
include_once "ControllerRowRosterRaker.php";
include_once "ControllerRowVolunteerspotRaker.php";
include_once "ControllerRowAppointment.php";
include_once "ControllerTable.php";
?>