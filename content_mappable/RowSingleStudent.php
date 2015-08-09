
<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php

class RowSingleStudent extends RowSingle
{

    public $firstname;

    public $lastname;

    public $grade;

    public function __construct($firstname, $lastname, $grade)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->grade = $grade;
        parent::__construct(trim($firstname . $lastname));
    }

    public function getColumn($index)
    {
        if ($index == 0)
            return $firstname;
        if ($index == 1)
            return $lastname;
        if ($index == 2)
            return $grade;
        return "";
    }
}
?>


