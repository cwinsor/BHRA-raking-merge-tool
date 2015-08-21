<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

/**
 * Class ControllerTable
 */
abstract class ControllerTable implements InterfaceTableDatabase, InterfaceTableCsv, InterfaceTableView
{

    private $databaseTableName;

    protected $localTable;

    function __construct($databaseTableName)
    {
        $this->databaseTableName = $databaseTableName;
    }

    function getName()
    {
        return $this->databaseTableName;
    }

    //////////////////////////////////////////
    // METHODS REQUIRED BY THE DATABASE INTERFACE

    public function databaseRead($itemToClone)
    {
        include "../.env_database_password";
        $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
        $sql = "SELECT * FROM $this->databaseTableName";
        $result = mysqli_query($db, $sql);
        mysqli_close($db);
        if (!$result) {
            trigger_error("database query failed: ", E_USER_ERROR);
        }

        $this->localTable = array();
        while ($rowAssociativeArray = $result->fetch_assoc()) {
            $rowEntity = clone $itemToClone;
            $rowEntity->databasePopulateFromAssociativeArray($rowAssociativeArray);
            array_push($this->localTable, $rowEntity);
        }

//        echo "<br>---- here having read from database ---<br>";
//        foreach ($this->localTable as $assocRow) {
//            echo "<br>";
//            var_dump($assocRow);
//            echo "<br>";
//        }
    }

    public function databaseUpdateById($id)
    {
        exit("not coded!");
    }


    //////////////////////////////////////////
    // METHODS REQUIRED BY THE CSV INTERFACE

    public function csvRead($itemToClone, $filename)
    {
        $this->localTable = array();

        // reference:
        // http://php.net/manual/en/function.str-getcsv.php
        $csvAsArray = array_map('str_getcsv', file($filename));

        foreach ($csvAsArray as $row) {
            $rowEntity = clone $itemToClone;
            $rowEntity->populateFromRosterFile($row);
            array_push($this->localTable, $rowEntity);
        }
    }


    //////////////////////////////////
    // METHODS REQUIRED BY THE VIEW INTERFACE
    // reference relating to "table" - laying out / wrapping, etc
    // http://stackoverflow.com/questions/6253963/table-with-table-layout-fixed-and-how-to-make-one-column-wider

    public function viewAsHtmlTable()
    {
        echo '<br>';
        echo '
<!-- used to make table sort-able -->
<script src="../content_mappable/sorttable.js"></script>
';

        echo '
<style> table {
    table-layout: fixed;
    border-collapse: collapse;
    width: 100%;
    border: 1px solid black;
    font-size: 0.9em;
    word-wrap: break-word;
}
td {
    border: 1px solid black;
}
th {
    border: 1px solid black;
}
</style>
';


        echo '<table class=sortable>';
        echo "<caption>$this->databaseTableName</caption>";
        $headPrinted = false;

        foreach ($this->localTable as $rowNum => $rowData) {

            // print header
            if (!$headPrinted) {
                $headPrinted = true;
                echo '<thead><tr>';
                echo "<th>num</th>";
                foreach ($rowData->asArray() as $colKey => $colValue) {
                    echo "<th>$colKey</th>";
                }
                echo '</tr></thead>';
                echo '<tbody>';
            }

            // print row of data
            echo '<tr>';
            echo "<td>$rowNum</td>";
            foreach ($rowData->asArray() as $colValue) {
                echo "<td>$colValue</td>";
            }
            echo '</tr>';
        }
        echo '</tbody></table><br>';
    }




    ///////////////////////////////////////
    // METHODS SPECIFIC TO THIS CLASS

    /**
     * Get a row by row number
     * @param $rowNum
     * @return mixed
     */
    public
    function modelGetRow($rowNum)
    {
        return $this->localTable[$rowNum];
    }

}

