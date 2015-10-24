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
            'comments',
            'size',

            'assigned_day',
            'assigned_start_time',
            'assigned_team_number');
    }

    public function modelGetColumnsToDisplay()
    {
        return array(
            'firstname',
            'lastname',
            'date',
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
            $this->fields['task'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 1);
            $this->fields['date'] = ClassDateTime::dateFromVolunteerspotFormat($this->getFromArrayOrReturnX($rowAssociativeArray, 0));
            $this->fields['start_time'] = ClassDateTime::timeFromVolunteerspotFormat($this->getFromArrayOrReturnX($rowAssociativeArray, 4));
            $this->fields['end_time'] = ClassDateTime::timeFromVolunteerspotFormat($this->getFromArrayOrReturnX($rowAssociativeArray, 5));
            // volunteerspot tries to divine first and last names, but sometimes screwes up leaving one or the other blank
            // which I turn into "X".   Fortunately they also provide a "who" field that is first/last concatenated
            // so just use this
            $this->fields['firstname'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 6);
            $this->fields['lastname'] = "";
            $this->fields['email'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 12);
            $this->fields['phone'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 13);
            $this->fields['comments'] = $this->getFromArrayOrReturnX($rowAssociativeArray, 10);
// capture size held as part of name and put into its own field
            $a = $this->fields['firstname'];
            $this->fields['size'] = "";
            if (strpos($a,'VB12') !== false) { $this->fields['size'] = "12B"; }
            if (strpos($a,'VB11') !== false) { $this->fields['size'] = "11B"; }
            if (strpos($a,'VB10') !== false) { $this->fields['size'] = "10B"; }
            if (strpos($a,'VB9')  !== false) { $this->fields['size'] = " 9B"; }
            if (strpos($a,'VB8')  !== false) { $this->fields['size'] = " 8B"; }
            if (strpos($a,'VB7')  !== false) { $this->fields['size'] = " 7B"; }

            if (strpos($a,'NB12') !== false) { $this->fields['size'] = "12B"; }
            if (strpos($a,'NB11') !== false) { $this->fields['size'] = "11B"; }
            if (strpos($a,'NB10') !== false) { $this->fields['size'] = "10B"; }
            if (strpos($a,'NB9')  !== false) { $this->fields['size'] = " 9B"; }
            if (strpos($a,'NB8')  !== false) { $this->fields['size'] = " 8B"; }
            if (strpos($a,'NB7')  !== false) { $this->fields['size'] = " 7B"; }

            if (strpos($a,'VG12') !== false) { $this->fields['size'] = "12G"; }
            if (strpos($a,'VG11') !== false) { $this->fields['size'] = "11G"; }
            if (strpos($a,'VG10') !== false) { $this->fields['size'] = "10G"; }
            if (strpos($a,'VG9')  !== false) { $this->fields['size'] = " 9G"; }
            if (strpos($a,'VG8')  !== false) { $this->fields['size'] = " 8G"; }
            if (strpos($a,'VG7')  !== false) { $this->fields['size'] = " 7G"; }

            if (strpos($a,'NG12') !== false) { $this->fields['size'] = "12G"; }
            if (strpos($a,'NG11') !== false) { $this->fields['size'] = "11G"; }
            if (strpos($a,'NG10') !== false) { $this->fields['size'] = "10G"; }
            if (strpos($a,'NG9')  !== false) { $this->fields['size'] = " 9G"; }
            if (strpos($a,'NG8')  !== false) { $this->fields['size'] = " 8G"; }
            if (strpos($a,'NG7')  !== false) { $this->fields['size'] = " 7G"; }

            if (strpos($a,'C12') !== false) { $this->fields['size'] = "12cox"; }
            if (strpos($a,'C11') !== false) { $this->fields['size'] = "11cox"; }
            if (strpos($a,'C10') !== false) { $this->fields['size'] = "10cox"; }
            if (strpos($a,'C9')  !== false) { $this->fields['size'] = " 9cox"; }
            if (strpos($a,'C8')  !== false) { $this->fields['size'] = " 8cox"; }
            if (strpos($a,'V7')  !== false) { $this->fields['size'] = " 7cox"; }





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
        $this->fields['comments'] = $rowAssociativeArray['comments'];
        $this->fields['size'] = $rowAssociativeArray['size'];

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
        $array['comments'] = $this->fields['comments'];
        $array['size'] = $this->fields['size'];

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
    
   