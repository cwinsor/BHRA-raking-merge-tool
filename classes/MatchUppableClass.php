<?php


/**
 * Class MatchUppableClass
 *
 * This class provides mechanics to match up elements from two tables.  It is abstract.
 * It expects as input two tables A and B which have implemented MatchUppableInterface.
 * A row-by-row compare is done based on slug and data, with the result being four categories:
 * - exact matches - rows in A which match exactly rows in B on both slug and data
 * - inexact matches - rows in A which match row in B on slug, but data does not match
 * - rows in A not in B, based on slug
 * - rows in B not in A, based on slug
 *
 */
abstract class MatchUppableClass
{

    private $a; // the "a" table to be compared
    private $b; // the "b" table to be compared

    private $inAOnly; // results - list of items in A and not in B
    private $inBOnly; // results - list of items in B and not in A
    private $inAandBnoDataMatch; // results - list of items in A and B with no data match
    private $inAandBwithDataMatch; // results - list of items in A and B with data match

    /**
     * Identify the tables to be compared.
     * @param $p
     * @param $b
     */
    public function setAB($a, $b)
    {
        if ($GLOBALS['debug']) {
            echo "<br>--- debug --- in MatchUppableClass - setAB ---<br>";
        }
        $this->a = $a;
        $this->b = $b;
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
        /////////////////
        // debug...
        if ($GLOBALS['debug']) {
            echo "<br>--- debug --- in MatchUppableClass - performMatching ---<br>";
        }

        $nameslugMapAB = $this->getNameslugMapAB();
        $dataslugMapAB = $this->getDataslugMapAB();

        if ($GLOBALS['debug']) {
            echo "<br> (nameslugMapAB)<br>";
            var_dump($nameslugMapAB);
            echo "<br> (dataslugMapAB)<br>";
            var_dump($dataslugMapAB);
            echo "<br>";
        }

        // generate array   rowNumber->nameslug
        $nameslugArrayA = $this->generateSlugArray($this->a, array_keys($nameslugMapAB));
        $nameslugArrayB = $this->generateSlugArray($this->b, array_values($nameslugMapAB));

        // generate array   rowNumber->nameslug
        $dataslugArrayA = $this->generateSlugArray($this->a, array_keys($dataslugMapAB));
        $dataslugArrayB = $this->generateSlugArray($this->b, array_values($dataslugMapAB));


        /////////////////
        // debug...
        if ($GLOBALS['debug']) {
            echo "\n<br>---- nameslugArrayA ------------<br>";
            var_dump($nameslugArrayA);
            echo "\n<br>";
            echo "\n<br>---- nameslugArrayB ------------<br>";
            var_dump($nameslugArrayB);
            echo "\n<br>";
            echo "\n<br>---- dataslugArrayA ------------<br>";
            var_dump($dataslugArrayA);
            echo "\n<br>";
            echo "\n<br>---- dataslugArrayB ------------<br>";
            var_dump($dataslugArrayB);
            echo "\n<br>";
        }


        // what is in A only
        $this->inAOnly = [];
        foreach ($nameslugArrayA as $rowNumA => $slug) {
            $rowNumB = array_search($slug, $nameslugArrayB);
            if ($rowNumB === false) {
                array_push($this->inAOnly, $rowNumA);
            }
        }

        // what is in B only
        $this->inBOnly = [];
        foreach ($nameslugArrayB as $rowNumB => $slug) {
            $rowNumA = array_search($slug, $nameslugArrayA);
            if ($rowNumA === false) {
                array_push($this->inBOnly, $rowNumB);
            }
        }

        // what is in both A and B
        // what slugs are in both A and B (intersection)
        // these functions return A[slug]->rowNum for those slugs in both A and B
        $this->inAandBnoDataMatch = [];
        $this->inAandBwithDataMatch = [];
        foreach ($nameslugArrayA as $rowNumA => $slug) {
            $rowNumB = array_search($slug, $nameslugArrayB);
            if (!($rowNumB === false)) {
                // Great - the slug is in both A and B
                // now see if there is a data match
                if ($dataslugArrayA[$rowNumA] == $dataslugArrayB[$rowNumB]) {
                    $this->inAandBwithDataMatch[$rowNumA] = $rowNumB;
                } else {
                    $this->inAandBnoDataMatch[$rowNumA] = $rowNumB;
                }
            }
        }

        /////////////////
        // debug...
        if ($GLOBALS['debug']) {
            echo "\n<br>---- inAandBwithDataMatch ------------<br>";
            var_dump($this->inAandBwithDataMatch);
            echo "\n<br>";

            echo "\n<br>---- inAandBnoDataMatch ------------<br>";
            var_dump($this->inAandBnoDataMatch);
            echo "\n<br>";

            echo "\n<br>---- inAOnly ------------<br>";
            var_dump($this->inAOnly);
            echo "\n<br>";

            echo "\n<br>---- inBOnly ------------<br>";
            var_dump($this->inBOnly);
            echo "\n<br>";
        }


    }

