
<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php

abstract class RowSingle
{

    public $slug;

    public function __construct($slug)
    {
        $this->slug = $slug;
    }

    public function slug()
    {
        return $this->slug;
    }
    
    abstract protected function getColumn($index);
}
?>


