<?php


/**
 * Class MatchUppableClass
 *
 * This instance-able class provides mechanics to match up elements from two tables.
 * It expects in two tables A and B which have implemented the MatchUppableInterface.
 * This interface requires the implementor to define slug and data columns as well as
 * methods to get data elements (see the interface for details).
 *
 * A row-by-row compare is done based on slug and data, with the result being four categories:
 * - exact matches - rows in A which match exactly rows in B on both slug and data
 * - inexact matches - rows in A which match row in B on slug, but data does not match
 * - rows in A not in B, based on slug
 * - rows in B not in A, based on slug
 *
 * There are two pieces of infrastructure (interface and compare tool).
 * This file defines the interface.
 *
 * The interface requires a MatchUppable class to be able to:
 *
 * - rowIdList()
 * return a list of rowIds which constitute the list
 *
 * -  colIdListSlug()
 * return the list of column IDs that constitute the (to-be-compared) slug
 *
 * - colIdListData()
 * return the list of column IDs that constitute the (to-be-compared) data elements
 *
 * - getDataElement(rowId,colId)
 * return a single data element based on row, column
 *
 */
class MatchUppableClass
{

    private $a; // the "a" table to be compared
    private $b; // the "b" table to be compared

    private $inAandBwithDataMatch; // results - list of items in A and B with data match
    private $inAandBnoDataMatch; // results - list of items in A and B with no data match
    private $inAOnly; // results - list of items in A and not in B
    private $inBOnly; // results - list of items in B and not in A


    /**
     * Identify th etables to be compared.
     * @param $p
     * @param $b
     */
    public function setAB($a, $b)
    {
        $this->a = $a;
        $this->b = $b;

        // sanity check - if there is
        if ((count($a->columnsNameslug()) !=0) && (count($b->columnsNameslug()) != 0)) {
            if (count($a->columnsNameslug()) != count($b->columnsNameslug())) {
                echo '<br>a<br>';
                var_dump($a->columnsNameslug());
                echo '<br>b<br>';
                var_dump($b->columnsNameslug());
                echo '<br>';
                exit('in MatchUppableClass - the number of matchable slug elements in A and B do not match (above)');
            }
            if (count($a->columnsDataslug()) != count($b->columnsDataslug())) {
                echo '<br>a<br>';
                var_dump($a->columnsDataslug());
                echo '<br>b<br>';
                var_dump($b->columnsDataslug());
                echo '<br>';
                exit('in MatchUppableClass - the number of matchable data elements in A and B do not match');
            }
        }
    }


    /**
     * Perform a matching of A and B arrays.
     * This results in the following (stored locally)
     *   - list of elements in both (slug and data)     associative array of  idA -> idB
     *   - list of elements in both (slug but not data) associative array of  idA -> idB
     *   - list of elements in A but not B              indexed array of idA
     *   - list of elements in B but not A              indexed array of idB
     */
    public function performMatching()
    {

        // create array   rowNumber->nameslug
        $comparableSlugA = $this->getComparableNameslugList($this->a);
        $comparableSlugB = $this->getComparableNameslugList($this->b);

        // create array   rowNumber->dataslug
        $comparableDataA = $this->getComparableDataslugList($this->a);
        $comparableDataB = $this->getComparableDataslugList($this->b);

        /////////////////
        // debug...
//        echo "\n<br>---- comparableSlugA/B ------------<br>";
//        var_dump($comparableSlugA);
//        echo "\n<br>";
//        var_dump($comparableSlugB);
//        echo "\n<br>---- comparableDataA/B ------------<br>";
//        var_dump($comparableDataA);
//        echo "\n<br>";
//        var_dump($comparableDataB);
//        echo "\n<br>-----------------------------------<br>";

        // what is in both A and B
        // what slugs are in both A and B (intersection)
        // these functions return A[slug]->rowNum for those slugs in both A and B
        $this->inAandBwithDataMatch = [];
        $this->inAandBnoDataMatch = [];
        foreach ($comparableSlugA as $rowNumA => $slug) {
            $rowNumB = array_search($slug, $comparableSlugB);
            if (!($rowNumB === false)) {
                // Great - the slug is in both A and B
                // now see if there is a data match
                if ($comparableDataA[$rowNumA] == $comparableDataB[$rowNumB]) {
                    $this->inAandBwithDataMatch[$rowNumA] = $rowNumB;
                } else {
                    $this->inAandBnoDataMatch[$rowNumA] = $rowNumB;
                }
            }
        }

        // what is in A only
        $this->inAOnly = [];
        foreach ($comparableSlugA as $rowNumA => $slug) {
            $rowNumB = array_search($slug, $comparableSlugB);
            if ($rowNumB === false) {
                array_push($this->inAOnly, $rowNumA);
            }
        }

        // what is in B only
        $this->inBOnly = [];
        foreach ($comparableSlugB as $rowNumB => $slug) {
            $rowNumA = array_search($slug, $comparableSlugA);
            if ($rowNumA === false) {
                array_push($this->inBOnly, $rowNumB);
            }
        }
    }


