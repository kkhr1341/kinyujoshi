<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");
use \Model\Projects;
use \Model\Courses;
use \Model\Addresses;
use WebPay\WebPay;

class Wp extends Base {

	private $public_key = "test_public_cwcfCu1wVcY77uIdAN0BPfXL";
	private $secret_key = "test_secret_7s55Bs7jMdnp2cjeJL6Fv8vh";
	private $webpay;
	
	public function __construct() {
		$this->webpay = new WebPay($this->secret_key);
	}

	public function all($username) {

		$customer = self::get_customer($username);
		$all = $this->webpay->charge->all([
				'customer' => $customer['customer_id']
		]);
		
		$charges = [];
		foreach($all->data as $key => $charge) {
			$charges[] = [
				'id' => $charge->id,
				'livemode' => $charge->livemode,
				'amount' => $charge->amount,
				'created' => date('Y/m/d H:i:s', $charge->created),
				'currency' => $charge->currency,
				'paid' => $charge->paid,
				'captured' => $charge->captured,
				'refunded' => $charge->refunded,
				'amount_refunded' => $charge->amount_refunded,
				'customer' => $charge->customer,
				'recursion' => $charge->recursion,
				'shop' => $charge->shop,
				'description' => $charge->description,
				'failure_message' => $charge->failure_message,
				'expire_time' => date('Y/m/d H:i:s', $charge->expire_time),
				'card' => [
						'exp_month' => $charge->card->exp_month,
						'exp_year' => $charge->card->exp_year,
						'fingerprint' => $charge->card->fingerprint,
						'last4' => $charge->card->last4,
						'type' => $charge->card->type,
						'cvc_check' => $charge->card->cvc_check,
						'exp_month' => $charge->card->exp_month,
						'name' => $charge->card->name,
						'country' => $charge->card->country,
				]
			];
		}
		
		return $charges;
	}
	
	public function course_buy($username, $project_code, $course_code, $address_code) {

		$customer = self::get_customer($username);
		if (!$customer) {
			return false;
		}
		
		$project = Projects::getByCode('projects', $project_code);
		$course = Courses::getByCode('courses', $course_code);
		$address = Addresses::getByCode('addresses', $address_code);
		
		$price = number_format($course['price']);
		$chage_data = [
			"amount" => $course['price'],
			"currency" => "jpy",
			"customer" => $customer['customer_id'],
			"description" => "{$project['title']} ({$price}円コース)",
			"capture" => false,		// 仮売上
			"expire_days" => 45
		];
		
		$charge = $this->webpay->charge->create($chage_data);
		
		$payment_code = self::getNewCode('payments', 10);
		$payment_data = [
			'code' => $payment_code,
			'username' => $username,
			'project_code' => $project_code,
			'course_code' => $course_code,
			'address_code' => $address_code,
			'webpay_id' => $charge->id,
			'livemode' => $charge->livemode,
			'amount' => $charge->amount,
			'card_exp_year' => $charge->card->exp_year,
			'card_exp_month' => $charge->card->exp_month,
			'card_fingerprint' => $charge->card->fingerprint,
			'card_name' => $charge->card->name,
			'card_country' => $charge->card->country,
			'card_type' => $charge->card->type,
			'card_cvc_check' => $charge->card->cvc_check,
			'card_last4' => $charge->card->last4,
			'created' => date('Y-m-d H:i:s', $charge->created),
			'currency' => $charge->currency,
			'paid' => $charge->paid,
			'captured' => $charge->captured,
			'refunded' => $charge->refunded,
			'description' => $charge->description,
			'failure_message' => $charge->failure_message,
			'expire_time' => date('Y-m-d H:i:s', $charge->expire_time),
			'zip' => $address['zip'],
			'address' => $address['address'],
			'name' => $address['name'],
			'kana' => $address['kana'],
			'tel' => $address['tel'],
			'created_at' => \DB::expr('now()'),
		];
		
		\DB::insert('payments')->set($payment_data)->execute();
		
		// コースの申込を増やす
		\DB::update('courses')
					->set([
						'num_of_supporters' => \DB::expr('num_of_supporters+1')
					])
					->where('code', '=', $course_code)
					->execute();
		
		// プロジェクトの情報をアップさせる
		$price = $course['price'];
		
		\DB::update('projects')
					->set([
						'archive_amount' => \DB::expr("archive_amount+{$price}"),
						'num_of_supporters' => \DB::expr('num_of_supporters+1')
					])
					->where('code', '=', $project_code)
					->execute();
		
		return true;
	}
	
