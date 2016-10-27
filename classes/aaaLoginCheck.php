<?php
session_start();
if (0 == strcmp($_SESSION['login_status'], "successful")) {
    
} else {    
    header("location: page_00_login.php");
}
?>