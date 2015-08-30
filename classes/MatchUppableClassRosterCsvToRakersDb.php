<?php

/*
 * map rowers from the roster csv file to rakers in the rakers table
 */

class MatchUppableClassRosterCsvToRakersDb extends MatchUppableClass
{

    public function getNameslugMapAB()
    {
        return array(
            'firstname' => 'firstname',
            'lastname' => 'lastname');
    }

    public function getDataslugMapAB()
    {
        return array_merge(
            $this->getNameslugMapAB(),
            array(
                'cellphone' => 'cellphone',
                'gender' => 'gender'));
    }

}