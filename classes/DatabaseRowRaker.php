<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

class DatabaseRowRaker extends DatabaseRow
{
    
    // //////////////
    // interacting with the database
    // (methods required by the database interface)
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
        echo '<br> ====== HERE!!! <br>';
    }

    public function databaseNewRow($tablename)
    {
        include '../.env_database_password';
        $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
        $sql = sprintf("INSERT INTO $databasetable
            (firstName, lastName, workShift, teamNumber)
            (rosterFirstname, rosterLastname, volunteerSiteFirstname, volunteerSiteLastname, cellphone, gender, volunteerSlots)
            VALUES (%s, %s, %s, %s, %s, %s, %s);", $this->fields['rosterFirstname'], $this->fields['rosterLastname'], $this->fields['volunteerSiteFirstname'], $this->fields['volunteerSiteLastname'], $this->fields['cellphone'], $this->fields['gender'], $this->fields['volunteerSlots']);
        
        $rtn = mysqli_query($db, $sql);
        mysqli_close($db);
        if (! $rtn)
        {
            trigger_error("database was not happy(1): $sql", E_USER_NOTICE);
        }
    }

    public function databaseUpdateRowSelectedFields($tablename, $fieldlist)
    {
        die('not implemented');
    }

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
        if (! $rtn)
        {
            trigger_error("database was not happy(2): $sql", E_USER_NOTICE);
        }
        // DEBUG
        // trigger_error("to database: $sql", E_USER_NOTICE);
    }
}
    
   