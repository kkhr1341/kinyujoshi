<?php

use \Model\Applications;
use \Model\Events;

class Controller_My_Top extends Controller_Mybase
{

    public function action_index()
    {
        $this->data['applications'] = Applications::get_applications();
        foreach($this->data['applications'] as $key => $data){
            // 二日目の女子会開催日
            $event_other_dates = Events::getEventOtherDates($data['event_code']);
            $this->data['applications'][$key]['event_date2'] = isset($event_other_dates[0]['event_date'])? $event_other_dates[0]['event_date']: '';
            $this->data['applications'][$key]['event_start_datetime2'] = isset($event_other_dates[0]['event_start_datetime'])? $event_other_dates[0]['event_start_datetime']: '';
            $this->data['applications'][$key]['event_end_datetime2'] = isset($event_other_dates[0]['event_end_datetime'])? $event_other_dates[0]['event_end_datetime']: '';
        }

        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->title = 'マイページ｜きんゆう女子。';
        $this->template->description = 'マイページ・トップ';
        $this->template->my_side = View::forge('my/common/my_side.smarty', $this->data);
        $this->template->contents = View::forge('my/all.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }
}
