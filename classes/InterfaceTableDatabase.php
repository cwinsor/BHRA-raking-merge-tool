<?php

interface InterfaceTableDatabase
{


    /**
     * Populate from database
     * @param $itemToClone - when populating the table, entities of this class are used (copy)
     * @return mixed
     */
    public function databaseRead($itemToClone);

    /**
     * Add to database
     * @param $row
     * @return mixed
     */
    public function databaseAdd($row);

    /**
     * Delete from database
     * @param $id
     * @return mixed
     */
    public function databaseDeleteById($idHdr, $idVal);

}
