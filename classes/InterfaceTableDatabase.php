<?php

interface InterfaceTableDatabase
{
    
    // populate from database
    public function databaseRead($itemToClone);
   
    // populate from database
    public function databaseUpdateById($id);
     
}
