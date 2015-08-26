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
        return array(
            'ApptStart',
            'ApptEnd',
            'ApptDescription',
            'Foo',
            'CustName',
            'CustPhone',
            'CustStreet',
            'CustDescription',
            'Team',
            'CustEmail',
            'ReservedBy',
            'DTme1',
            'DTme2');
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