    abstract public function getNameslugMapAB();

    abstract public function getDataslugMapAB();


    /**
     * Create a comparable nameSlug list.
     * This is done by concatenating fields identified as slug.
     * @param $theMatchuppableTable
     * @return array
     */
    private function generateSlugArray($theMatchuppableTable, $theSlugColumns)
    {
        $comparableTable = [];
        foreach ($theMatchuppableTable->rowNumbers() as $rowNumber) {
            $thisRowAsArray = [];
            foreach ($theSlugColumns as $colId) {
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

        if (isset($_POST["del_all_from_db"])) {
            echo "<br>here1<br>";
            foreach ($this->b->getTable() as $row) {
                $this->b->databaseDeleteItem($row);
            }
        }

        if (isset($_POST["add_all_from_csv"])) {
            foreach ($this->a->getTable() as $row) {
                $this->b->databaseAddItem($row);
            }
        }
    }

    public
    function deleteRowFromB($rowNum)
    {
        $row = $this->b->modelGetRow($rowNum);
        $this->b->databaseDeleteItem($row);
    }

    public
    function addRowUsingA($rowNum)
    {
        $row = $this->a->modelGetRow($rowNum);
        $this->b->databaseAddItem($row);
    }

    public
    function viewAsHtmlBasicSummary()
    {

        echo "\n <br>the following are only in A";
        foreach ($this->inAOnly as $value) {
            echo "\n <br> (a)row $value";
        }

        echo "\n <br>the following are only in B";
        foreach ($this->inBOnly as $value) {
            echo "\n <br> (b)row $value";
        }

        echo "\n <br>the following are in both A and B with data miss";
        foreach ($this->inAandBnoDataMatch as $rowNumberA => $rowNumberB) {
            echo "\n <br> (a)row $rowNumberA maps to(b)row $rowNumberB";
        }

        echo "\n <br>the following are in both A and B with data match";
        foreach ($this->inAandBwithDataMatch as $rowNumberA => $rowNumberB) {
            echo "\n <br> (a)row $rowNumberA maps to(b)row $rowNumberB";
        }

        echo '<br>';
    }


    /**
     * Get html view of table items that are in A only
     * Present options assuming this is a CSV file
     */
    public
    function viewAsHtmlInAonly($display_verbose)
    {
        $this->viewAsHtmlSingleTableGivenRowList(
            $this->a,
            $this->inAOnly,
            "The following are only in " . $this->a->getCommonName(),
            true, false,
            $display_verbose);
    }

    /**
     * Get html view of table items (common function)
     */
    public
    function viewAsHtmlSingleTableGivenRowList($theTable, $rowNumbers, $msg, $button_add, $button_delete, $display_verbose)
    {
        echo " <caption><h3 > " . $msg . " </h3 ></caption > ";

        if (count($rowNumbers) == 0) {
            echo "<br> (none)<br><br> ";
            return;
        }

        // do we want to dislpay all fields, or abbreviated
        if ($display_verbose) {
            $the_columns = $theTable->columnsAll();
        } else {
            $the_columns = $theTable->modelGetColumnsToDisplay();
        }

        ///////////////////////////////////////////
        // generate html
        echo "<form method = post> ";

        //  echo "\n <table class=sortable > ";
        echo "\n<table> ";

        /////////////////
        // print header

        echo "\n<thead>";
        echo "\n<tr>";
        echo "<th>source </th > ";
        foreach ($the_columns as $colId) {
            echo "<th > $colId</th > ";
        }

        echo "<th ></th > ";

        if ($button_add) {
            echo "<th > add</th > ";
        }

        if ($button_delete) {
            echo "<th > delete</th > ";
        }

        echo "</tr > ";
        echo "\n</thead > ";


//////////////////////
// print data rows

        echo "\n<tbody>";
        foreach ($rowNumbers as $rowNumber) {
            echo "\n<tr>";
            echo "<th>" . $theTable->getCommonName() . " </th > ";

            foreach ($the_columns as $colId) {
                echo "<td > " . $theTable->getDataElement($rowNumber, $colId) . "</td > ";
            }


            echo "<th ></th > ";

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
            echo "</tr > ";
        }
        echo "\n</tbody > ";
        echo "\n</table > ";

//        if ($button_delete) {
//            echo '<input type=submit name=delete_all1 value=delete_all2>';
//        }
//        if ($button_add) {
//            echo '<input type=submit name=add_all value=add_all>';
//        }
        echo "\n</form > ";
        echo "\n<br>";
        echo "\n<br>";
    }

    /**
     * Get html view of table items that are in B only
     * Present options assuming this is a DATABASE
     */
    public
    function viewAsHtmlInBonly($display_verbose)
    {
        $this->viewAsHtmlSingleTableGivenRowList(
            $this->b,
            $this->inBOnly,
            "The following are only in " . $this->b->getCommonName(),
            false, true,
            $display_verbose);
    }

    /**
     * Get html view of the matchups A<->B where data does NOT match
     */
    public
    function viewAsHtmlInABwithDataMismatch($display_verbose)
    {
        $this->viewAsHtmlInABgivenRowList($this->inAandBnoDataMatch,
            "The following are in both " .
            $this->a->getCommonName() .
            " and " .
            $this->b->getCommonName() .
            " with data that does NOT match",
            true,
            false, $display_verbose);
    }

    /**
     * Get html view of matchups A<->B (common function)
     */
    public
    function viewAsHtmlInABgivenRowList($rowNumbersAB, $msg, $button_delete, $skip_display_a, $display_verbose)
    {
        echo " <caption><h3 > " . $msg . " </h3 ></caption > ";

        if (count($rowNumbersAB) == 0) {
            echo "<br > (none)<br ><br > ";
            return;
        }

        // do we want to dislpay all fields, or abbreviated
        if ($display_verbose) {
            $a_columns = $this->a->columnsAll();
            $b_columns = $this->b->columnsAll();
        } else {
            $a_columns = $this->a->modelGetColumnsToDisplay();
            $b_columns = $this->b->modelGetColumnsToDisplay();
        }


        ///////////////////////////////////////////
        // generate main table
        echo "\n <form method = post > ";

        //  echo "\n <table class=sortable > ";
        echo "\n <table> ";

        /////////////////
        // print header

        echo "\n <thead>";
        echo "\n <tr>";
        echo " <th>source </th > ";
        foreach ($b_columns as $colId) {
            echo "<th > $colId</th > ";
        }
        echo "<th ></th > ";
        if ($button_delete) {
            echo "<th > delete</th > ";
        }
        echo "\n </tr > ";
        echo "\n </thead > ";


        //////////////////////
        // print data rows

        echo "\n <tbody>";

        foreach ($rowNumbersAB as $rowNumberA => $rowNumberB) {
            if (!$skip_display_a) {
                echo "\n <tr>";
                echo " <th>" . $this->a->getCommonName() . " </th > ";
                foreach ($a_columns as $colId) {
                    echo "<td > " . $this->a->getDataElement($rowNumberA, $colId) . "</td > ";
                }
                echo "<th ></th > ";

                if ($button_delete) {
                    echo "<th > -</th > ";
                }
                echo "\n </tr > ";
            }
            echo "\n <tr>";
            echo " <th>" . $this->b->getCommonName() . " </th > ";
            foreach ($b_columns as $colId) {
                echo "<td > " . $this->b->getDataElement($rowNumberB, $colId) . "</td > ";
            }
            echo "<th ></th > ";

            if ($button_delete) {
                echo '<th>';
                echo '<input type=submit name=delete_row value=' . $rowNumberB . '>';
                echo '</th>';
            }


            echo "\n </tr > ";
        }
        echo "\n </tbody > ";
        echo "\n </table > ";
        echo "\n </form > ";
        echo "\n <br>";
        echo "\n <br>";
    }

    /**
     * Get html view of the matchups A<->B where data DOES match
     */
    public
    function viewAsHtmlInABwithDataMatch($display_verbose)
    {
        $this->viewAsHtmlInABgivenRowList($this->inAandBwithDataMatch,
            "The following are in both " .
            $this->a->getCommonName() .
            " and " .
            $this->b->getCommonName() .
            " with matching data",
            true,
            true, $display_verbose);
    }


}