<?php

/*
 * map rowers from the roster csv file to rakers in the rakers table
 */

class MatchUppableClassVolunteerspotRakersCsvToVolunteerspotRakersDb extends MatchUppableClass
{
    public function getDataslugMapAB()
    {
        return array_merge(
            $this->getNameslugMapAB(),
            array(
                'task' => 'task',
                'end_time' => 'end_time',
                'email' => 'email',
                'comments' => 'comments',
                'phone' => 'phone'));
    }

    public function getNameslugMapAB()
    {
        return array(
            'date' => 'date',
            'start_time' => 'start_time',
            'firstname' => 'firstname',
            'lastname' => 'lastname');
    }
}