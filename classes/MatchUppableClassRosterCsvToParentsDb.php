<?php

/*
 * map parents from the roster csv file to parents in the parents table
 */

class MatchUppableClassRosterCsvToParentsDb extends MatchUppableClass
{

    public function getDataslugMapAB()
    {
        return array_merge(
            $this->getNameslugMapAB(),
            array(
                'address' => 'address',
                'city' => 'city',
                'p1_email' => 'p1_email',
                'p1_phone' => 'p1_phone',
                'p2_email' => 'p2_email',
                'p2_phone' => 'p2_phone'));
    }

    public function getNameslugMapAB()
    {
        return array(
            'p1_firstname' => 'p1_firstname',
            'p1_lastname' => 'p1_lastname',
            'p2_firstname' => 'p2_firstname',
            'p2_lastname' => 'p2_lastname',
            'rower_firstname' => 'rower_firstname');
    }

}