
<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php

class RowSingleStudent extends MappableThing
{

    public $firstname;

    public $lastname;

    public $grade;

    public function __construct($firstname, $lastname, $grade)
    {
        $this->firstname = $firsttname;
        $this->lastname = $lastname;
        $this->grade = $grade;
        super__construct(trim($firsttname . $lastname));
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


