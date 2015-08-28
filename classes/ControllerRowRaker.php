<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

/**
 * Class ControllerRowRaker
 */
class ControllerRowRaker extends ControllerRow
{

    //////////////////////////////////////////////////
    // Methods required by the CSV interface
    public function populateFromAssociativeArrayCsvFile($rowAssociativeArray)
    {
        // map local fields from csv file
        $this->fields = array();

        $this->fields['id'] = -1;
        $this->fields['volunteerSiteFirstname'] = -1;
        $this->fields['volunteerSiteLastname'] = -1;
        $this->fields['volunteerSlots'] = -1;

        $this->fields['rosterFirstname'] = $rowAssociativeArray[2];
        $this->fields['rosterLastname'] = $rowAssociativeArray[3];
        $this->fields['cellphone'] = $rowAssociativeArray[8];
        $this->fields['gender'] = $rowAssociativeArray[4];
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
        $this->fields['rosterFirstname'] = $rowAssociativeArray['rosterFirstname'];
        $this->fields['rosterLastname'] = $rowAssociativeArray['rosterLastname'];
        $this->fields['volunteerSiteFirstname'] = $rowAssociativeArray['volunteerSiteFirstname'];
        $this->fields['volunteerSiteLastname'] = $rowAssociativeArray['volunteerSiteLastname'];
        $this->fields['cellphone'] = $rowAssociativeArray['cellphone'];
        $this->fields['gender'] = $rowAssociativeArray['gender'];
        $this->fields['volunteerSlots'] = $rowAssociativeArray['volunteerSlots'];
    }

    /**
     *
     */
    public function getAsAssociativeArrayForDatabaseTable()
    {
        $array = [];
        $array['rosterFirstname'] = $this->fields['rosterFirstname'];
        $array['rosterLastname'] = $this->fields['rosterLastname'];
        $array['volunteerSiteFirstname'] = $this->fields['volunteerSiteFirstname'];
        $array['volunteerSiteLastname'] = $this->fields['volunteerSiteLastname'];
        $array['cellphone'] = $this->fields['cellphone'];
        $array['gender'] = $this->fields['gender'];
        $array['volunteerSlots'] = $this->fields['volunteerSlots'];
        return $array;
    }


    /////////////////////////////////////////////////
    // Methods required by the base class

    public function modelGetColumnsAll()
    {
        return array(
            'id',
            'rosterFirstname',
            'rosterLastname',
            'volunteerSiteFirstname',
            'volunteerSiteLastname',
            'cellphone',
            'gender',
            'volunteerSlots');
    }

    public function modelGetColumnsNameslug()
    {
        return array(
            'rosterFirstname',
            'rosterLastname');
    }

    public function modelGetColumnsDataslug()
    {
        return array_merge(
            $this->modelGetColumnsNameslug(),
            array('cellphone', 'gender'));
    }

    public function modelGetIdFieldName()
    {
        return 'id';
    }


}
    
   