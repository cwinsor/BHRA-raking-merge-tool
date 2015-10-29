<?php
///////////////////////////////////////////
// user option to skip first line of .csv file (frequently a header line)
//  echo "<br>";
echo "\n<br>";
echo "\n<br>Skip first (header) line?";
echo "\n<br></b><input type=radio name=skipFirstLine " . ($skipFirstLine ? "checked" : "") . " value=yes>yes";
echo "\n</b><input type=radio name=skipFirstLine " . (!$skipFirstLine ? "checked" : "") . " value=no>no";

///////////////////////////////////////////
// user option to set verbose (see all data fields)
echo "\n<br>";
echo "\n<br>Verbose?";
echo "\n<br></b><input type=radio name=verbose " . ($getDisplayVerbose ? "checked" : "") . " value=yes>yes";
echo "\n</b><input type=radio name=verbose " . (!$getDisplayVerbose ? "checked" : "") . " value=no>no";

?>