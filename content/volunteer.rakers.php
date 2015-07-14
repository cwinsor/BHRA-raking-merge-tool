
<div id="navigation">
  <?php
include '../navigation/functions.php';
Navigation();
?>
</div>


<?php
require_once ("../my_error_handler.php");
set_error_handler("my_error_handler");
?>


<?php
//if (isset($_POST['addSingle']))
//{
//    header('Location: volunteer.rakers.add.single.php');
//}
if (isset($_POST['addFromFile']))
{
    header('Location: volunteer.rakers.add.from.file.php');
}
if (isset($_POST['deleteAll']))
{
    header('Location: volunteer.rakers.delete.all.php?DELETE_ALL');
}
?>



<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html;  charset=utf-8">
<link href="../navigation/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="navigation"></div>

	<div id="content">
		<form method="post" actions="" action="">
			<fieldset>
				<legend> Volunteer Rakers: </legend>
				<ul>
            <?php
            
            $databasehost = "localhost";
            $databasename = "bhra_raking_merge";
            $databasetable = "volunteer_raw_raker";
            $databaseusername = "root";
            $databasepassword = "";
            
            $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
            $sql = "SELECT * FROM $databasetable";
            $result = mysqli_query($db, $sql);
            mysqli_close($db);
            
            foreach ($result as $row)
            {
                printf("\n");
                printf('
                    <li>
                    <a href="volunteer.raker.update.php?id=%s">view/update</a>
                    <a href="volunteer.raker.delete.php?id=%s">delete</a>
                    %d %s %s
                    </li>',
                     htmlspecialchars($row['id_volunteer']),
                     htmlspecialchars($row['id_volunteer']),
                     htmlspecialchars($row['id_volunteer']),
                     htmlspecialchars($row['Email']),
                     htmlspecialchars($row['Who']));
            }
            ?>
        </ul>

				<input type="submit" name="addSingle" value="ADD SINGLE"> <input
					type="submit" name="addFromFile" value="ADD FROM FILE"> <input
					type="submit" name="deleteAll" value="DELETE ALL">
			</fieldset>
		</form>
	</div>
</body>
</html>

