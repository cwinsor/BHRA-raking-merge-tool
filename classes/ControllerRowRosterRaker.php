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
            'email',
            'cellphone',
            'gender');
    }

    public function modelGetColumnsToDisplay()
    {
        return array(
            'firstname',
            'lastname');
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
        $this->fields['firstname'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 1);
        $this->fields['lastname'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 2);
        $this->fields['email'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 3);
        $this->fields['cellphone'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 6);
        $this->fields['gender'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 4);
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
        $this->fields['email'] = $rowAssociativeArray['email'];
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
        $array['email'] = $this->fields['email'];
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
    
   