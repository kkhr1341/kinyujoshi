<?php

use \Model\Events;
use \Model\EventCoupons;
use \Model\EventDisplayTopPages;
use \Model\Applications;
use \Model\Sections;
use \Model\EventRemindMailTemplates;

class Controller_Admin_Events extends Controller_Adminbase
{

    public function action_index()
    {
        if (!Auth::has_access('events.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['sections'] = Sections::lists();

        $this->data['past_events'] = Events::lists02(null, null, null, null, "desc", null);
        $this->data['closed_events'] = Events::lists(0, null, null, null, "desc", null);
        $this->data['open_events'] = Events::lists(1, null, null, null, "desc", null);
        $this->data['all_events'] = Events::lists03();
        $this->data['display_top_event'] = EventDisplayTopPages::get();
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・イベント';
        $this->template->contents = View::forge('admin/events/index.smarty', $this->data);
    }

    public function action_create()
    {
        if (!Auth::has_access('events.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['sections'] = Sections::lists();
//        $this->data['remind_mail_templates'] = EventRemindMailTemplates::list01();

        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・イベント';

        $this->data['events']['content'] = $this->get_default_content();

        $this->template->contents = View::forge('admin/events/edit.smarty', $this->data);
    }

    public function action_edit($code)
    {
        if (!Auth::has_access('events.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['events'] = Events::getByCode('events', $code);
        $this->data['past'] = Events::isPast($code);
        $this->data['sections'] = Sections::lists();
        $this->data['remind_mail_template'] = EventRemindMailTemplates::getByEventCode($code);

        // 将来的に複数登録できるようにしたいが今はとりあえず1個だけしか登録できない仕様
        $coupons = EventCoupons::getRowsByEventCode($code);
        $this->data['coupon'] = $coupons ? $coupons[0] : array('coupon_code' => '', 'discount' => '');

        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・イベント';
        $this->template->contents = View::forge('admin/events/edit.smarty', $this->data);
    }

    public function action_attend()
    {
        if (!Auth::has_access('applications.read')) {
            throw new HttpNoAccessException;
        }
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        // $this->data['events'] = Events::lists(1, 50, true);
        // $this->data['sections'] = Sections::lists();
        $this->data['all_events'] = Events::lists02(null, null, null, null, null, null, "desc");
       //  $this->data['closed_events'] = Events::lists(0);
        $this->data['open_events'] = Events::lists(1, null, null, null, "desc", null);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = '女子会リスト';
        $this->template->contents = View::forge('admin/events/attend.smarty', $this->data);
    }

    public function action_attend_detail($code)
    {
        if (!Auth::has_access('applications.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['events'] = Events::getByCode('events', $code);
        $this->data['applications'] = Applications::get_applications_by_code($code);
        $this->data['cancel_applications'] = Applications::get_cancel_applications_by_code($code);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = '女子会リスト';
        $this->template->contents = View::forge('admin/events/attend_detail.smarty', $this->data);
    }

    public function action_memberlist($code)
    {
        if (!Auth::has_access('applications.read') || !$this->is_from_company()) {
            throw new HttpNoAccessException;
        }
        $csv_name = Date("Y-m-d") . '.csv';
        $response = new Response();

        // content-type: csv
        $response->set_header('Content-Type', 'application/csv');

        // ファイル名をセット
        $response->set_header('Content-Disposition', 'attachment; filename="'. $csv_name .'"');

        // キャッシュをなしに
        $response->set_header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->set_header('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
        $response->set_header('Pragma', 'no-cache');

        $applications = \Model\Applications::get_applications_by_code($code);


        $data = array();
        $data[] = array(
            "名前",
            "年齢",
            "ワカラナイド",
            "参加回数",
            "メールアドレス",
        );
        foreach ($applications as $application) {

            if ($application["birthday"] && $application["birthday"] != '0000-00-00') {
                $application["birthday"] = floor((date('Ymd') - (str_replace("-", "", $application["birthday"])))/10000);
            } else {
                $application["birthday"] = "";
            }

            if ($application["application_count"] > 0) {
                $application["application_count"]--;
            }

            $data[] = array(
                $application["name"],
                $application["birthday"],
                $application["not_know"],
                $application["application_count"],
                $application["email"],
            );
        }

        // 名前、年齢, 分からないど, 女子会参加回数

        // CSVを出力
        $csv = Format::forge($data)->to_csv();
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
        echo $csv;

        // Response
        return $response;
    }

    /**
     * 新規登録時のデフォルトの本文を取得
     * @return string
     */
    private function get_default_content()
    {
        return '<p>金融ワカラナイ度：はじめてさん＆ゆる〜くお話したい方🌟🌟🌟🌟<br>スタイル：〜ゲストと交流しながらテーマについて考えるスタイル〜</p>
<h2>どんなことを学ぶ？</h2>
<p>100文字〜200文字
</p>
<p>＜写真＞</p>
<h2>今回のゲストは？</h2>
<p>200文字</p>
<p>＜写真＞</p>
<h2>一歩前に進むためには？</h2>
<p>200文字</p>
<p>＜写真＞</p>
<h2>女子会概要</h2>
<p>■日時<br>2019年9月12日（木）</p>
<p><br></p>
<p>■場所</p>
<p>＜写真＞</p>
<p><br></p>
<p>■ゲスト</p>
<p><br></p>
<p>■人数</p>
<p><br></p>
<p>■参加費</p>
<p><br></p>
<p>メンバーさんの場合はギフトコードをマッチすることで（＊＊）円割引になります♪<br>マイページからギフトコードをチェックしてね。</p>
<p><a href="https://kinyu-joshi.jp/my">メンバー向けページはこちら</a></p>
<p><br></p>
<p>■当日のスケジュール<br>19:00〜「きんゆう女子。」コミュニティのご紹介<br>19:10〜自己紹介<br>19:30〜ゲストのお話<br>20:00〜おしゃべり&ワーク<br>20:30〜感想とまとめ、自由解散<br>※スケジュールは予告なく変更になる場合がございます。予めご了承ください。</p>
<p><br></p>
<p>■持ち物</p>
<p><br></p>
<p>■遅刻・欠席について<br>ログインして<a href="https://kinyu-joshi.jp/my">マイページ</a>からまたは、<a href="https://kinyu-joshi.jp/contact">お問い合わせ</a>からお知らせください。</p>
<p><br></p>
<p>■編集部からのお約束<br>どの金融機関にも属さないポジションで、質の高いお金の情報を多角的にシェアできる場を提供します。<br>必要なことを必要なだけまとめた資料を用意、シェアいたします。女子会を通じた営業・勧誘はありません。また、ご参加いただく方同士でも営業・勧誘はお断りさせていただいております。マナーを守ってご参加いただければと思います。お困りのことがあれば編集部まで<a href="https://kinyu-joshi.jp/contact">お問い合わせ</a>ください。</p>
<p><br></p>
<p>＜公式サムネイル＞<br>
<img src="/images/event/official_thumbnail.png"></p>
<p><br></p>
<p>主催：金融ワカラナイ女子のためのコミュニティ「きんゆう女子。」<br>お問い合わせ先：support@kinyu-joshi.jp<br>会場協力：<br>ゲスト協力：</p>';
    }
}
