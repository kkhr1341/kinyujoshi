<?php

namespace Fuel\Tasks;
use \Model\Testapps;
use \Model\Testusers;
use \Model\Messages;

class Mails {
	
	public static function run() {
		
		$mail = file_get_contents(__DIR__."/test.data");
 		$mail = str_replace("=\n", "", $mail);
 		$mail = str_replace("3D\"", "\"", $mail);

 		// examiner_m17J9U@creco.cards
 		$pattern = "/https:\/\/beta.itunes.apple.com\/v1\/invite\/(.*)\">/";
 		preg_match($pattern, $mail, $matches);
 		
 		print_r($matches);
 		
// 		echo $mail;
		
	}

	public static function examiner() {

		$logs = array();
		
		$source = file_get_contents("php://stdin");
// 		$source = file_get_contents(__DIR__."/test.data");

		file_put_contents("/tmp/0.mail", $source);
		
		$mail = str_replace("\n\n", "\n", $source);
		$mail = str_replace("\n\n", "\n", $mail);
		$mail = str_replace("\n\n", "\n", $mail);
		$mail = str_replace("\n\n", "\n", $mail);
		$mail = str_replace("\n\n", "\n", $mail);

		file_put_contents("/tmp/1.mail", $mail);
		
		$mail = str_replace("=\n", "", $mail);
		file_put_contents("/tmp/2.mail", $mail);
		
		$mail = str_replace("3D\"", "\"", $mail);
		$mail = str_replace("=3D", "=", $mail);
		file_put_contents("/tmp/3.mail", $mail);

		$pattern = "/examiner_(.*)@creco.cards/";
		preg_match($pattern, $mail, $matches);
		$testapps_code = $matches[1];
		
		$logs[] = "";

		$pattern = "/https:\/\/beta.itunes.apple.com\/v1\/invite\/(.*)2003/";
		preg_match($pattern, $mail, $matches);
		$install_url = "https://beta.itunes.apple.com/v1/invite/{$matches[1]}2003";
		
		$to = "akimoto@creco.cards";
		$testapp = Testapps::getByCode('testapps', $testapps_code);
		$developer = Testapps::getById('developers', $testapp['developer_id']);
// 		$testapp_ = print_r($testapp, true);
		
		$limit = 0;
		switch($testapp['limit']) {
			case 1:
				$limit = 10;
				break;
			case 2:
				$limit = 25;
				break;
			case 3:
				$limit = 50;
				break;
			case 4:
				$limit = 100;
				break;
		}
		$message =<<<END
以下の新規テストに関する審査を行ってください。

開発者コード :
{$developer['code']}

会社名 :
{$developer['company']}

氏名 :
{$developer['name']}

メールアドレス :
{$developer['email']}

電話番号 :
{$developer['tel']}

開発者名 :
{$developer['sellerName']}

URL :
{$developer['url']}

テストコード :
{$testapp['code']}
		
アプリ名 :
{$testapp['trackCensoredName']}
		
メインカテゴリ :
{$testapp['category']}
		
アプリ説明 :
{$testapp['description']}
		
テスト内容 :
{$testapp['message']}
		
募集人数 :
{$limit}人

インストールURL :
{$install_url}


審査用URL :
OK :
http://creco.cards/admin/testapp/ok/{$testapp['code']}


NG :
開発者情報不備
http://creco.cards/admin/testapp/ng/{$testapp['code']}/100

アプリ情報不備
http://creco.cards/admin/testapp/ng/{$testapp['code']}/101

画像不備
http://creco.cards/admin/testapp/ng/{$testapp['code']}/102

起動しない
http://creco.cards/admin/testapp/ng/{$testapp['code']}/103

その他
http://creco.cards/admin/testapp/ng/{$testapp['code']}/999
END;

		$urls = array(
				$testapp['artworkUrl60'],
				$testapp['screenshotUrls1'],
				$testapp['screenshotUrls2'],
		);
		
		Testapps::mail_with_urlattach("【要審査】新規テスト依頼がありました。({$testapp['code']})", $message, 'akimoto@creco.cards', $urls);
// 		Testapps::mail($subject, $message, $to);
		Testapps::update($testapps_code, 'install_url', $install_url);
		
		// 審査中に
		Testapps::update($testapps_code, 'status', 1);
		
		// メッセージを送る
		$admin = Messages::getByKey('users', 'admin', 1);
		
		$message =<<<END
SUNDAY LUNCH!運営事務局です。
TestFlightでのテスター追加を確認いたしました。
これより、アプリの審査に入らせて頂きます。

テストコード :
{$testapp['code']}
		
アプリ名 :
{$testapp['trackCensoredName']}
END;
		$params = array(
				'from_user_id' => $admin['id'],
				'user_id' => $developer['user_id'],
				'message' => $message
		);
	
		$code = Messages::save($params, array('toast_message' => '運営事務局からメッセージが届きました'));
		
	}

