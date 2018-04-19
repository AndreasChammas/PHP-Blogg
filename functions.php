<?php

function n12p($text)
{

	$text = '<p>'.str_replace(array("\r\n", "\r", "\n"), "</p><p>",$text). '</p>';

	return str_replace("<p></p>", "", $text);

}

?>