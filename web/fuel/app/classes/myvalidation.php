<?php

class MyValidation
{
    /*
     *
     */
    public static function _validation_exists($val, $options)
    {
        $table = $options['table'];
        $field = $options['field'];

        $result = DB::select("$field")
            ->where($field, '=', Str::lower($val))
            ->from($table)
            ->execute();

        if ($result->count() == 0) {
            return false;
        }
        return true;
    }

    /*
     *
     */
    public static function _validation_unique($val, $options)
    {
        // list ($table, $field) = explode('.', $options);
        $table = $options['table'];
        $field = $options['field'];
        $wheres = (isset($options['where'])) ? $options['where'] : array();

        $select = DB::select("$field")
            ->where($field, '=', Str::lower($val))
            ->from($table);

        if (isset($options['exclude']['id']) && $exclude_id = $options['exclude']['id']) {
            $select->where('id', '<>', (int)$exclude_id);
        }

        foreach ($wheres as $where) {
            switch (count($where)) {
                case(2):
                    $select->where($where[0], $where[1]);
                    break;
                case(3):
                    $select->where($where[0], $where[1], $where[2]);
                    break;
            }
        }

        $result = $select->execute();

        return !($result->count() > 0);
    }

//    /*
//     * 半角数字チェック
//     */
//    public static function _validation_num($data)
//    {
//        if (!empty($data)) {
//            if (preg_match("/^[0-9]+$/", $data)) {
//                return true;
//            } else {
//                return false;
//            }
//        }
//        return true;
//    }
//
    /*
     * 半角英数字チェック
     */
    public static function _validation_alphanum($data)
    {
        if (!empty($data)) {
            if (preg_match("/^[a-zA-Z0-9]+$/", $data)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * Match specific other submitted field string value
     * (must be both strings, check is type sensitive)
     *
     * @param
     *            string
     * @param
     *            string
     * @return bool
     */
    public static function _validation_match_validated_field($val, $field)
    {
        $active = \Validation::active();
        $field_val = $active->validated($field);
        if (!$field_val) {
            $error = $active->error($field);
            $field_val = $error ? $error->value : $active->input($field);
        }
        return $field_val === $val;
    }

    /**
     * 値の正当性チェック
     */
    public static function _validation_checkbox_val($val, $options)
    {
        if ($val) {
            if (!is_array($val)) {
                return false;
            }
            foreach ($val as $v) {
                if (!array_key_exists($v, $options)) return false;
            }
        }
        return true;
    }

    /**
     * 配列必須チェック
     */
    public static function _validation_checkbox_require($val)
    {
        if (!$val || !is_array($val)) {
            return false;
        }

        foreach ($val as $data) {
            if (!empty($data)) {
                return true;
            }
        }

        return false;
    }

    public static function _validation_is_fullwidth_katakana($val)
    {
        if (!$val) {
            return true;
        }

        if (preg_match("/^[ァ-ヶー]+$/u", $val)) {
            return true;
        }
        return false;
    }

    public static function _validation_is_tel($val)
    {
        if (!$val) {
            return true;
        }

        if (preg_match('/^([0-9]+)-?([0-9]+)-?([0-9]+)$/', $val)) {
            return true;
        }
        return false;
    }

    public static function _validation_is_zip($val)
    {
        if (!$val) {
            return true;
        }

        if (preg_match('/^([0-9]{3})-?([0-9]{4})$/', $val)) {
            return true;
        }
        return false;
    }

    public static function _validation_is_unique_array_value($val)
    {
        if (!$val) {
            return true;
        }
        $array_value = array_count_values($val);
        foreach ($array_value as $key => $count) {
            if ($count > 1) {
                return false;
            }
        }
        return true;
    }

    /**
     * Match specific other submitted field string value
     * (must be both strings, check is type sensitive)
     *
     * @param
     *            string
     * @param
     *            string
     * @return bool
     */
    public static function _validation_require_without($val, $field)
    {
        $active = \Validation::active();
        $field_val = $active->validated($field);
        if (!$field_val && !$val) {
            return false;
        }
        return true;
    }
}