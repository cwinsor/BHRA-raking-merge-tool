<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

/**
 * Class ControllerRowRaker
 */
class ControllerRowRaker extends ControllerRow
{

    //////////////////////////////////////////////////
    // Methods required by the CSV interface
    public function populateFromRosterFile($rowAssociativeArray)
        {
            // map local fields from csv file
            $this->fields = array();

            $this->fields['id'] = 1234;;
            $this->fields['rosterFirstname'] = $rowAssociativeArray[2];
            $this->fields['rosterLastname'] = $rowAssociativeArray[3];
            $this->fields['cellphone'] = $rowAssociativeArray[8];
            $this->fields['gender'] = $rowAssociativeArray[4];
        }


    /////////////////////////////////////////////////
    // Methods required by the database interface

    /**
     * @param $rowAssociativeArray
     */
    public function databasePopulateFromAssociativeArray($rowAssociativeArray)
    {
        // map local fields from database fields
        // local field [name] <= database field [name]
        $this->fields = array();

        $this->fields['id'] = $rowAssociativeArray['id'];
        $this->fields['rosterFirstname'] = $rowAssociativeArray['rosterFirstname'];
        $this->fields['rosterLastname'] = $rowAssociativeArray['rosterLastname'];
        $this->fields['volunteerSiteFirstname'] = $rowAssociativeArray['volunteerSiteFirstname'];
        $this->fields['volunteerSiteLastname'] = $rowAssociativeArray['volunteerSiteLastname'];
        $this->fields['cellphone'] = $rowAssociativeArray['cellphone'];
        $this->fields['gender'] = $rowAssociativeArray['gender'];
        $this->fields['volunteerSlots'] = $rowAssociativeArray['volunteerSlots'];
    }

    /**
     * @param $tablename
     */
    public function databaseNewRow($tablename)
    {
        include '../.env_database_password';
        $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
        $sql = sprintf("INSERT INTO $tablename
            (firstName, lastName, workShift, teamNumber)
            (rosterFirstname, rosterLastname, volunteerSiteFirstname, volunteerSiteLastname, cellphone, gender, volunteerSlots)
            VALUES (%s, %s, %s, %s, %s, %s, %s);", $this->fields['rosterFirstname'], $this->fields['rosterLastname'], $this->fields['volunteerSiteFirstname'], $this->fields['volunteerSiteLastname'], $this->fields['cellphone'], $this->fields['gender'], $this->fields['volunteerSlots']);

        $rtn = mysqli_query($db, $sql);
        mysqli_close($db);
        if (!$rtn) {
            trigger_error("database was not happy(1): $sql", E_USER_NOTICE);
        }
    }

    /**
     * @param $tablename
     * @param $fieldlist
     */
    public function databaseUpdateRowSelectedFields($tablename, $fieldlist)
    {
        die('not implemented');
    }

    /**
     * @param $tablename
     */
    public function databaseUpdateRowAllfields($tablename)
    {
        include '../.env_database_password';
        $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
        $sql = sprintf("UPDATE $tablename SET
 rosterFirstname='%s',
 rosterLastname='%s',
 volunteerSiteFirstname='%s',
 volunteerSiteLastname='%s',
 cellphone='%s',
 gender='%s',
 volunteerSlots='%s'
 WHERE id=%d;", $this->fields['rosterFirstname'], $this->fields['rosterLastname'], $this->fields['volunteerSiteFirstname'], $this->fields['volunteerSiteLastname'], $this->fields['cellphone'], $this->fields['gender'], $this->fields['volunteerSlots'], $this->fields['id']);

        $rtn = mysqli_query($db, $sql);
        mysqli_close($db);
        if (!$rtn) {
            trigger_error("database was not happy(2): $sql", E_USER_NOTICE);
        }
        // DEBUG
        // trigger_error("to database: $sql", E_USER_NOTICE);
    }
}
    
   