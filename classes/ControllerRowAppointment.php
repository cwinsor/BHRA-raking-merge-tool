<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

/**
 * Class ControllerRowRaker
 */
class ControllerRowAppointment extends ControllerRow
{

    //////////////////////////////////////////////////
    // Methods required by the CSV interface
    public function populateFromAssociativeArrayCsvFile($rowAssociativeArray)
    {
        // map local fields from csv file
        $this->fields = array();

        $this->fields['id_appt'] = -1;

        $this->fields['ApptStart'] = $this->volunteerSiteProprietaryDateTimeToStandard($rowAssociativeArray[0]);
        $this->fields['ApptEnd'] = $this->volunteerSiteProprietaryDateTimeToStandard($rowAssociativeArray[1]);
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
        $this->fields['DTme1'] = $this->volunteerSiteProprietaryDateTimeToStandard($rowAssociativeArray[13]);
        $this->fields['DTme2'] = $this->volunteerSiteProprietaryDateTimeToStandard($rowAssociativeArray[14]);


    }

    /////////////////////////////////////////////////
    // Methods required by the database interface

    /**
     * @param $rowAssociativeArray
     */
    public function populateFromDatabaseTableAssociativeArray($rowAssociativeArray)
    {
        $this->fields['id_appt'] = $rowAssociativeArray['id_appt'];

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
    }

    /**
     * Take in SuperSAAS format date/time
     * 11/9/2014  4:00:00 PM
     * and return standard format
     * 1000-01-01 00:00:00
     * @param $data
     */
    private function volunteerSiteProprietaryDateTimeToStandard($data)
    {
        list($date, $time) = explode(" ", $data);
        list($hour, $minute) = explode(":", $time);
        list($year, $month, $day) = explode("/", $date);

        // make "15" into "2015"
        $year = '20' . $year;

        return $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $minute . ':' . '00';
    }

    /**
     *
     */
    public function getAsAssociativeArrayForDatabaseTable()
    {
        $array = [];
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
        return $array;
    }

    /////////////////////////////////////////////////
    // Methods required by the base class

    public function modelGetColumnsAll()
    {
        return array(
            'id_appt',
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
            'DTme2');
    }

    public function modelGetColumnsNameslug()
    {
        return array(
            'CustName',
            'ApptStart');
    }

    public function modelGetColumnsDataslug()
    {
        return array_merge(
            $this->modelGetColumnsNameslug(),
            array(
//            'ApptStart',
                'ApptEnd',
                'ApptDescription',
//            'CustName',
                'CustPhone',
                'CustStreet',
                'CustDescription',
                'CustNotes',
                'CustEmail',
                'ReservedBy'));
    }

    public function modelGetIdFieldName()
    {
        return 'id_appt';
    }
}
    
   