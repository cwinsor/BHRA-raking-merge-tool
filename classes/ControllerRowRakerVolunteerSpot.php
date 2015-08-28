<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

/**
 * Class ControllerRowRaker
 */
class ControllerRowRakerVolunteerSpot extends ControllerRowRaker
{

    //////////////////////////////////////////////////
    // Methods required by the CSV interface
    public function populateFromAssociativeArrayCsvFile($rowAssociativeArray)
    {
        // map local fields from csv file
        $this->fields = array();

        $this->fields['id'] = -1;

        $this->fields['volunteerSpotFirstname'] = $rowAssociativeArray[2];
        $this->fields['volunteerSpotLastname'] = $rowAssociativeArray[2];
        $this->fields['volunteerSlots'] = $rowAssociativeArray[2];

        $this->fields['rosterFirstname'] = -1;
        $this->fields['rosterLastname'] = -1;
        $this->fields['cellphone'] = -1;
        $this->fields['gender'] = -1;
    }

    /////////////////////////////////////////////////
    // Methods required by the base class

    public function modelGetColumnsNameslug()
    {
        return array(
            'volunteerSpotFirstname',
            'volunteerSpotLastname');
    }

    public function modelGetColumnsDataslug()
    {
        return array_merge(
            $this->modelGetColumnsNameslug(),
            array(
                'volunteerSlots'));
    }


}
    
   