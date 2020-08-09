<?php

function smarty_modifier_couponcodesanitizer($string)
{
  // 英数字とカンマ以外に受け付けない
  return preg_replace('/[^0-9A-Za-z\-]/', '', $string);
}
