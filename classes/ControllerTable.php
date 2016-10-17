<?php

/**
 * Class ControllerTable
 */
class ControllerTable implements InterfaceTableDatabase, InterfaceTableCsv, InterfaceTableView, MatchUppableInterface {

    protected $localTable;
    private $databaseTableOrFileName;
    private $databaseCommonName;
    private $itemToClone;
    private $ini; // from config file

    ///////////////////////////////////////
    // METHODS SPECIFIC TO THIS CLASS

    function __construct($databaseTableOrFileName, $commonName, $itemToClone) {
        $this->databaseTableOrFileName = $databaseTableOrFileName;
        $this->databaseCommonName = $commonName;
        $this->itemToClone = $itemToClone;

        $this->ini = parse_ini_file($GLOBALS['meatpacker_config_file']);
    }

    public function getDatabaseTableOrFileName() {
        return $this->databaseTableOrFileName;
    }

    public function getCommonName() {
        return $this->databaseCommonName;
    }

    public function getTable() {
        return $this->localTable;
    }

    public function modelGetRow($rowNum) {
        return $this->localTable[$rowNum];
    }

    //////////////////////////////////////////
    // METHODS REQUIRED BY THE DATABASE INTERFACE

    public function databaseRead() {
        $db = mysqli_connect($this->ini['databasehost'], $this->ini['databaseusername'], $this->ini['databasepassword'], $this->ini['databasename']);
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

    public function databaseDeleteItem($itemToDelete) {
        $rowIdKeyname = $itemToDelete->modelGetIdFieldName();
        $rowIdKeyval = $itemToDelete->modelGetField($rowIdKeyname);

        $db = mysqli_connect($this->ini['databasehost'], $this->ini['databaseusername'], $this->ini['databasepassword'], $this->ini['databasename']);
        $sql = "DELETE FROM $this->databaseTableOrFileName WHERE $rowIdKeyname=$rowIdKeyval";
        $result = mysqli_query($db, $sql);
        mysqli_close($db);
        if (!$result) {
            trigger_error("database query failed: ", E_USER_ERROR);
        }
    }

    public function databaseAddItem($itemToAdd) {
        $tableArray = $itemToAdd->getAsAssociativeArrayForDatabaseTable();

        $db = mysqli_connect($this->ini['databasehost'], $this->ini['databaseusername'], $this->ini['databasepassword'], $this->ini['databasename']);
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

    public function csvRead($skipFirstLine) {
        $this->localTable = array();

        if (($handle = fopen($this->databaseTableOrFileName, "r")) !== FALSE) {
            // while (($data = fgetcsv(, 1000, ",", "//")) !== FALSE) {
            // while (($data = fgetcsv($handle, ",", "//")) !== FALSE) {
            while (($row = fgetcsv($handle)) !== FALSE) {

                if ($GLOBALS['debug']) {
                    echo "<br>input line is:<br>";
                    var_dump($row);
                    echo "<br>";
                }

                if ($skipFirstLine) {
                    $skipFirstLine = 0;
                } else {
                    $rowEntity = clone $this->itemToClone;
                    $rowEntity->populateFromAssociativeArrayCsvFile($row);
                    array_push($this->localTable, $rowEntity);
                }
            }
            fclose($handle);
        } else {
            echo "<br>unable to open file " . $this->databaseTableOrFileName . "<br>";
            exit;
        }
    }

//////////////////////////////////
// METHODS REQUIRED BY THE VIEW INTERFACE
// reference relating to "table" - laying out / wrapping, etc
// http://stackoverflow.com/questions/6253963/table-with-table-layout-fixed-and-how-to-make-one-column-wider

    public
            function viewAsHtmlTable() {
        echo '<br>';
        echo '
<!-- used to make table sort-able -->
<script src="../common_functions/sorttable.js"></script>
';

        echo '
<style> table {
    table-layout: fixed;
    border-collapse: collapse;
    width: 100%;
    border: 1px solid black;
    font-size: 0.6em;
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

    public
            function rowNumbers() {
        return array_keys($this->localTable);
    }

    public
            function columnsAll() {
        $aRow = reset($this->localTable);
        if (!$aRow) {
            return array();
        }
        return $aRow->modelGetColumnsAll();
    }

    public
            function modelGetColumnsToDisplay() {
        $aRow = reset($this->localTable);
        if (!$aRow) {
            return array();
        }
        return $aRow->modelGetColumnsToDisplay();
    }

    public
            function getDataElement($rowId, $colId) {
        $myRow = $this->localTable[$rowId];
        return $myRow->modelGetField($colId);
    }

}
