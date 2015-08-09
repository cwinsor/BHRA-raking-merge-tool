
<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php

class MappingTool
{
    // properties
	public $rowList1;

	public $rowList2;

	public $slugMap;

	public function __construct($rowList1, $rowList2)
	{
		$this->rowList1 = $rowList1;
		$this->rowList2 = $rowList2;
	}
}
?>


