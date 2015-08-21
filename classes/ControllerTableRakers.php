<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

class ControllerTableRakers extends ControllerTable implements MatchUppableInterface
{

    //////////////////////////////////////////////
    // METHODS REQUIRED BY INTERFACE...

    /**
     * @return array
     */
    public function rowNumbers()
    {
        return array_keys($this->localTable);
    }

    /**
     * @return array
     */
    public function columnsNameslug()
    {
        return array('rosterFirstname', 'rosterLastname');
    }

    /**
     * @return array
     */
    public function columnsDataslug()
    {
        return array('cellphone', 'gender');
    }

    /**
     * @param $rowId
     * @param $colId
     * @return mixed
     */
    public function getDataElement($rowId, $colId)
    {
        $myRow = $this->localTable[$rowId];
        return $myRow->modelGetField($colId);
    }
}

?>