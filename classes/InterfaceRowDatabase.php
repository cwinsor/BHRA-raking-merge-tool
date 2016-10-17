<?php

interface InterfaceRowDatabase
{
    /**
     * Map local fields from database fields
     * Local field [name] <= database field [name]
     * @param $rowAssociativeArray
     * @return mixed
     */
    public function populateFromDatabaseTableAssociativeArray($rowAssociativeArray);

    /**
     * Return an array such suitable for writing directly to database table.
     * The requirement here is array key is the database table header.
     * ID is not included because this is automatically assigned by the database at insertion.
     * @return mixed
     */
    public function getAsAssociativeArrayForDatabaseTable();

}
