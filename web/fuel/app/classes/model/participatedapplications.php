<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class ParticipatedApplications extends Base
{

    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('application_code')
            ->add_rule('required');

        return $val;
    }

    public static function create($application_code)
    {
        $code = self::getNewCode('participated_applications');

        // 申し込みイベントデータ作成
        \DB::insert('participated_applications')->set(array(
            'code' => $code,
            'application_code' => $application_code,
            'created_at' => \DB::expr('now()'),
        ))->execute();
    }

    public static function lists($username)
    {
        return\DB::select(\DB::expr('events.*'))
            ->from('events')
            ->join('applications')
            ->on('applications.event_code', '=', 'events.code')
            ->join('participated_applications')
            ->on('participated_applications.application_code', '=', 'applications.code')
            ->where('applications.username', '=', $username)
            ->where('applications.disable', '=', 0)
            ->where('applications.cancel', '=', 0)
            ->order_by('events.event_date', 'asc')
            ->execute()
            ->as_array();
    }
}
