<?php

use \Model\Blogs;

use \FeedWriter\RSS2;

use Aws\S3\S3Client;
use Aws\Credentials\Credentials;

//use \Model\Files;

class Controller_Kinyu_Rss extends Controller_Rssbase
{

    public function action_index()
    {
        $feed = new RSS2;
        // チャンネル情報の登録
        $feed->setTitle( "きんゆう女子。- 金融ワカラナイ女子のためのコミュニティ" ) ;			// チャンネル名
        $feed->setLink( \Uri::base() ) ;		// URLアドレス
        $feed->setDescription( "きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！" ) ;	// チャンネル紹介テキスト
//        $feed->setImage( \Uri::base() , "きんゆう女子。" ,  \Uri::base() . "images/kinyu-logo-top.png" ) ;	// ロゴなどの画像
        $feed->setDate( date( DATE_RSS , time() ) ) ;	// フィードの更新時刻
        $feed->setChannelElement( "language" , "ja-JP" ) ;	// 言語
//        $feed->setChannelElement( "pubDate" , date( \DATE_RSS , strtotime("2014-11-23 15:30") ) ) ;	// フィードの変更時刻
        $feed->setChannelElement( "category" , "Blog" ) ;

        $blogs = Blogs::lists(1, 20);
        foreach($blogs as $blog) {

            $item = $feed->createNewItem() ;
            $item->setTitle( $blog['title']) ;	// タイトル
            $item->setLink( \Uri::base() . 'report/' . $blog['code'] );
            $item->setDescription( $blog['description'] );
            $item->setDate( strtotime($blog['open_date']) + (60 * 60));

            // サムネイルが存在するか確認
            $thumbnail = $this->toThumbnail($blog['main_image']);
            if ($key = $this->getS3Key($thumbnail)) {
                $metas = $this->getImageMeta($key);
                $item->addEnclosure($thumbnail, $metas['ContentLength'], $metas['ContentType']);
            }
//            $item->setAuthor( "あらゆ" , "info@syncer.jp" ) ;	// 著者の連絡先(E-mail)
            $item->setId( \Uri::base() . 'report/' . $blog['code'] , true ) ;	// 一意のID(第1引数にURLアドレス、第2引数にtrueで通常は大丈夫)
            $feed->addItem( $item ) ;
        }
        
        // コードの生成
        $xml = $feed->generateFeed();

        $response = new Response();

        // XML を出力します
        $response->set_header('Content-Type', $feed->getMIMEType() . "; charset=utf-8");

        // キャッシュをなしにします
        $response->set_header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->set_header('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
        $response->set_header('Pragma', 'no-cache');

        $response->body($xml);
        return $response;
    }

    private function toThumbnail($url)
    {
        return preg_replace("/(.+)\/(.+\.jpg|.+\.jpeg|.+\.JPG|.+\.png|.+\.gif)$/", "$1/thumb_$2", $url);
    }

    private function getS3Key($url)
    {
        preg_match('/(.+)\/stock\/(.+)/', $url, $matches);
        if (isset($matches[2])) {
            return 'stock/' . $matches[2];
        }
        return false;
    }

    private function getImageMeta($key)
    {
        \Config::load('s3', true);

        $credentials = new Credentials(\Config::get('s3.access_key'), \Config::get('s3.secret_key'));
        $bucket = \Config::get('s3.bucket');

        $params = array(
            'signature' => 'v4',
            'credentials' => $credentials,
            'region' => 'ap-northeast-1',
            'version' => "latest",
        );
        if (\Config::get('s3.endpoint')) {
            $params['endpoint'] = \Config::get('s3.endpoint');
            $params['use_path_style_endpoint'] = true;
        }
        $s3 = S3Client::factory($params);

        $response = $s3->getObject(array(
            'Bucket' => $bucket,
            'Key'    => $key
        ));

        return array(
            'ContentType' => $response->get('ContentType'),
            'ContentLength' => $response->get('ContentLength'),
        );
    }
}