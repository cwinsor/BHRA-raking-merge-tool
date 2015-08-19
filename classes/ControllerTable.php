<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

abstract class ControllerTable implements InterfaceTableDatabase, InterfaceTableView
{

    private $databaseTableName;

    private $localTable;

    function __construct($databaseTableName)
    {
        $this->databaseTableName = $databaseTableName;
    }

    /////////////
    // methods required by the view interface
    //
    // reference relating to "table" - laying out / wrapping, etc
    // http://stackoverflow.com/questions/6253963/table-with-table-layout-fixed-and-how-to-make-one-column-wider
    //
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
</style>
';


        echo '<table class=sortable>';
        echo "<caption>$this->databaseTableName</caption>";
        $headPrinted = false;

        foreach ($this->localTable as $row) {
            echo '<br>here1<br>';
            // print header
            if (!$headPrinted) {
                $headPrinted = true;
                echo '<thead><tr>';
                foreach ($row->asArray() as $rowKey => $rowValue) {
                    echo "<th>$rowKey</th>";
                }
                echo '</tr></thead>';
                echo '<tbody>';
            }
            echo '<br>here2<br>';
            // print row of data
            echo '<tr>';
            foreach ($row->asArray() as $rowValue) {
                echo "<td>$rowValue</td>";
            }
            echo '</tr>';
        }
        echo '</tbody></table><br>';
    }


////////////////
// methods required by the database interface)
    public
    function databaseRead($itemToClone)
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

        echo "<br>---- here having read from database ---<br>";
        foreach ($this->localTable as $assocRow) {
            echo "<br>";
            var_dump($assocRow);
            echo "<br>";
            // echo "<br>------ here ... ID= " . $row['id'];
        }
    }

    public
    function databaseUpdateById($id)
    {
        return $this->localTable[$id];
    }

// ////////////////////////////////
// interacting with this model
    public
    function modelGetById($id)
    {
        return $this->localTable[$id];
    }
}

