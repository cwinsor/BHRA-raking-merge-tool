<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

class Rower
{

   // InterfaceDatabaseEnabled
//    public function getId();
//    public function updateDatabase()
    
    
    public getFieldValue($fieldNumber);
    public getField($fieldName);
    
    // an array of just values
    // header is maintained by 
    $fieldArray;
    
    
    
    public $id;

    public $firstName;

    public $lastName;

    public $workShift;

    public $teamNumber;
    
    // send to database
    // if the ID does not exist the record is new
    // if the ID exists it is an update
    public function updateDatabase()
    {
        include '../.env_database_password';
        $databasetable = "v2volunteerRakers";
        
        $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
        
        if (! $id)
        {
            $sql = sprintf("INSERT INTO $databasetable
                            (firstName, lastName, workShift, teamNumber)
                             VALUES (%s, %s, %s, %s);", $firstName, $lastName, $workShift, $teamNumber, $id);
        } else
        {
            $sql = sprintf("UPDATE $databasetable SET
                            firstName='%s',
                            lastName='%s',
                            workShift='%s',
                            teamNumber='%s'
                            WHERE id=%d;", $firstName, $lastName, $workShift, $teamNumber, $id);
        }
        $rtn = mysqli_query($db, $sql);
        mysqli_close($db);
        
        if (! $rtn)
        {
            trigger_error("database was not happy: $sql", E_USER_NOTICE);
        }
        // DEBUG
        // trigger_error("to database: $sql", E_USER_NOTICE);
    }


    public function slugMatch($that)
    {
          return compare($that, $fields);
     }

    public function dataMatch($that, $fields)
    {
        return compare($that, $fields);
    }


    private function compare($that, $fields)
    {
        $missList = [];
        foreach ($fields as $fieldKey => $fieldValue)
        {
            if (!($this->fields[$thisFieldNum] === $that->fields[$thatFieldNum]))
            {
                $missList[$thisFieldNum] => $thatFieldNum;
            }
            return $missList;
        }
           }