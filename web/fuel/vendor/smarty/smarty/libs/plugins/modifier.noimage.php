<?php
function smarty_modifier_noimage($string)
{
	
	$string = htmlspecialchars_decode($string);
	$string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $string);
	$string = preg_replace("/<img[^>]+\>/i", "", $string);
// 	$string = nl2br($string);
	
	return $string;
}
