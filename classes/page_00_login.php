<?php
require "aaaIncludeFiles.php";
$ini = parse_ini_file($GLOBALS['meatpacker_config_file']);
?>
<?php
session_start(); // Starting Session
$error = ''; // Variable To Store Error Message
$_SESSION['login_status'] = "unsuccessful";
if (isset($_POST['submit'])) {
    $password = cleanse($_POST['password']);
    if (empty($password) || (0 != strcmp($password, $ini['meatpacker_admin_password']))) {
        $error = "Invalid";
    } else {
        $error = "Valid";
        $_SESSION['login_status'] = "successful";
          header("location: page_01_welcome.php");
    }
}
?>

<html>
    <head>
        <meta
            http-equiv = "content-type"
            content = "text/html;  charset=utf-8"
            >
        <link
            href = "../navigation/style.css"
            rel = "stylesheet"
            type = "text/css"
            >

    </head>
    <body>



        <div id = "content">

            <h3>Welcome to the Leaf Raking Merge Tool</h3>

            <div id = "main">

                <div id = "login">
                    <h2>Please log in</h2>
                    <form action = "" method = "post">
                        <label>Password :</label>
                        <input id = "password" name = "password" placeholder = "**********" type = "password">
                        <input name = "submit" type = "submit" value = " Login ">
                    </form>
                    <span><?php echo $error;
?></span>
                </div>
            </div>
    </body>
</html>

