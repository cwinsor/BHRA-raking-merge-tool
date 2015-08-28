<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

abstract class ControllerRow implements InterfaceRowDatabase, InterfaceRowCsv
{

    protected $fields;


    public function modelGetField($key)
    {
        return $this->fields[$key];
    }

    abstract public function modelGetIdFieldName();

    public function asArray()
    {
        return $this->fields;
    }

    public function modelSetField($key, $value)
    {
        $this->fields[$key] = $value;
    }
}