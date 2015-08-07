<?php
class VolunteerRakerModel
{

    public function __construct(){
    }

    
    

   
    
    


    /**
     * load all rows
     *
     * @param  id->value
     * @return array($this)
     */
    public function load()
    {     
        include '../.env_database_password';
        $databasetable = "volunteer_raw_raker";
        
        $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
        $sql = "SELECT * FROM $databasetable";
        $result = mysqli_query($db, $sql);
        mysqli_close($db);

        foreach ($result as $row)
        {
            $item = new this;
            $item->id = $row->id;
            
        }
        
        if (is_string($relations)) {
            $relations = func_get_args();
        }
        
        $query = $this->newQuery()->with($relations);
        
        $query->eagerLoadRelations([$this]);
        
        return $this;
        
        
    
    }
    


    /**
     * load single row
     *
     * @param  id
     * @return $this
     */
    public function load($id)
    {
        if (is_string($rela
    
   
}
