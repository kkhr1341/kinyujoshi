<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class EventDisplayTopPages extends Base
{
    public static function save($event_code)
    {
        \DB::delete('event_display_top_pages')
            ->execute();
        \DB::insert('event_display_top_pages')
            ->set(array(
                'event_code' => $event_code,
                'created_at' => \DB::expr('now()'),
            ))
            ->execute();
    }

    public static function delete()
    {
        \DB::delete('event_display_top_pages')->execute();
    }

    public static function get()
    {
        return \DB::select(\DB::expr('*'))
            ->from('event_display_top_pages')
            ->join('events')
            ->on('events.code', '=', 'event_display_top_pages.event_code')
            ->where('events.status', '=', 1)
            ->where('events.disable', '=', 0)
            ->execute()
            ->current();

    }
}
