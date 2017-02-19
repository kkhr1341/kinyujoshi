<?php
function smarty_modifier_nofilter($string)
{
	
	$string = htmlspecialchars_decode($string);
	$string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $string);
// 	$string = nl2br($string);
	
	return $string;
}
