<?php

/**
 * Class ControllerRowRaker
 */
class ControllerRowAppointment extends ControllerRow
{

    /////////////////////////////////////////////////
    // Methods required by the base class

    public function modelGetColumnsAll()
    {
        return array(
            'id',
            'ApptDate',
            'ApptStart',
            'ApptEnd',
            'ApptDescription',
            'Foo',
            'ANumber',
            'BNumber',
            'CustName',
            'CustPhone',
            'CustStreet',
            'CustDescription',
            'CustNotes',
            'CustEmail',

            'assigned_day',
            'assigned_start_time',
            'assigned_team_number');
    }

    public function modelGetColumnsToDisplay()
    {
        return array(
            'ApptDate',
            'ApptStart',
            'ApptEnd',
            'CustName',
            'assigned_team_number');
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

        if ($GLOBALS['debug']) {
            echo "<br>input associative array is:<br>";
            var_dump($rowAssociativeArray);
            echo "<br>";
        }

        $this->fields['id'] = -1;
        $this->fields['ApptDate'] = ClassDateTime::dateFromSupersaasFormat($this->getFromArrayOrReturnX($rowAssociativeArray, 0));
        $this->fields['ApptStart'] = ClassDateTime::timeFromSupersaasFormat($this->getFromArrayOrReturnX($rowAssociativeArray, 0));
        $this->fields['ApptEnd'] = ClassDateTime::timeFromSupersaasFormat($this->getFromArrayOrReturnX($rowAssociativeArray, 1));
        $this->fields['ApptDescription'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 2);
        $this->fields['Foo'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 3);
        $this->fields['ANumber'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 4);
        $this->fields['BNumber'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 5);
        $this->fields['CustName'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 6);
        $this->fields['CustPhone'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 7);
        $this->fields['CustStreet'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 8);
        $this->fields['CustDescription'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 9);
        $this->fields['CustNotes'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 10);
        $this->fields['CustEmail'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 11);

        $this->fields['assigned_day'] = "";
        $this->fields['assigned_start_time'] = "";
        $this->fields['assigned_team_number'] = "";
    }

    /////////////////////////////////////////////////
    // Methods required by the database interface

    /**
     * @param $rowAssociativeArray
     */
    public
    function populateFromDatabaseTableAssociativeArray($rowAssociativeArray)
    {
        $this->fields['id'] = $rowAssociativeArray['id'];
        $this->fields['ApptDate'] = $rowAssociativeArray['ApptDate'];
        $this->fields['ApptStart'] = $rowAssociativeArray['ApptStart'];
        $this->fields['ApptEnd'] = $rowAssociativeArray['ApptEnd'];
        $this->fields['ApptDescription'] = $rowAssociativeArray['ApptDescription'];
        $this->fields['Foo'] = $rowAssociativeArray['Foo'];
        $this->fields['ANumber'] = $rowAssociativeArray['ANumber'];
        $this->fields['BNumber'] = $rowAssociativeArray['BNumber'];
        $this->fields['CustName'] = $rowAssociativeArray['CustName'];
        $this->fields['CustPhone'] = $rowAssociativeArray['CustPhone'];
        $this->fields['CustStreet'] = $rowAssociativeArray['CustStreet'];
        $this->fields['CustDescription'] = $rowAssociativeArray['CustDescription'];
        $this->fields['CustNotes'] = $rowAssociativeArray['CustNotes'];
        $this->fields['CustEmail'] = $rowAssociativeArray['CustEmail'];

        $this->fields['assigned_day'] = $rowAssociativeArray['assigned_day'];
        $this->fields['assigned_start_time'] = $rowAssociativeArray['assigned_start_time'];
        $this->fields['assigned_team_number'] = $rowAssociativeArray['assigned_team_number'];
    }

    /**
     *
     */
    public
    function getAsAssociativeArrayForDatabaseTable()
    {
        $array = [];
        $array['ApptDate'] = $this->fields['ApptDate'];
        $array['ApptStart'] = $this->fields['ApptStart'];
        $array['ApptEnd'] = $this->fields['ApptEnd'];
        $array['ApptDescription'] = $this->fields['ApptDescription'];
        $array['Foo'] = $this->fields['Foo'];
        $array['ANumber'] = $this->fields['ANumber'];
        $array['BNumber'] = $this->fields['BNumber'];
        $array['CustName'] = $this->fields['CustName'];
        $array['CustPhone'] = $this->fields['CustPhone'];
        $array['CustStreet'] = $this->fields['CustStreet'];
        $array['CustDescription'] = $this->fields['CustDescription'];
        $array['CustNotes'] = $this->fields['CustNotes'];
        $array['CustEmail'] = $this->fields['CustEmail'];

        $array['assigned_day'] = $this->fields['assigned_day'];
        $array['assigned_start_time'] = $this->fields['assigned_start_time'];
        $array['assigned_team_number'] = $this->fields['assigned_team_number'];
        return $array;
    }


    //////////////////////////////
    // methods required by the schedulable interface

    public
    function isAvailable($day, $startTime)
    {
        return (
            ($this->modelGetField('ApptDate') == $day) &&
            ($this->modelGetField('ApptStart') == $startTime));
    }


}
    
   