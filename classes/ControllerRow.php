<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

abstract class ControllerRow implements InterfaceRowCsv, InterfaceRowDatabase
{

    protected $fields;

    abstract public function modelGetColumnsAll();

    abstract public function modelGetIdFieldName();


    public function modelGetField($key)
    {
        return $this->fields[$key];
    }

    public function asArray()
    {
        return $this->fields;
    }

    public function modelSetField($key, $value)
    {
        $this->fields[$key] = $value;
    }
}