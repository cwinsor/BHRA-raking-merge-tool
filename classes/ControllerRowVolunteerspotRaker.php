
<?php

/**
 * Class ControllerRowRaker
 */
class ControllerRowVolunteerSpotRaker extends ControllerRow
{

    /////////////////////////////////////////////////
    // Methods required by the base class

    public function modelGetColumnsAll()
    {
        return array(
            'id',
            'date',
            'task',
            'start_time',
            'end_time',
            'firstname',
            'lastname',
            'email',
            'phone',

            'assigned_day',
            'assigned_start_time',
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
        try {
            // map local fields from csv file
            $this->fields = array();

            $this->fields['id'] = -1;
            $this->fields['task'] = $rowAssociativeArray[1];
            $this->fields['date'] = ClassDateTime::dateFromVolunteerspotFormat($rowAssociativeArray[0]);
            $this->fields['start_time'] = ClassDateTime::timeFromVolunteerspotFormat($rowAssociativeArray[4]);
            $this->fields['end_time'] = ClassDateTime::timeFromVolunteerspotFormat($rowAssociativeArray[5]);
            $this->fields['firstname'] = $rowAssociativeArray[7];
            $this->fields['lastname'] = $rowAssociativeArray[8];
            $this->fields['email'] = $rowAssociativeArray[12];
            $this->fields['phone'] = $rowAssociativeArray[13];

            $this->fields['assigned_day'] = "";
            $this->fields['assigned_start_time'] = "";
            $this->fields['assigned_team_number'] = "";

        } catch (Exception $e) {
            echo '<br>---ERROR READING LINE WITH THE FOLLOWING DATA---<br>';
            var_dump($rowAssociativeArray);
            echo '<br>';
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
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
        $this->fields['date'] = $rowAssociativeArray['date'];
        $this->fields['task'] = $rowAssociativeArray['task'];
        $this->fields['start_time'] = $rowAssociativeArray['start_time'];
        $this->fields['end_time'] = $rowAssociativeArray['end_time'];
        $this->fields['firstname'] = $rowAssociativeArray['firstname'];
        $this->fields['lastname'] = $rowAssociativeArray['lastname'];
        $this->fields['email'] = $rowAssociativeArray['email'];
        $this->fields['phone'] = $rowAssociativeArray['phone'];

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
        $array['date'] = $this->fields['date'];
        $array['task'] = $this->fields['task'];
        $array['start_time'] = $this->fields['start_time'];
        $array['end_time'] = $this->fields['end_time'];
        $array['firstname'] = $this->fields['firstname'];
        $array['lastname'] = $this->fields['lastname'];
        $array['email'] = $this->fields['email'];
        $array['phone'] = $this->fields['phone'];

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
            ($this->fields['date'] == $day) &&
            ($this->fields['start_time'] == $startTime));
    }


}
    
   