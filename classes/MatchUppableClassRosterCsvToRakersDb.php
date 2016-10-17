<?php

/*
 * map rowers from the roster csv file to rakers in the rakers table
 */

class MatchUppableClassRosterCsvToRakersDb extends MatchUppableClass
{

    public function getDataslugMapAB()
    {
        return array_merge(
            $this->getNameslugMapAB(),
            array(
                'cellphone' => 'cellphone',
                'email' => 'email',
                'gender' => 'gender'));
    }

    public function getNameslugMapAB()
    {
        return array(
            'firstname' => 'firstname',
            'lastname' => 'lastname');
    }

}