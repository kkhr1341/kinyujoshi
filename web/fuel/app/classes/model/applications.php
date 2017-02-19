<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class Applications extends Base {
	
	/**
	 * 参加イベント一覧取得
	 * @return unknown
	 */
	public static function get_applications() {

		$username = \Auth::get('username');
		
		$datas = \DB::select(\DB::expr('applications.code as application_code, applications.cancel, events.*'))->from('applications')
			->join('events', 'left')
			->on('applications.event_code', '=', 'events.code')
			->where('applications.username', '=', $username)
			->where('applications.disable', '=', 0)
			->execute()
			->as_array();
		
		return $datas;
	}
	
	/**
	 * 参加状態確認
	 * @param unknown $code
	 * @return boolean
	 */
	public static function join_status($code) {

		$username = \Auth::get('username');
		
		$data = \DB::select('*')->from('applications')
			->where('event_code', '=', $code)
			->where('username', '=', $username)
			->where('cancel', '=', 0)
			->where('disable', '=', 0)
			->execute()
			->current();
		
		if (empty($data)) {
			return false;
		}
		
		return true;
	}


	public static function cancel($params) {

		$username = \Auth::get('username');
		
		// 参加状態取得
		$application = self::getByCode('applications', $params['code']);
		
		// 存在チェック
		if (empty($application)) {
			return "該当の参加申込が見つかりませんでした";
		}
		
		// 自分のかを確認する
		if ($application['username'] != $username) {
			return "セキュリティー上の問題が発生いたしました";
		}
		
		// キャンセル状況確認
		if ($application['cancel'] != 0) {
			return "この参加申し込みは既にキャンセル済みです";
		}
		
		// キャンセルする
		\DB::update('applications')->set(array('cancel' => 1))->where('code', '=', $params['code'])->execute();
		// 参加人数を減らす
		\DB::update('events')->set(array(
			'application_num' => \DB::expr('application_num-1')
		))->where('code', '=', $application['event_code'])->execute();
		
		return true;
	}
	
	
	/**
	 * 参加申し込み
	 * @param unknown $params
	 * @return string|boolean
	 */
	public static function create($params) {

		$username = \Auth::get('username');
		
		
		// 定員オーバーチェック
		$event = self::getByCode('events', $params['event_code']);

		// 下書き
		if (empty($event) || $event['status'] != 1) {
			return "イベントが見つかりませんでした";
		}
		
		if (intval($event['limit']) <= intval($event['application_num'])) {
			return "このイベントは満席です";
		}
		
		// 終了チェック
		if ($event['event_start_datetime'] < date('Y-m-d H:i:s')) {
			return "このイベントは終了しています";
		}
		
		// 既存のデータがないか確認
		$data = \DB::select('*')->from('applications')
					->where('event_code', '=', $params['event_code'])
					->where('username', '=', $username)
					->where('cancel', '=', 0)
					->where('disable', '=', 0)
					->execute()
					->current();
		
		if (!empty($data)) {
			return "既に参加申し込みずみです";
		}

		$params['code'] = self::getNewCode('applications');
		$params['username'] = $username;
		$params['created_at'] = \DB::expr('now()');
		
		\DB::insert('applications')->set($params)->execute();
		
		// 人数を追加する
		\DB::update('events')->set(array(
			'application_num' => \DB::expr('application_num+1')
		))
		->where('code', '=', $params['event_code'])
		->execute();
		
		return true;
	}
	
}
