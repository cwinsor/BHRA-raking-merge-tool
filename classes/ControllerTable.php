<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

/**
 * Class ControllerTable
 */
class ControllerTable implements InterfaceTableDatabase, InterfaceTableCsv, InterfaceTableView, MatchUppableInterface
{

    private $databaseTableOrFileName;
    private $databaseCommonName;
    private $itemToClone;

    protected $localTable;


    ///////////////////////////////////////
    // METHODS SPECIFIC TO THIS CLASS

    function __construct($databaseTableOrFileName, $commonName, $itemToClone)
    {
        $this->databaseTableOrFileName = $databaseTableOrFileName;
        $this->databaseCommonName = $commonName;
        $this->itemToClone = $itemToClone;
    }

    public function getDatabaseTableOrFileName()
    {
        return $this->databaseTableOrFileName;
    }

    public function getCommonName()
    {
        return $this->databaseCommonName;
    }

    public function getTable()
    {
        return $this->localTable;
    }


    public function modelGetRow($rowNum)
    {
        return $this->localTable[$rowNum];
    }



    //////////////////////////////////////////
    // METHODS REQUIRED BY THE DATABASE INTERFACE

    public function databaseRead()
    {
        include "../.env_database_password";
        $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
        $sql = "SELECT * FROM $this->databaseTableOrFileName";
        $result = mysqli_query($db, $sql);
        mysqli_close($db);
        if (!$result) {
            trigger_error("database query failed: ", E_USER_ERROR);
        }

        $this->localTable = array();
        while ($rowAssociativeArray = $result->fetch_assoc()) {
            $rowEntity = clone $this->itemToClone;
            $rowEntity->populateFromDatabaseTableAssociativeArray($rowAssociativeArray);
            array_push($this->localTable, $rowEntity);
        }
    }


    public function databaseDeleteItem($itemToDelete)
    {
        $rowIdKeyname = $itemToDelete->modelGetIdFieldName();
        $rowIdKeyval = $itemToDelete->modelGetField($rowIdKeyname);

        include "../.env_database_password";
        $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
        $sql = "DELETE FROM $this->databaseTableOrFileName WHERE $rowIdKeyname=$rowIdKeyval";
        $result = mysqli_query($db, $sql);
        mysqli_close($db);
        if (!$result) {
            trigger_error("database query failed: ", E_USER_ERROR);
        }
    }

    public function databaseAddItem($itemToAdd)
    {
        $tableArray = $itemToAdd->getAsAssociativeArrayForDatabaseTable();

        include '../.env_database_password';
        $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
        $sql = "INSERT INTO $this->databaseTableOrFileName (";
        $first = true;
        foreach ($tableArray as $key => $value) {
            $sql .= (($first) ? (' ') : (', ')) . $key;
            $first = false;
        }
        $sql .= ") VALUES (";
        $first = true;
        foreach ($tableArray as $key => $value) {
            $sql .= (($first) ? (' "') : (', "')) . $value . '"';
            $first = false;
        }
        $sql .= ");";
        $rtn = mysqli_query($db, $sql);
        mysqli_close($db);
        if (!$rtn) {
            trigger_error("database was not happy(1): $sql", E_USER_NOTICE);
        }
    }


    //////////////////////////////////////////
    // METHODS REQUIRED BY THE CSV INTERFACE

    public function csvRead()
    {
        $this->localTable = array();

        // reference:
        // http://php.net/manual/en/function.str-getcsv.php
        //
        // ALSO - WARNING ABOUT LINE BREAKS for "file" ... (see comment from Martin K.)
        // http://php.net/manual/en/function.file.php
        //
        $blah = fopen($this->databaseTableOrFileName, 'r');
        $csvAsArray = array_map('str_getcsv', file($this->databaseTableOrFileName));
        fclose($blah);

        foreach ($csvAsArray as $row) {
            $rowEntity = clone $this->itemToClone;
            $rowEntity->populateFromAssociativeArrayCsvFile($row);
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
        echo "<caption>$this->databaseTableOrFileName</caption>";
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



    //////////////////////////////////////////////
    // METHODS REQUIRED BY MatchUppableInterface

    public function rowNumbers()
    {
        return array_keys($this->localTable);
    }

    public function columnsAll()
    {
        $aRow = reset($this->localTable);
        if (!$aRow) {
            return array();
        }
        return $aRow->modelGetColumnsAll();
    }

    public function getDataElement($rowId, $colId)
    {
        $myRow = $this->localTable[$rowId];
        return $myRow->modelGetField($colId);
    }


}

