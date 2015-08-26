<?php

interface InterfaceRowDatabase
{
    
    public function populateFromDatabaseTableAssociativeArray($rowAssociativeArray);
    
    public function databaseNewRow($tablename);
    public function databaseUpdateRowSelectedFields($tablename, $fieldlist);
    public function databaseUpdateRowAllfields($tablename);

}
