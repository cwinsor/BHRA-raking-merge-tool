<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

abstract class ControllerRow implements InterfaceRowCsv, InterfaceRowDatabase, InterfaceRowSchedulable
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



    //////////////////////////////
    // methods required by the schedulable interface

    public function isAssigned($day, $startTime)
    {
   return (($this->modelGetField("assigned_day") == $day) &&
       ($this->modelGetField("assigned_start_time") == $startTime));
    }

    public function isAssignedTeam($day, $startTime, $teamNumber)
    {
        return $this->isAssigned($day,$startTime) &&
        ($this->modelGetfield("assigned_team_number" == $teamNumber));
    }

    public function assign($day, $startTime, $teamNumber)
    {
        $this->modelSetField("assigned_day", $day);
        $this->modelSetField("assigned_start_time", $startTime);
        $this->modelSetField("assigned_team_number", $teamNumber);
    }

    public function unAssign()
    {
        $this->modelSetField("assigned_day", "");
        $this->modelSetField("assigned_start_time", "");
        $this->modelSetField("assigned_team_number", "");
    }



}