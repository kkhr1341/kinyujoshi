<?php

class Validation_Error extends Fuel\Core\Validation_Error
{
    protected function _replace_tags($msg)
    {
        $msg = parent::_replace_tags($msg);
        $find = __('validation.valid_string_params');

        if( $find ){

            $msg = str_replace('valid_string(', '', $msg);
            $msg = str_replace(')', '', $msg);

            foreach( $find as $param => $str ){
                $msg = str_replace($param, $str, $msg);
            }
        }

        return $msg;
    }
}