	public function set_card($username, $wptoken) {
	
		try {

			$customer = self::get_customer($username);
			if (!$customer) {
				return false;
			}
				
			$response = $this->webpay->customer->update(array(
					"id" => $customer['customer_id'],
					"card" => $wptoken
			));
			
			return $response;
			
				
		} catch (\WebPay\ErrorResponse\ErrorResponseException $e) {
			$error = $e->data->error;
			switch ($error->causedBy) {
				case 'buyer':
					// カードエラーなど、購入者に原因がある
					// エラーメッセージをそのまま表示するのがわかりやすい
					break;
				case 'insufficient':
					// 実装ミスに起因する
					break;
				case 'missing':
					// リクエスト対象のオブジェクトが存在しない
					break;
				case 'service':
					// WebPayに起因するエラー
					break;
				default:
					// 未知のエラー
					break;
			}
			return false;
		} catch (\WebPay\ApiException $e) {
			// APIからのレスポンスが受け取れない場合。接続エラーなど
			return false;
		} catch (\Exception $e) {
			// WebPayとは関係ない例外の場合
			return false;
		}
	
		return true;
	
	}
	
	
	public function create_user($email, $username) {
		
		try {
			$response = $this->webpay->customer->create(array(
					'email' => $email,
					'description' => $username
			));
			
			\DB::insert('customers')->set(array(
				'username' => $username,
				'customer_id' => $response->id,
				'description' => $response->description,
				'email' => $response->email,
				'created_at' => \DB::expr('now()')
			))->execute();
			
		} catch (\WebPay\ErrorResponse\ErrorResponseException $e) {
			$error = $e->data->error;
			switch ($error->causedBy) {
				case 'buyer':
					// カードエラーなど、購入者に原因がある
					// エラーメッセージをそのまま表示するのがわかりやすい
					break;
				case 'insufficient':
					// 実装ミスに起因する
					break;
				case 'missing':
					// リクエスト対象のオブジェクトが存在しない
					break;
				case 'service':
					// WebPayに起因するエラー
					break;
				default:
					// 未知のエラー
					break;
			}
			return false;
		} catch (\WebPay\ApiException $e) {
			// APIからのレスポンスが受け取れない場合。接続エラーなど
			return false;
		} catch (\Exception $e) {
			// WebPayとは関係ない例外の場合
			return false;
		}
		
		return true;
		
	}
	
	
	public static function get_customer($username) {
		
		return \DB::select('*')->from('customers')->where('disable', '=', 0)->where('username', '=', $username)->execute()->current();
		
	}

	public function get_wpcustomer($username) {
	
		try {
			
			$customer = self::get_customer($username);
			if (!$customer) {
				return false;
			}
			
			$response = $this->webpay->customer->retrieve($customer['customer_id']);
			
			return $response;
				
		} catch (\WebPay\ErrorResponse\ErrorResponseException $e) {
			$error = $e->data->error;
			switch ($error->causedBy) {
				case 'buyer':
					// カードエラーなど、購入者に原因がある
					// エラーメッセージをそのまま表示するのがわかりやすい
					break;
				case 'insufficient':
					// 実装ミスに起因する
					break;
				case 'missing':
					// リクエスト対象のオブジェクトが存在しない
					break;
				case 'service':
					// WebPayに起因するエラー
					break;
				default:
					// 未知のエラー
					break;
			}
			return false;
		} catch (\WebPay\ApiException $e) {
			// APIからのレスポンスが受け取れない場合。接続エラーなど
			return false;
		} catch (\Exception $e) {
			// WebPayとは関係ない例外の場合
			return false;
		}
	
	
	}
}
