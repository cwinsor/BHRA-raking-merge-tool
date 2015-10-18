<?php

abstract class ControllerRow implements InterfaceRowCsv, InterfaceRowDatabase, InterfaceRowSchedulable
{

    protected $fields;

    abstract public function modelGetColumnsAll();

    abstract public function modelGetColumnsToDisplay();

    public function modelGetIdFieldValue()
    {
        return $this->modelGetField($this->modelGetIdFieldName());
    }

    public function modelGetField($key)
    {
        return $this->fields[$key];
    }

    abstract public function modelGetIdFieldName();

    public function asArray()
    {
        return $this->fields;
    }

    public function getFromArrayOrReturnX($rowAssociativeArray, $index)
    {
        if (array_key_exists($index, $rowAssociativeArray)) {
            if ($rowAssociativeArray[$index] == "") {
                return "X";
            }
            return $rowAssociativeArray[$index];
        }
        return "X";
    }

    public function isAssigned($day, $startTime)
    {
        if (
            (array_key_exists("assigned_day", $this->fields) == false) ||
            (array_key_exists("assigned_start_time", $this->fields) == false)
        ) {
            return false;
        }
        return (
            ($this->modelGetField("assigned_day") == $day) &&
            ($this->modelGetField("assigned_start_time") == $startTime));
    }

    //////////////////////////////
    // methods required by the schedulable interface

    public function isAssignedTeam($day, $startTime, $teamNumber)
    {
        if (
            (array_key_exists("assigned_day", $this->fields) == false) ||
            (array_key_exists("assigned_start_time", $this->fields) == false) ||
            (array_key_exists("assigned_team_number", $this->fields) == false)
        ) {
            return false;
        }
        return (
            ($this->modelGetField("assigned_day") == $day) &&
            ($this->modelGetField("assigned_start_time") == $startTime) &&
            ($this->modelGetfield("assigned_team_number") == $teamNumber));
    }

    public function assign($day, $startTime, $teamNumber)
    {
        $this->modelSetField("assigned_day", $day);
        $this->modelSetField("assigned_start_time", $startTime);
        $this->modelSetField("assigned_team_number", $teamNumber);
    }

    public function modelSetField($key, $value)
    {
        $this->fields[$key] = $value;
    }

    public function unAssign()
    {
        $this->modelSetField("assigned_day", "");
        $this->modelSetField("assigned_start_time", "");
        $this->modelSetField("assigned_team_number", "");
    }


}