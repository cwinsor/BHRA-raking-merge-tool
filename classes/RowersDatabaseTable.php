<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

class RowersDatabaseTable implements InterfaceMappableFromCsv, InterfaceToDatabaseTable
{

    public $arrayOfRowers;
    
}
