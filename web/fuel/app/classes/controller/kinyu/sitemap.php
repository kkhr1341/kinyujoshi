<?php
//include 'mock_site_data.php';
class Controller_Kinyu_SiteMap extends Controller_Rssbase
{
    public function action_index()
    {
        $cnt = 0;
        $today = date('Y-m-d');
        $site_data = array(
             array(
                'loc'=>'https://kinyu-joshi.jp/',
                'lastmod'=>$today,
                 'changefreq'=>'always',
                 'priority'=>1
             ),
             array(
                 'loc'=>'https://kinyu-joshi.jp/news',
                 'lastmod'=>$today,
                 'changefreq'=>'hourly',
                 'priority'=>0.9
             ),
             array(
                 'loc'=>'https://kinyu-joshi.jp/joshikai',
                 'lastmod'=>$today,
                 'changefreq'=>'always',
                 'priority'=>0.9
             ),
             array(
                 'loc'=>'https://kinyu-joshi.jp/report',
                 'lastmod'=>$today,
                 'changefreq'=>'hourly',
                 'priority'=>0.9
             ),
             array(
                 'loc'=>'https://kinyu-joshi.jp/kinyu_sanpo',
                 'lastmod'=>$today,
                 'changefreq'=>'weekly',
                 'priority'=>0.5
             ),
             array(
                 'loc'=>'https://kinyu-joshi.jp/myway',
                 'lastmod'=>$today,
                 'changefreq'=>'monthly',
                 'priority'=>0.5
             ),
             array(
                 'loc'=>'https://kinyu-joshi.jp/about',
                 'lastmod'=>$today,
                 'changefreq'=>'monthly',
                 'priority'=>0.5
             ),
            array(
                 'loc'=>'https://kinyu-joshi.jp/kinjo_check',
                 'lastmod'=>$today,
                 'changefreq'=>'monthly',
                 'priority'=>0.5
             ),
             array(
                 'loc'=>'https://www.asahi.com/and_w/kinyujoshi_list.html',
                 'lastmod'=>$today,
                'changefreq'=>'monthly',
                 'priority'=>0.5
             )
        
         );

        $rootNode = new SimpleXMLElement( "<?xml version='1.0' encoding='UTF8' standalone='yes'?><items></items>" );

        // ノードの追加
        while($cnt < count($site_data)) {
            $itemNode = $rootNode->addChild('item');
            $itemNode->addChild( 'loc', $site_data[$cnt]['loc']);
            $itemNode->addChild( 'lastmod', $site_data[$cnt]['lastmod']);
            $itemNode->addChild( 'changefreq', $site_data[$cnt]['changefreq']);
            $itemNode->addChild( 'prioriry', $site_data[$cnt]['priority']);
            $cnt++;
        }

        // 作ったxmlツリーを出力する
        $dom = new DOMDocument( '1.0' );
        $dom->loadXML( $rootNode->asXML() );
        $dom->formatOutput = true;
        $response = new Response();
        $response->set_header('Content-Type', "xml; charset=utf-8");
        echo $dom->saveXML();
        return $response;


    }
}
