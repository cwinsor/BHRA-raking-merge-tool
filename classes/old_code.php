<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

class DatabaseTableRakers extends DatabaseTable
{


    
    // populate from .csv file
    public function populateFromRosterCsv($filename)
    {
        // map from csv file column to database column
        // these columns are considered the slug
        // a match on these columns maps a csv row to database row
        $slugMap = array(
            1 => 'rosterFirstname',
            2 => 'rosterLastname'
        );
        // map from csv file colum to database column
        // these columns are considered the data
        // a match is not required, but a miscompare indicates the database may want to be updated
        $dataMap = array(
            7 => cellphone,
            8 => gender
        );
        
        $row = 1;
        if (($handle = fopen($filename, "r")) !== FALSE)
        {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
            {
                // push it onto the array
                array_push($volunteerRakerArray, $data);
                
                // pretty print
                // $num = count($data);
                // echo "<p> $num fields in line $row: <br /></p>\n";
                // $row ++;
                // for ($c = 0; $c < $num; $c ++)
                // {
                // echo $data[$c] . "<br />\n";
                // }
            }
            fclose($handle);
        } else
        {
            trigger_error("unable to open file $filename", E_USER_NOTICE);
        }
    }
   

}
?>