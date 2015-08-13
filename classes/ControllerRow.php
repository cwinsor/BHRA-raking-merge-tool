<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

abstract class ControllerRow implements InterfaceRowDatabase
{

    protected $fields;


    public function modelGetField($key)
    {
        if (!$this->fields[$key]) {
            echo '<br>about to error with fields of: <br>';
            var_dump($this->fields);
            echo '<br>';
            trigger_error("unable to retrieve based on key $key", E_USER_ERROR);
        }
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