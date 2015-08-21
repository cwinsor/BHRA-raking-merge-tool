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
     * Write to database
     * @param $id
     * @return mixed
     */
    public function databaseUpdateById($id);

}