    /**
     * Create a comparable nameSlug list.
     * This is done by concatenating fields identified as slug.
     * @param $theMatchuppableTable
     * @return array
     */
    private function getComparableNameslugList($theMatchuppableTable)
    {
        $comparableTable = [];
        foreach ($theMatchuppableTable->rowNumbers() as $rowNumber) {
            $thisRowAsArray = [];
            foreach ($theMatchuppableTable->columnsNameslug() as $colId) {
                array_push($thisRowAsArray, $theMatchuppableTable->getDataElement($rowNumber, $colId));
            }
            // concatenate into a single string
            $thisRowAsString = implode("|", $thisRowAsArray);
            $comparableTable[$rowNumber] = $thisRowAsString;
        }
        return $comparableTable;
    }

    /**
     * Create a comparable data list.
     * This is done by concatenating fields identified as data.
     * @param $theMatchuppableTable
     * @return array
     */
    private
    function getComparableDataslugList($theMatchuppableTable)
    {
        $comparableTable = [];
        foreach ($theMatchuppableTable->rowNumbers() as $rowNumber) {
            $thisRowAsArray = [];
            foreach ($theMatchuppableTable->columnsDataslug() as $colId) {
                array_push($thisRowAsArray, $theMatchuppableTable->getDataElement($rowNumber, $colId));
            }
            // concatenate into a single string
            $thisRowAsString = implode("|", $thisRowAsArray);
            $comparableTable[$rowNumber] = $thisRowAsString;
        }
        return $comparableTable;
    }


    /**
     * perform functions from POST
     */
    public function performGetAndPostFunctions()
    {
        if (isset($_POST["delete_row"])) {
            $this->deleteRowFromB($_POST["delete_row"]);
        }

        if (isset($_POST["add_row"])) {
            $this->addRowUsingA($_POST["add_row"]);
        }
    }

    public function deleteRowFromB($rowNum)
    {
        $row = $this->b->modelGetRow($rowNum);
        $this->b->databaseDeleteItem($row);
    }

    public function addRowUsingA($rowNum)
    {
        $row = $this->a->modelGetRow($rowNum);
        $this->b->databaseAddItem($row);
    }


    /**
     *
     */
    public function viewAsHtmlBasicSummary()
    {

        echo "\n<br>the following are in both A and B with data match";
        foreach ($this->inAandBwithDataMatch as $rowNumberA => $rowNumberB) {
            echo "\n<br> (a)row $rowNumberA maps to (b)row $rowNumberB";
        }

        echo "\n<br>the following are in both A and B with data miss";
        foreach ($this->inAandBnoDataMatch as $rowNumberA => $rowNumberB) {
            echo "\n<br> (a)row $rowNumberA maps to (b)row $rowNumberB";
        }
        echo "\n<br>the following are only in A";
        foreach ($this->inAOnly as $value) {
            echo "\n<br> (a)row $value";
        }
        echo "\n<br>the following are only in B";
        foreach ($this->inBOnly as $value) {
            echo "\n<br> (b)row $value";
        }
        echo '<br>';
    }


    /*
     * Get a html view of the matchups (A<->B where data DOES match)
     */
    public function viewAsHtmlInABwithDataMatch()
    {
        $this->viewAsHtmlInABgivenRowList($this->inAandBwithDataMatch,
            "The following are in both " .
            $this->a->getCommonName() .
            " and " .
            $this->b->getCommonName() .
            " with matching data",
            true);
    }

    /*
    * Get a html view of the matchups (A<->B where data does NOT match)
    */
    public function viewAsHtmlInABwithDataMismatch()
    {
        $this->viewAsHtmlInABgivenRowList($this->inAandBnoDataMatch,
            "The following are in both " .
            $this->a->getCommonName() .
            " and " .
            $this->b->getCommonName() .
            " with data that does NOT match",
            true);
    }

