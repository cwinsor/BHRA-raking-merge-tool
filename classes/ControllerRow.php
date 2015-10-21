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

    /**
     * this function will sanitize user input (say from a .csv file)
     * it handles cases where the array element doesn't exist, or exists and is null
     * it also check for and removes new lines \n \r
     */
    public function getFromArrayOrReturnX($rowAssociativeArray, $index)
    {
        // if there is an entry
        if (array_key_exists($index, $rowAssociativeArray)) {
            // remove newlines
     //       $rowAssociativeArray[$index] = str_replace(array("\r", "\n"), '', $rowAssociativeArray[$index]);
            // check for an entry that is nothing
            if ($rowAssociativeArray[$index] == "") {
                return "X";
            }
            // return the entry
            return $rowAssociativeArray[$index];
        }
        // there is no entry so return X
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