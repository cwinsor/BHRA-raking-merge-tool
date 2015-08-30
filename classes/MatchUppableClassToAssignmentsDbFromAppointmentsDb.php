<?php

/*
 * map rowers from the roster csv file to rakers in the rakers table
 */

class MatchUppableClassToAssignmentsDbFromAppointmentsDb extends MatchUppableClass
{


    public function getNameslugMapAB()
    {
        return array(
            'ApptStart' => 'start_time',
            'CustName' => 'full_name');
    }

    public function getDataslugMapAB()
    {
        return array_merge(
            $this->getNameslugMapAB(),
            array());
    }

}