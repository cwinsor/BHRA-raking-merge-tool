<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

/**
 * Class ControllerRowRaker
 */
class ControllerRowRosterRaker extends ControllerRow
{

    /////////////////////////////////////////////////
    // Methods required by the base class

    public function modelGetColumnsAll()
    {
        return array(
            'id',
            'firstname',
            'lastname',
            'cellphone',
            'gender');
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
        $this->fields['firstname'] = $rowAssociativeArray[2];
        $this->fields['lastname'] = $rowAssociativeArray[3];
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
        $this->fields['firstname'] = $rowAssociativeArray['firstname'];
        $this->fields['lastname'] = $rowAssociativeArray['lastname'];
        $this->fields['cellphone'] = $rowAssociativeArray['cellphone'];
        $this->fields['gender'] = $rowAssociativeArray['gender'];
    }


    /**
     *
     */
    public function getAsAssociativeArrayForDatabaseTable()
    {
        $array = [];
        $array['firstname'] = $this->fields['firstname'];
        $array['lastname'] = $this->fields['lastname'];
        $array['cellphone'] = $this->fields['cellphone'];
        $array['gender'] = $this->fields['gender'];
        return $array;
    }



    //////////////////////////////
    // methods required by the schedulable interface

    public function isAvailable($day, $startTime)
    {
        echo "<br> RowRosterRaker is not schedulable 440655 <br>";
        exit;
    }


}
    
   