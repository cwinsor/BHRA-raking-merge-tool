<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

/**
 * Class ControllerRowRaker
 */
class ControllerRowRakerRoster extends ControllerRowRaker
{

    //////////////////////////////////////////////////
    // Methods required by the CSV interface
    public function populateFromAssociativeArrayCsvFile($rowAssociativeArray)
    {
        // map local fields from csv file
        $this->fields = array();

        $this->fields['id'] = -1;

        $this->fields['volunteerSpotFirstname'] = -1;
        $this->fields['volunteerSpotLastname'] = -1;
        $this->fields['volunteerSlots'] = -1;

        $this->fields['rosterFirstname'] = $rowAssociativeArray[2];
        $this->fields['rosterLastname'] = $rowAssociativeArray[3];
        $this->fields['cellphone'] = $rowAssociativeArray[8];
        $this->fields['gender'] = $rowAssociativeArray[4];
    }


    /////////////////////////////////////////////////
    // Methods required by the base class

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
            array(
                'cellphone',
                'gender'));
    }

}
    
   