	public static function tester() {

		$logs = array();
		
		$source = file_get_contents("php://stdin");
		// 		$source = file_get_contents(__DIR__."/test.data");
		
		file_put_contents("/tmp/tester_0.mail", $source);
		
		$mail = str_replace("\n\n", "\n", $source);
		$mail = str_replace("\n\n", "\n", $mail);
		$mail = str_replace("\n\n", "\n", $mail);
		$mail = str_replace("\n\n", "\n", $mail);
		$mail = str_replace("\n\n", "\n", $mail);
		
		file_put_contents("/tmp/tester_1.mail", $mail);
		
		$mail = str_replace("=\n", "", $mail);
		file_put_contents("/tmp/tester_2.mail", $mail);
		
		$mail = str_replace("3D\"", "\"", $mail);
		$mail = str_replace("=3D", "=", $mail);
		file_put_contents("/tmp/tester_3.mail", $mail);
		
		$pattern = "/tester_(.*)@creco.cards/";
		preg_match($pattern, $mail, $matches);
		$testuser_code = $matches[1];
		$testuser = Testusers::getByCode('testusers', $testuser_code);
		
		$logs[] = "testuser_code = {$testuser_code}";
		
		$pattern = "/https:\/\/beta.itunes.apple.com\/v1\/invite\/(.*)2003/";
		preg_match($pattern, $mail, $matches);
		$install_url = "https://beta.itunes.apple.com/v1/invite/{$matches[1]}2003";
		$logs[] = "install_url = {$install_url}";
		
		// install url を保存
		Testusers::update($testuser_code, 'install_url', $install_url);
		
		
		$to = "akimoto@creco.cards";
		$testapp = Testapps::getById('testapps', $testuser['testapp_id']);
		$need_message = false;
		if ($testapp["status"] != 3) {
			// 開始にする
			$need_message = true;
			Testapps::update($testapp['code'], 'status', 3);
		}
		
		// テスターを足す
		Testapps::plus_tester($testapp['code']);
		
		$developer = Testapps::getById('developers', $testapp['developer_id']);
		
		$limit = 0;
		switch($testapp['limit']) {
			case 1:
				$limit = 10;
				break;
			case 2:
				$limit = 25;
				break;
			case 3:
				$limit = 50;
				break;
			case 4:
				$limit = 100;
				break;
		}
		$message =<<<END
テスト依頼が開始されました。
		
開発者コード :
{$developer['code']}
		
会社名 :
{$developer['company']}
		
氏名 :
{$developer['name']}
		
メールアドレス :
{$developer['email']}
		
電話番号 :
{$developer['tel']}
		
開発者名 :
{$developer['sellerName']}
		
URL :
{$developer['url']}
		
テストコード :
{$testapp['code']}
		
アプリ名 :
{$testapp['trackCensoredName']}
		
メインカテゴリ :
{$testapp['category']}
		
アプリ説明 :
{$testapp['description']}
		
テスト内容 :
{$testapp['message']}
		
募集人数 :
{$limit}人
END;
		
		$urls = array(
				$testapp['artworkUrl60'],
				$testapp['screenshotUrls1'],
				$testapp['screenshotUrls2'],
		);
		
		if ($need_message) {
			Testapps::mail_with_urlattach("【テスト依頼開始】テスト依頼が開始されました。({$testapp['code']})", $message, 'akimoto@creco.cards', $urls);
			// メッセージを送る
			$admin = Messages::getByKey('users', 'admin', 1);
			
			$message =<<<END
SUNDAY LUNCH!運営事務局です。
テスト依頼が公開されましたのでご報告いたします。
		
テストコード :
{$testapp['code']}
		
アプリ名 :
{$testapp['trackCensoredName']}

沢山のテスターが集まり、より良いアプリになることをお祈りしております。
END;
			$params = array(
					'from_user_id' => $admin['id'],
					'user_id' => $developer['user_id'],
							'message' => $message
					);
			
			$code = Messages::save($params, array('toast_message' => '運営事務局からメッセージが届きました'));
		}
		
	}
}

/* End of file tasks/robots.php */
