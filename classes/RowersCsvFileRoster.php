<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

class RowersCsvFileRoster implements InterfaceMappableCsvToDatabase
{

    public function getSlugMap()
    {
        return array(
            2 => 'rosterFirstname',
            3 => 'rosterLastname'
        );
    }

    public function getDataMap()
    {
        return array(
            6 => 'cellphone',
            7 => 'gender'
        );
    }
}
