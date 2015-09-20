
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
            'id_appt',
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
            'ReservedBy',
            'DTme1',
            'DTme2',

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
        return 'id_appt';
    }

    //////////////////////////////////////////////////
    // Methods required by the CSV interface
    public function populateFromAssociativeArrayCsvFile($rowAssociativeArray)
    {
        // map local fields from csv file
        $this->fields = array();

        $this->fields['id_appt'] = -1;
        $this->fields['ApptDate'] = ClassDateTime::dateFromSupersaasFormat($rowAssociativeArray[0]);
        $this->fields['ApptStart'] = ClassDateTime::timeFromSupersaasFormat($rowAssociativeArray[0]);
        $this->fields['ApptEnd'] = ClassDateTime::timeFromSupersaasFormat($rowAssociativeArray[1]);
        $this->fields['ApptDescription'] = $rowAssociativeArray[2];
        $this->fields['Foo'] = $rowAssociativeArray[3];
        $this->fields['ANumber'] = $rowAssociativeArray[4];
        $this->fields['BNumber'] = $rowAssociativeArray[5];
        $this->fields['CustName'] = $rowAssociativeArray[6];
        $this->fields['CustPhone'] = $rowAssociativeArray[7];
        $this->fields['CustStreet'] = $rowAssociativeArray[8];
        $this->fields['CustDescription'] = $rowAssociativeArray[9];
        $this->fields['CustNotes'] = $rowAssociativeArray[10];
        $this->fields['CustEmail'] = $rowAssociativeArray[11];
        $this->fields['ReservedBy'] = $rowAssociativeArray[12];
        $this->fields['DTme1'] = $rowAssociativeArray[13];
        $this->fields['DTme2'] = $rowAssociativeArray[14];

        $this->fields['assigned_day'] = "";
        $this->fields['assigned_start_time'] = "";
        $this->fields['assigned_team_number'] = "";
    }

    /////////////////////////////////////////////////
    // Methods required by the database interface

    /**
     * @param $rowAssociativeArray
     */
    public function populateFromDatabaseTableAssociativeArray($rowAssociativeArray)
    {
        $this->fields['id_appt'] = $rowAssociativeArray['id_appt'];
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
        $this->fields['ReservedBy'] = $rowAssociativeArray['ReservedBy'];
        $this->fields['DTme1'] = $rowAssociativeArray['DTme1'];
        $this->fields['DTme2'] = $rowAssociativeArray['DTme2'];

        $this->fields['assigned_day'] = $rowAssociativeArray['assigned_day'];
        $this->fields['assigned_start_time'] = $rowAssociativeArray['assigned_start_time'];
        $this->fields['assigned_team_number'] = $rowAssociativeArray['assigned_team_number'];
    }

    /**
     *
     */
    public function getAsAssociativeArrayForDatabaseTable()
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
        $array['ReservedBy'] = $this->fields['ReservedBy'];
        $array['DTme1'] = $this->fields['DTme1'];
        $array['DTme2'] = $this->fields['DTme2'];

        $array['assigned_day'] = $this->fields['assigned_day'];
        $array['assigned_start_time'] = $this->fields['assigned_start_time'];
        $array['assigned_team_number'] = $this->fields['assigned_team_number'];
        return $array;
    }


    //////////////////////////////
    // methods required by the schedulable interface

    public function isAvailable($day, $startTime)
    {
        return (
            ($this->modelGetField('ApptDate') == $day) &&
            ($this->modelGetField('ApptStart') == $startTime));
    }


}
    
   