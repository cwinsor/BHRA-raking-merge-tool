<?php

/**
 * Class ControllerRowParent
 */
class ControllerRowRosterParent extends ControllerRow
{

    /////////////////////////////////////////////////
    // Methods required by the base class

    public function modelGetColumnsAll()
    {
        return array(
            'id',
            'address',
            'city',
            'p1_firstname',
            'p1_lastname',
            'p1_email',
            'p1_phone',
            'p2_firstname',
            'p2_lastname',
            'p2_email',
            'p2_phone',
            'rower_firstname');
    }

    public function modelGetColumnsToDisplay()
    {
        return array(
            'p1_firstname',
            'p1_lastname',
            'p2_firstname',
            'p2_lastname',
            'rower_firstname');
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
        $this->fields['address'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 7);
        $this->fields['city'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 8);
        $this->fields['p1_firstname'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 9);
        $this->fields['p1_lastname'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 10);
        $this->fields['p1_email'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 11);
        $this->fields['p1_phone'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 12);
        $this->fields['p2_firstname'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 13);
        $this->fields['p2_lastname'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 14);
        $this->fields['p2_email'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 15);
        $this->fields['p2_phone'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 16);
        $this->fields['rower_firstname'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 1);
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
        $this->fields['address'] = $rowAssociativeArray['address'];
        $this->fields['city'] = $rowAssociativeArray['city'];
        $this->fields['p1_firstname'] = $rowAssociativeArray['p1_firstname'];
        $this->fields['p1_lastname'] = $rowAssociativeArray['p1_lastname'];
        $this->fields['p1_email'] = $rowAssociativeArray['p1_email'];
        $this->fields['p1_phone'] = $rowAssociativeArray['p1_phone'];
        $this->fields['p2_firstname'] = $rowAssociativeArray['p2_firstname'];
        $this->fields['p2_lastname'] = $rowAssociativeArray['p2_lastname'];
        $this->fields['p2_email'] = $rowAssociativeArray['p2_email'];
        $this->fields['p2_phone'] = $rowAssociativeArray['p2_phone'];
        $this->fields['rower_firstname'] = $rowAssociativeArray['rower_firstname'];
    }


    /**
     *
     */
    public function getAsAssociativeArrayForDatabaseTable()
    {
        $array = [];
        $array['address'] = $this->fields['address'];
        $array['city'] = $this->fields['city'];
        $array['p1_firstname'] = $this->fields['p1_firstname'];
        $array['p1_lastname'] = $this->fields['p1_lastname'];
        $array['p1_email'] = $this->fields['p1_email'];
        $array['p1_phone'] = $this->fields['p1_phone'];
        $array['p2_firstname'] = $this->fields['p2_firstname'];
        $array['p2_lastname'] = $this->fields['p2_lastname'];
        $array['p2_email'] = $this->fields['p2_email'];
        $array['p2_phone'] = $this->fields['p2_phone'];
        $array['rower_firstname'] = $this->fields['rower_firstname'];
        return $array;
    }



    //////////////////////////////
    // methods required by the schedulable interface

    public function isAvailable($day, $startTime)
    {
        echo "<br> RowRosterParent is not schedulable 440655 <br>";
        exit;
    }


}
    
   