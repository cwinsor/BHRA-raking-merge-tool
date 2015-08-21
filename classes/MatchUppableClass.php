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

        // sanity check
        if (count($a->columnsNameslug()) != count($b->columnsNameslug())) {
            exit('in MatchUppableClass - the number of matchable slug elements in A and B do not match');
        }
        if (count($a->columnsDataslug()) != count($b->columnsDataslug())) {
            exit('in MatchUppableClass - the number of matchable data elements in A and B do not match');
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

        // debug...
        echo "\n<br>---- comparableSlugA/B ------------<br>";
        var_dump($comparableSlugA);
        echo "\n<br>";
        var_dump($comparableSlugB);
        echo "\n<br>---- comparableDataA/B ------------<br>";
        var_dump($comparableDataA);
        echo "\n<br>";
        var_dump($comparableDataB);
        echo "\n<br>-----------------------------------<br>";

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
        $this->viewAsHtmlInABgivenRowList($this->inAandBwithDataMatch, "The following are in both A and B with matching data");
    }

    /*
    * Get a html view of the matchups (A<->B where data does NOT match)
    */
    public function viewAsHtmlInABwithDataMismatch()
    {
        $this->viewAsHtmlInABgivenRowList($this->inAandBnoDataMatch, "The following are in both A and B but data does not match");
    }

    /*
     * Common function to display (A<->B) matchup
     */
    public function viewAsHtmlInABgivenRowList($rowNumbersAB, $msg)
    {

        // generate html
        echo "\n<br>" . $msg;
        echo "\n<table class=sortable>";
        echo "\n<caption>" . $this->a->getName() . " <---> " . $this->b->getname() . "</caption>";


        /////////////////
        // print header

        echo "\n<thead>";
        echo "\n<tr>";
        foreach ($this->a->columnsNameslug() as $colId) {
            echo "<th>$colId</th>";
        }
        foreach ($this->a->columnsDataslug() as $colId) {
            echo "<th>$colId</th>";
        }
        echo "<th><---></th>";
        foreach ($this->b->columnsNameslug() as $colId) {
            echo "<th>$colId</th>";
        }
        foreach ($this->b->columnsDataslug() as $colId) {
            echo "<th>$colId</th>";
        }
        echo "<th></th>";
        echo "<th>action</th>";

        echo "\n</tr>";
        echo "\n</thead>";


        //////////////////////
        // print data rows

        echo "\n<tbody>";
        echo "\n<tr>";
        foreach ($rowNumbersAB as $rowNumberA => $rowNumberB) {
            foreach ($this->a->columnsNameslug() as $colId) {
                echo "<td>" . $this->a->getDataElement($rowNumberA, $colId) . "</td>";
            }
            foreach ($this->a->columnsDataslug() as $colId) {
                echo "<td>" . $this->a->getDataElement($rowNumberA, $colId) . "</td>";
            }
            echo "<th><---></th>";
        }
        foreach ($rowNumbersAB as $rowNumberA => $rowNumberB) {
            foreach ($this->b->columnsNameslug() as $colId) {
                echo "<td>" . $this->b->getDataElement($rowNumberB, $colId) . "</td>";
            }
            foreach ($this->b->columnsDataslug() as $colId) {
                echo "<td>" . $this->b->getDataElement($rowNumberB, $colId) . "</td>";
            }
            echo "<th></th>";
            echo "<td>blah</td>";
            echo "\n</tr>";
        }
        echo "\n</tbody>";
        echo "\n</table>";
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
            "The following are only in A",
            true, true);
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
            "The following are only in B",
            false, true);
    }

    /*
     * Common function to display (A<->B) matchup
     */
    public function viewAsHtmlSingleTableGivenRowList($theTable, $rowNumbers, $msg, $act1, $act2)
    {

        // generate html
        echo "\n<br>" . $msg;
        echo "\n<table class=sortable>";
        echo "\n<caption>" . $theTable->getName() . "</caption>";


        /////////////////
        // print header

        echo "\n<thead>";
        echo "\n<tr>";
        foreach ($theTable->columnsNameslug() as $colId) {
            echo "<th>$colId</th>";
        }

        echo "<th></th>";
        if ($act1) {
            echo "<th>action1</th>";
        }
        if ($act2) {
            echo "<th>action2</th>";
        }
        echo "\n</tr>";
        echo "\n</thead>";


        //////////////////////
        // print data rows

        echo "\n<tbody>";
        foreach ($rowNumbers as $rowNumber) {
            echo "\n<tr>";
            foreach ($theTable->columnsNameslug() as $colId) {
                echo "<td>" . $theTable->getDataElement($rowNumber, $colId) . "</td>";
            }


            echo "<td></td>";
            if ($act1) {
                echo "<td>do 1</td>";
            }
            if ($act2) {
                echo "<td>do 2</td>";
            }
            echo "\n</tr>";
        }
        echo "\n</tbody>";
        echo "\n</table>";
        echo "\n<br>";

    }


}