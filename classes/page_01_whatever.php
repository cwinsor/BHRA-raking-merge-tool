<?php
require "aaaStandardIncludes.php";
$ini = parse_ini_file($GLOBALS['meatpacker_config_file']);
?>


<!DOCTYPE html>
<html>
<body>

<?php
echo "login status is " . $_SESSION['login_status'] . ".<br>";   
 $_SESSION['login_status'] = "successful";
 
?>

</body>
</html>


