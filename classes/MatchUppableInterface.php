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
// The interface requires a MatchUppable class to be able to
//
// rowIdList()
//return a list of rowIds which constitute the list
//
// colIdListSlug()
// return the list of column IDs that constitute the (to-be-compared) slug
//
// colIdListData()
// return the list of column IDs that constitute the (to-be-compared) data elements
//
// getDataElement(rowId,colId)
// return a single data element based on row, column
//

interface MatchUppableInterface
{

    public function rowNumbers();

//    public function columnsNameslug();
//    public function columnsDataslug();

    public function columnsNameslug();

    public function columnsDataslug();

    public function getDataElement($rowId,$colId);
}
