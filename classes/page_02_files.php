<!-- 
	reference:  http://www.html-form-guide.com/php-form/php-form-checkbox.html
-->

<div id="navigation">
    <?php
    include '../navigation/functions.php';
    Navigation();
    ?>
</div>


<?php
if (array_key_exists('deleteList', $_POST)) {
    foreach ($_POST['deleteList'] as $toDelete) {
        unlink('../upload/' . $toDelete);
    }
}
?>


<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html;  charset=utf-8">
    <link href="../navigation/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div id="navigation"></div>

<div id="content">

    <h3>Files you have uploaded:</h3>

    <form method="post">

        <fieldset>
            <legend>Rakers (VolunteerSpot)</legend>
            <?php
            $d = dir('../upload/VolunteerSpot/rakers/');
            while (false !== ($entry = $d->read())) {
                if ($entry != "." && $entry != "..") {
                    printf("
							<br><label> <input type=checkbox name=deleteList[] value=\"%s\"> %s  </label> \n",
                        $entry, $entry
                    );
                }
            }
            $d->close();
            ?>
            <p>
                <input type="submit" name="delete" value="Delete">
        </fieldset>


        <fieldset>
            <legend>Supervisors (VolunteerSpot)</legend>
            <?php
            $d = dir('../upload/VolunteerSpot/supervisors/');
            while (false !== ($entry = $d->read())) {
                if ($entry != "." && $entry != "..") {
                    printf("
							<br><label> <input type=checkbox name=deleteList[] value=\"%s\"> %s  </label> \n",
                        $entry, $entry
                    );
                }
            }
            $d->close();
            ?>
            <p>
                <input type="submit" name="delete" value="Delete">
        </fieldset>


        <fieldset>
            <legend>Customers (SuperSAAS)</legend>
            <?php
            $d = dir('../upload/SuperSAAS/');
            while (false !== ($entry = $d->read())) {
                if ($entry != "." && $entry != "..") {
                    printf("
							<br><label> <input type=checkbox name=deleteList[] value=\"%s\"> %s  </label> \n",
                        $entry, $entry
                    );
                }
            }
            $d->close();
            ?>
            <p>
                <input type="submit" name="delete" value="Delete">
        </fieldset>


        <fieldset>
            <legend>Roster</legend>
            <?php
            $d = dir('../upload/roster/');
            while (false !== ($entry = $d->read())) {
                if ($entry != "." && $entry != "..") {
                    printf("
							<br><label> <input type=checkbox name=deleteList[] value=\"%s\"> %s  </label> \n",
                        $entry, $entry
                    );
                }
            }
            $d->close();
            ?>
            <p>
                <input type="submit" name="delete" value="Delete">
        </fieldset>



    </form>
</div>
</body>
</html>
