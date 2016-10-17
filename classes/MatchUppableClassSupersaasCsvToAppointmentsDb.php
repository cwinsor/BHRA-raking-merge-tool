<?php

/*
 * map rowers from the roster csv file to rakers in the rakers table
 */

class MatchUppableClassSupersaasCsvToAppointmentsDb extends MatchUppableClass
{

    public function getNameslugMapAB()
    {
        return array(
            'CustName' => 'CustName',
            'ApptDate' => 'ApptDate',
            'ApptStart' => 'ApptStart',
            'ApptEnd' => 'ApptEnd');
    }

    public function getDataslugMapAB()
    {
        return array_merge(
            $this->getNameslugMapAB(),
            array(
                'ApptEnd' => 'ApptEnd',
                'ApptDescription' => 'ApptDescription',
                'CustPhone' => 'CustPhone',
                'CustStreet' => 'CustStreet',
                'CustDescription' => 'CustDescription',
                'CustNotes' => 'CustNotes',
                'CustEmail' => 'CustEmail'));
    }
}