    /*
     * Common function to display (A<->B) matchup
     */
    public function viewAsHtmlInABgivenRowList($rowNumbersAB, $msg, $button_delete)
    {
        echo "\n<b>" . $msg . "</b>";
        if (count($rowNumbersAB) == 0) {
            echo "<br>(none)<br><br>";
            return;
        }

        ///////////////////////////////////////////
        // generate html
        echo "\n<form method=post>";

        echo "\n<table class=sortable>";

        /////////////////
        // print header

        echo "\n<thead>";
        echo "\n<tr>";
        echo "<th>source</th>";
        foreach ($this->a->columnsAll() as $colId) {
            echo "<th>$colId</th>";
        }
        echo "<th></th>";
        if ($button_delete) {
            echo "<th>delete</th>";
        }
        echo "\n</tr>";
        echo "\n</thead>";


        //////////////////////
        // print data rows

        echo "\n<tbody>";

        foreach ($rowNumbersAB as $rowNumberA => $rowNumberB) {
            echo "\n<tr>";
            echo "<th>" . $this->a->getCommonName() . "</th>";
            foreach ($this->a->columnsAll() as $colId) {
                if ($this->a->columnIsDataslug($colId)) {
                    echo "<td><i>" . $this->a->getDataElement($rowNumberA, $colId) . "</i></td>";
                } else {
                    echo "<td>" . $this->a->getDataElement($rowNumberA, $colId) . "</td>";
                }
            }
            echo "<th></th>";

            if ($button_delete) {
                echo "<th>-</th>";
            }
            echo "\n</tr>";

            echo "\n<tr>";
            echo "<th>" . $this->b->getCommonName() . "</th>";
            foreach ($this->b->columnsAll() as $colId) {
                if ($this->a->columnIsDataslug($colId)) {
                    echo "<td><i>" . $this->b->getDataElement($rowNumberB, $colId) . "</i></td>";
                } else {
                    echo "<td>" . $this->b->getDataElement($rowNumberB, $colId) . "</td>";
                }
            }
            echo "<th></th>";

            if ($button_delete) {
                echo '<th>';
                echo '<input type=submit name=delete_row value=' . $rowNumberB . '>';
                echo '</th>';
            }


            echo "\n</tr>";
        }
        echo "\n</tbody>";
        echo "\n</table>";
        echo "\n</form>";
        echo "\n<br>";
        echo "\n<br>";
    }


    /*
     * Get a html view of table items that are in A only
     * Present options assuming this is a CSV file
     */
    public function viewAsHtmlInAonly()
    {
        $this->viewAsHtmlSingleTableGivenRowList(
            $this->a,
            $this->inAOnly,
            "The following are only in " . $this->a->getCommonName(),
            true, false);
    }


    /*
     * Get a html view of table items that are in B only
     * Present options assuming this is a DATABASE
     */
    public function viewAsHtmlInBonly()
    {
        $this->viewAsHtmlSingleTableGivenRowList(
            $this->b,
            $this->inBOnly,
            "The following are only in " . $this->b->getCommonName(),
            false, true);
    }

    /*
     * Common function to display (A<->B) matchup
     */
    public
    function viewAsHtmlSingleTableGivenRowList($theTable, $rowNumbers, $msg, $button_add, $button_delete)
    {
        echo "\n<b>" . $msg . "</b>";
        if (count($rowNumbers) == 0) {
            echo "<br>(none)<br><br>";
            return;
        }

        ///////////////////////////////////////////
        // generate html
        echo "\n<form method=post>";

        echo "\n<table class=sortable>";

        /////////////////
        // print header

        echo "\n<thead>";
        echo "\n<tr>";
        echo "<th>source</th>";
        foreach ($theTable->columnsAll() as $colId) {
            echo "<th>$colId</th>";
        }

        echo "<th></th>";

        if ($button_add) {
            echo "<th>add</th>";
        }

        if ($button_delete) {
            echo "<th>delete</th>";
        }

        echo "\n</tr>";
        echo "\n</thead>";


//////////////////////
// print data rows

        echo "\n<tbody>";
        foreach ($rowNumbers as $rowNumber) {
            echo "\n<tr>";
            echo "<th>" . $theTable->getCommonName() . "</th>";

            foreach ($theTable->columnsAll() as $colId) {
                if ($theTable->columnIsDataslug($colId)) {
                    echo "<td><i>" . $theTable->getDataElement($rowNumber, $colId) . "</i></td>";
                } else {
                    echo "<td>" . $theTable->getDataElement($rowNumber, $colId) . "</td>";
                }
            }


            echo "<th></th>";

            if ($button_delete) {
                echo '<th>';
                echo '<input type=submit name=delete_row value=' . $rowNumber . '>';
                echo '</th>';
            }
            if ($button_add) {
                echo '<th>';
                echo '<input type=submit name=add_row value=' . $rowNumber . '>';
                echo '</th>';
            }
            echo "\n</tr>";
        }
        echo "\n</tbody>";
        echo "\n</table>";
        echo "\n</form>";
        echo "\n<br>";
        echo "\n<br>";
    }


}