<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

/**
 * Class ControllerRowRaker
 */
class ControllerRowVolunteerSpotRaker extends ControllerRow
{

    /////////////////////////////////////////////////
    // Methods required by the base class

    public function modelGetColumnsAll()
    {
        return array(
            'id',
            'date',
            'task',
            'start_time',
            'end_time',
            'firstname',
            'lastname',
            'email',
            'phone');
    }

    public function modelGetIdFieldName()
    {
        return 'id';
    }

    //////////////////////////////////////////////////
    // Methods required by the CSV interface
    public function populateFromAssociativeArrayCsvFile($rowAssociativeArray)
    {
        // map local fields from csv file
        $this->fields = array();

        $this->fields['id'] = -1;
        $this->fields['date'] = $rowAssociativeArray[0];
        $this->fields['task'] = $rowAssociativeArray[1];
        $this->fields['start_time'] = $rowAssociativeArray[4];
        $this->fields['end_time'] = $rowAssociativeArray[5];
        $this->fields['firstname'] = $rowAssociativeArray[7];
        $this->fields['lastname'] = $rowAssociativeArray[8];
        $this->fields['email'] = $rowAssociativeArray[12];
        $this->fields['phone'] = $rowAssociativeArray[13];
    }


    /////////////////////////////////////////////////
    // Methods required by the database interface

    /**
     * @param $rowAssociativeArray
     */
    public function populateFromDatabaseTableAssociativeArray($rowAssociativeArray)
    {
        // map local fields from database fields
        // local field [name] <= database field [name]
        $this->fields = array();

        $this->fields['id'] = $rowAssociativeArray['id'];
        $this->fields['date'] = $rowAssociativeArray['date'];
        $this->fields['task'] = $rowAssociativeArray['task'];
        $this->fields['start_time'] = $rowAssociativeArray['start_time'];
        $this->fields['end_time'] = $rowAssociativeArray['end_time'];
        $this->fields['firstname'] = $rowAssociativeArray['firstname'];
        $this->fields['lastname'] = $rowAssociativeArray['lastname'];
        $this->fields['email'] = $rowAssociativeArray['email'];
        $this->fields['phone'] = $rowAssociativeArray['phone'];
    }


    /**
     *
     */
    public function getAsAssociativeArrayForDatabaseTable()
    {
        $array = [];
        $array['date'] = $this->fields['date'];
        $array['task'] = $this->fields['task'];
        $array['start_time'] = $this->fields['start_time'];
        $array['end_time'] = $this->fields['end_time'];
        $array['firstname'] = $this->fields['firstname'];
        $array['lastname'] = $this->fields['lastname'];
        $array['email'] = $this->fields['email'];
        $array['phone'] = $this->fields['phone'];
        return $array;
    }




}
    
   