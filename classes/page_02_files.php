<?php
include_once "aaaStandardIncludes.php";
?>


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


<?php
$msg = '';
// SUBMIT BUTTON
if (isset($_POST['submit'])) {

    $upload_types = array(
        "file_upload_vr" => "../upload/VolunteerSpot/rakers/",
        "file_upload_vs" => "../upload/VolunteerSpot/supervisors/",
        "file_upload_ca" => "../upload/SuperSAAS/",
        "file_upload_ro" => "../upload/roster/");

    foreach ($upload_types as $upload_type => $target_dir) {
        if ((isset($_FILES[$upload_type]['name'])) && ($_FILES[$upload_type]['name'] !== "")) {
            $name = $_FILES[$upload_type]['name'];

            // Check if there are any errors in the upload
            if ($_FILES[$upload_type]['error'] > 0) {
                $msg .= " An error ocurred when uploading " . $name . ".";
            }
            // Check that the file is under our file size limit
            if ($_FILES[$upload_type]['size'] > 500000) {
                $msg .= " File " . $name . " exceeds maximum upload size.";
            }
            // Check that the file doesn't already exist (based on name)
            if (file_exists($target_dir . $_FILES[$upload_type]['name'])) {
                $msg .= " File with name " . $name . " already exists.";
            }
            // Finally upload the file
            if (!move_uploaded_file($_FILES[$upload_type]['tmp_name'], $target_dir . $_FILES[$upload_type]['name'])) {
                $msg .= " Error uploading " . $name . " - check destination is writeable.";
            }
        }
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

    <form method="post">

        <h3>--- Current Files ---</h3>

        <fieldset>
            <legend>Rakers (VolunteerSpot)</legend>
            <?php
            $path = '../upload/VolunteerSpot/rakers/';
            $d = dir($path);
            while (false !== ($entry = $d->read())) {
                if ($entry != "." && $entry != "..") {
                    echo "<br><label> <input type=checkbox name=deleteList[] value='" . $path . $entry . "'> " . $entry . " </label> \n";
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
            $path = '../upload/VolunteerSpot/supervisors/';
            $d = dir($path);
            while (false !== ($entry = $d->read())) {
                if ($entry != "." && $entry != "..") {
                    echo "<br><label> <input type=checkbox name=deleteList[] value='" . $path . $entry . "'> " . $entry . " </label> \n";
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
            $path = '../upload/SuperSAAS/';
            $d = dir($path);
            while (false !== ($entry = $d->read())) {
                if ($entry != "." && $entry != "..") {
                    echo "<br><label> <input type=checkbox name=deleteList[] value='" . $path . $entry . "'> " . $entry . " </label> \n";
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
            $path = '../upload/roster/';
            $d = dir($path);
            while (false !== ($entry = $d->read())) {
                if ($entry != "." && $entry != "..") {
                    echo "<br><label> <input type=checkbox name=deleteList[] value='" . $path . $entry . "'> " . $entry . " </label> \n";
                }
            }
            $d->close();
            ?>
            <p>
                <input type="submit" name="delete" value="Delete">
        </fieldset>
    </form>

    <h3>--- Upload New Files ---</h3>

    <form method="post" enctype="multipart/form-data">

        <fieldset>
            <br><label><input type=file name=file_upload_vr multiple>volunteer rakers (VolunteerSpot)</label>
            <br><label><input type=file name=file_upload_vs multiple>volunteer supervisors (VolunteerSpot)</label>
            <br><label><input type=file name=file_upload_ca multiple>customer appointments (SuperSAAS)</label>
            <br><label><input type=file name=file_upload_ro multiple>roster</label>
            <br><input type="submit" name="submit" value="Upload">
        </fieldset>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        echo ($msg == '') ? 'upload done' : $msg;
    }
    ?>


</div>
</body>
</html>
