<?php

interface InterfaceToDatabaseRow
{
    
    public function databasePopulateFromAssociativeArray($rowAssociativeArray);
    
    public function databaseNewRow($tablename);
    public function databaseUpdateRowSelectedFields($tablename, $fieldlist);
    public function databaseUpdateRowAllfields($tablename);

}
