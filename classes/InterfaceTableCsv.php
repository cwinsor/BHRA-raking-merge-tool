<?php

interface InterfaceTableCsv
{

    /**
     * Populate from csv file
     * @param $itemToClone - when populating the table, entities of this class are used (copy)
     * @param $filename
     * @return mixed
     */
    public function csvRead();

}
