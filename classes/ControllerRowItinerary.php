<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

/**
 * Class ControllerRowItinerary
 */
class ControllerRowItinerary extends ControllerRow
{

    /////////////////////////////////////////////////
    // Methods required by the base class

    public function modelGetColumnsAll()
    {
        return array(
            'date',
            'am_pm',
            'team',
            'start_time',
            'type_of_item',
            'full_name'
        );
    }

    public function modelGetIdFieldName()
    {
        exit ("not implemented - 22065546");
    }

    //////////////////////////////////////////////////
    // Methods required by the CSV interface
    public function populateFromAssociativeArrayCsvFile($rowAssociativeArray)
    {
        exit ("not implemented - 22065547");
    }

    /////////////////////////////////////////////////
    // Methods required by the database interface

    /**
     * @param $rowAssociativeArray
     */
    public function populateFromDatabaseTableAssociativeArray($rowAssociativeArray)
    {
        $this->fields['id'] = $rowAssociativeArray['id'];

        $this->fields['date'] = $rowAssociativeArray['date'];
        $this->fields['am_pm'] = $rowAssociativeArray['am_pm'];
        $this->fields['team'] = $rowAssociativeArray['team'];
        $this->fields['start_time'] = $rowAssociativeArray['start_time'];
        $this->fields['type_of_item'] = $rowAssociativeArray['type_of_item'];
        $this->fields['full_name'] = $rowAssociativeArray['full_name'];
    }


    /**
     *
     */
    public function getAsAssociativeArrayForDatabaseTable()
    {
        $array = [];
        $array['date'] = $this->fields['date'];
        $array['am_pm'] = $this->fields['am_pm'];
        $array['team'] = $this->fields['team'];
        $array['start_time'] = $this->fields['start_time'];
        $array['type_of_item'] = $this->fields['type_of_item'];
        $array['full_name'] = $this->fields['full_name'];
        return $array;
    }

}
    
   