<?php

// common function to
// un-escape and strip slases any POST or GET data from user
// i.e. to cleanse it

function cleanse($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
