<?php
function smarty_modifier_removejs($string)
{
	return preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $string);
}
