<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

/**
 * Class ControllerRowRaker
 */
abstract class ControllerRowRaker extends ControllerRow
{


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
        $this->fields['volunteerSpotFirstname'] = $rowAssociativeArray['volunteerSpotFirstname'];
        $this->fields['volunteerSpotLastname'] = $rowAssociativeArray['volunteerSpotLastname'];
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
        $array['volunteerSpotFirstname'] = $this->fields['volunteerSpotFirstname'];
        $array['volunteerSpotLastname'] = $this->fields['volunteerSpotLastname'];
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
            'volunteerSpotFirstname',
            'volunteerSpotLastname',
            'cellphone',
            'gender',
            'volunteerSlots');
    }

    public function modelGetIdFieldName()
    {
        return 'id';
    }


}
    
   