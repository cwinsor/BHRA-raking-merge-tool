<?php

///////////////////////
//
// MatchUppableInterface
//
// MatchUppable allows comparing two tables.  A row-by-row compare is done
// based on slug and data, with the result being four categories:
//   exact matches - rows in A which match exactly rows in B on both slug and data
//   inexact matches - rows in A which match row in B on slug, but data does not match
//   rows in A not in B, based on slug
//   rows in B not in A, based on slug
//
// There are two pieces of infrastructure (interface and compare tool).
// This file defines the interface.
//
// The interface establishes methods required of a class to claim itself MatchUppable.
//

interface MatchUppableInterface
{

    // give me an array of row numbers in the table
    public function rowNumbers();

    // give me a means to get a row using row number and column identifier
    public function getDataElement($rowId,$colId);
}
