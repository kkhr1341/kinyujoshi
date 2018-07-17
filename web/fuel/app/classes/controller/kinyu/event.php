<?php

use \Model\Events;
use \Model\Blogs;
use \Model\Profiles;
use \Model\Applications;
use \Model\UserCreditCard;
use \Model\Payment;

class Controller_Kinyu_Event extends Controller_Kinyubase
{
    public function action_index($page = 1)
    {
        $this->data['events'] = Events::all('event', '/event/', $page, 2, 20, 0);
        $pagination = $this->data['events']['pagination'];
        $this->data['pagination'] = $pagination::instance('mypagination');
        $this->template->title = '女子会｜きんゆう女子。';
        $this->template->description = "きんゆう女子。では、お金に関する様々な情報を学ぶことができるイベントを開催しています。みなさんでお金に関するあれこれをたくさんおしゃべりしましょう！";
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-jyoshikai.jpg';
        $this->template->today = date("Y年n月");
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->kinyu_event_notes = View::forge('kinyu/event/notes.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
            $this->template->contents = View::forge('kinyu/event/sp_index.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
            $this->template->contents = View::forge('kinyu/event/index.smarty', $this->data);
        }
    }

    public function action_past($page = 1)
    {
        $this->data['events'] = Events::all('event', '/event/', $page, 2, 100, 0, 0);
        $pagination = $this->data['events']['pagination'];
        $this->data['pagination'] = $pagination::instance('mypagination');
        $this->template->title = '過去の女子会｜きんゆう女子。';
        $this->template->description = "きんゆう女子。では、お金に関する様々な情報を学ぶことができるイベントを開催しています。みなさんでお金に関するあれこれをたくさんおしゃべりしましょう！";
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-jyoshikai.jpg';
        $this->template->today = date("Y年n月");
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->kinyu_event_notes = View::forge('kinyu/event/notes.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
            $this->template->contents = View::forge('kinyu/event/sp_past.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
            $this->template->contents = View::forge('kinyu/event/past.smarty', $this->data);
        }
    }

    public function action_detail($code)
    {
        if (Input::get('preview', '') != 1 && !$this->viewable($code)) {
            throw new HttpNoAccessException;
        }
        // 最新を取得
        $this->data['events'] = Events::all('kinyu', '/kinyu/event/', 1, 3, 5, 0);
        $this->data['event'] = Events::getByCode('events', $code);

        $this->template->title = $this->data['event']['title'];
        $this->data['join_status'] = Applications::join_status($code);
        $this->data['event_row'] = Events::getByCode('events', $code);
        $this->template->ogimg = $this->data['event']['main_image'];
        $this->data['top_blogs'] = Blogs::lists(1, 5, true);
        $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
        $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
        $this->template->description = $this->data['event']['title'];
        $this->template->urlcode = $this->data['event_row']['code'];

        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->kinyu_event_notes = View::forge('kinyu/event/notes.smarty', $this->data);
        $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/event/detail.smarty', $this->data);
    }

    public function action_tickets($code)
    {
        \Config::load('payjp', true);
        $this->data['payjp_public_key'] = \Config::get('payjp.private_key');
        // 最新を取得
        $this->data['events'] = Events::all('kinyu', '/kinyu/event/', 1, 3, 5, 0);
        $this->data['event'] = Events::getByCode('events', $code);

        $this->template->title = 'イベント詳細｜きんゆう女子。';
        $this->data['join_status'] = Applications::join_status($code);
        $this->data['event_row'] = Events::getByCode('events', $code);
        $this->template->ogimg = $this->data['event']['main_image'];
        $this->data['top_blogs'] = Blogs::lists(1, 5, true);
        $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
        $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
        $this->template->description = $this->data['event']['title'];
        $this->template->urlcode = $this->data['event_row']['code'];

        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->kinyu_event_notes = View::forge('kinyu/event/notes.smarty', $this->data);
        $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/event/tickets.smarty', $this->data);
    }

    public function action_tickets_card($code)
    {
        \Config::load('payjp', true);
        $this->data['payjp_public_key'] = \Config::get('payjp.private_key');
        // 最新を取得
        $this->data['events'] = Events::all('kinyu', '/kinyu/event/', 1, 3, 5, 0);
        $this->data['event'] = Events::getByCode('events', $code);

        $this->template->title = 'イベント詳細｜きんゆう女子。';
        $this->data['join_status'] = Applications::join_status($code);
        $this->template->ogimg = $this->data['event']['main_image'];
        $this->data['top_blogs'] = Blogs::lists(1, 5, true);
        $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
        $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
        $this->template->description = $this->data['event']['title'];

        // 登録カード取得
        if ($username = \Auth::get('username')) {
            $profile = Profiles::get($username);
            $this->data['user'] = array(
                'name' => $profile['name'],
                'email' => \Auth::get('email'),
            );
        }
        $this->data['cards'] = $this->get_credit_cards(\Config::get('payjp.private_key'));

        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->kinyu_event_notes = View::forge('kinyu/event/notes.smarty', $this->data);
        $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/event/tickets_card.smarty', $this->data);
    }

    public function action_tickets_cash($code)
    {
        \Config::load('payjp', true);
        $this->data['payjp_public_key'] = \Config::get('payjp.private_key');
        // 最新を取得
        $this->data['events'] = Events::all('kinyu', '/kinyu/event/', 1, 3, 5, 0);
        $this->data['event'] = Events::getByCode('events', $code);
        $this->template->title = 'イベント詳細｜きんゆう女子。';
        $this->data['join_status'] = Applications::join_status($code);
        $this->data['event_row'] = Events::getByCode('events', $code);
        $this->template->ogimg = $this->data['event']['main_image'];
        $this->data['top_blogs'] = Blogs::lists(1, 5, true);
        $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
        $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
        $this->template->description = $this->data['event']['title'];
        $this->template->urlcode = $this->data['event_row']['code'];

        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->kinyu_event_notes = View::forge('kinyu/event/notes.smarty', $this->data);
        $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/event/tickets_cash.smarty', $this->data);
    }

    public function action_complete()
    {
        $this->template->title = '女子会のご予約ありがとうございます。｜きんゆう女子。';
        $this->template->description = "きんゆう女子。では、お金に関する様々な情報を学ぶことができるイベントを開催しています。みなさんでお金に関するあれこれをたくさんおしゃべりしましょう！";
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-jyoshikai.jpg';
        $this->template->today = date("Y年n月");
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->kinyu_event_notes = View::forge('kinyu/event/notes.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }

        $this->template->contents = View::forge('kinyu/event/complete.smarty', $this->data);
    }

    /**
     * 登録カード取得
     */
    private function get_credit_cards($private_key)
    {
        if (!$username = \Auth::get('username')) {
            return array();
        }
        if (!$cardIds = UserCreditCard::lists($username)) {
        }
        $payment = new Payment($private_key);
        if (!$customer = $payment->getCustomer($username)) {
            return array();
        }
        $cards = array();
        foreach ($cardIds as $cardId) {
            if ($card = $payment->getCard($customer, $cardId)) {
                $cards[] = $card;
            }
        }
        return $cards;
    }

    private function viewable($code)
    {
        $event = Events::getByCode('events', $code);
        if ($event['status'] == 0) {
            return false;
        }
        if ($event['specific_link']) {
            return false;
        }
        if ($event['secret'] == 0) {
            return true;
        }
        if (Auth::check()) {
            return true;
        }
        return false;
    }
}
