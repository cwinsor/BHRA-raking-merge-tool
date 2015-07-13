
<?php
function check_string_empty_string_ok($candidate, $msg, &$final, &$fail_string)
{
$final = $candidate;
}
?>


<?php
function check_string_empty_string_bad($candidate, $msg, &$final, &$fail_string)
{
	// can be any non-empty string
	if ($candidate && ($candidate != ''))
	{
		$final = $candidate;
	}
	else {
		$final = '';
		$fail_string .= " " . $msg . "=" . $candidate;
	}
}
?>


<?php
function check_string_against_list($candidate, $msg, &$final, &$fail_string, $choices)
{
	// can be any of the given choices
	$found = false;
	foreach($choices as $choice)
	{
		if ($candidate == $choice)
		{
			$final = $choice;
			$found = true;
		}
	}
	if (!$found)
	{
		$final = '';
		$fail_string .= " " . $msg . "=" . $candidate;
	}
}
?>
