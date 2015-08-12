<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

class RowersCsvFileVolunteerSite implements InterfaceMappableCsvToDatabase
{

    public function getSlugMap()
    {
        return array(
            4 => 'volunteerSiteFirstname',
            5 => 'volunteerSiteLastname'
        );
    }

    public function getDataMap()
    {
        $dataMap = array(
            8 => 'volunteerSlots'
        );
    }
}
