
<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php

class RowList
{

    public $title;

    public $arrayOfRowSingle;

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function addRowSingle($rowSingle)
    {
        $arrayOfRowSingle[$rowSingle->slug()] = $rowSingle;
    }

    public function deleteRowSingleRs($rowSingle)
    {
        unset($arrayOfRowSingle[$rowSingle->slug()]);
    }

    public function deleteRowsingleSlug($slug)
    {
        unset($arrayOfRowSingle[$slug]);
    }
}
?>


