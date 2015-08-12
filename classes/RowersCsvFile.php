<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

class RowersCsvFileRoster
{

    function __construct() {
        parent::__construct();

        $slugMap = array(
           'rosterFirstname',
           'rosterLastname'
        );

        $dataMap = array(
           "cellphone",
           "gender
        );
                    }
    
    
    public $volunteerRakerArray;

    private $slugMap;

    private $dataMap;
    
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
    
    // populate from database
    public function populateFromDatabase()
    {
        include '../.env_database_password';
        $databasetable = "v2volunteerRakers";
        
        $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
        $sql = "SELECT * FROM $databasetable";
        $volunteerRakerArray = mysqli_query($db, $sql);
        mysqli_close($db);
    }
    
    // update database
    public function updateDatabase()
    {
        foreach ($volunteerRakerArray as $volunteerRaker)
        {
            $volunteerRaker->updateDatabase();
        }
    }
}
?>