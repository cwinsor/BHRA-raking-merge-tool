<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

abstract class DatabaseTable implements InterfaceToDatabaseTable
{

    private $databaseTableName;

    private $localTable;

    function __construct($databaseTableName)
    {
        $this->databaseTableName = $databaseTableName;
    }
    
    // //////////////
    // interacting with the database
    // (methods required by the database interface)
    public function databaseRead($itemToClone)
    {
        include '../.env_database_password';
        $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
        $sql = "SELECT * FROM $this->databaseTableName";
        $result = mysqli_query($db, $sql);
        mysqli_close($db);
        if (! $result)
        {
            trigger_error("database query failed: ", E_USER_ERROR);
        }
        
        $this->localTable = array();
        while ($rowAssociativeArray = $result->fetch_assoc())
        {
            $rowEntity = clone $itemToClone;
            $rowEntity->databasePopulateFromAssociativeArray($rowAssociativeArray);
            array_push($this->localTable, $rowEntity);
        }
        
        echo "<br>---- here having read from database ---<br>";
        foreach ($this->localTable as $assocRow)
        {
            echo "<br>";
            var_dump($assocRow);
            echo "<br>";
            // echo "<br>------ here ... ID= " . $row['id'];
        }
    }

    public function databaseUpdateById($id)
    {
        return $this->localTable[$id];
    }
    // ////////////////////////////////
    // interacting with this model
    public function modelGetById($id)
    {
        return $this->localTable[$id];
    }
}

