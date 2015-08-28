<?php
require_once("../my_error_handler.php");
set_error_handler("my_error_handler");
?>

<?php

class ControllerTableAppointments extends ControllerTable implements MatchUppableInterface
{

    //////////////////////////////////////////////
    // METHODS REQUIRED BY MatchUppableInterface

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
        return array(
            'CustName',
            'ApptStart');
    }

    /**
     * @return array
     */
    public function columnsDataslug()
    {
        return array_merge(
            $this->columnsNameslug(),
            array(
//            'ApptStart',
                'ApptEnd',
                'ApptDescription',
//            'CustName',
                'CustPhone',
                'CustStreet',
                'CustDescription',
                'CustNotes',
                'CustEmail',
                'ReservedBy'));
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