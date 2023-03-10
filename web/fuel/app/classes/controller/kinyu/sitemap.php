<?php
//include 'mock_site_data.php';

use \Model\Blogs;
use \Model\Events;

class Controller_Kinyu_SiteMap extends Controller_Rssbase
{
    public function action_index()
    {
        $cnt = 0;
        $today = date('Y-m-d');
        $site_data = array(
             array(
                'loc'=>\Uri::base(false),
                'lastmod'=>$today,
                 'changefreq'=>'always',
                 'priority'=>1
             ),
            array(
                'loc'=>\Uri::base(false) . 'business',
                'lastmod'=>$today,
                'changefreq'=>'hourly',
                'priority'=>0.5
            ),
             array(
                 'loc'=>\Uri::base(false) . 'news',
                 'lastmod'=>$today,
                 'changefreq'=>'hourly',
                 'priority'=>0.9
             ),
             array(
                 'loc'=>\Uri::base(false) . 'joshikai',
                 'lastmod'=>$today,
                 'changefreq'=>'always',
                 'priority'=>0.9
             ),
             array(
                 'loc'=>\Uri::base(false) . 'report',
                 'lastmod'=>$today,
                 'changefreq'=>'hourly',
                 'priority'=>0.9
             ),
             array(
                 'loc'=>\Uri::base(false) . 'kinyu_sanpo',
                 'lastmod'=>$today,
                 'changefreq'=>'weekly',
                 'priority'=>0.5
             ),
             array(
                 'loc'=>\Uri::base(false) . 'myway',
                 'lastmod'=>$today,
                 'changefreq'=>'monthly',
                 'priority'=>0.5
             ),
             array(
                 'loc'=>\Uri::base(false) . 'about',
                 'lastmod'=>$today,
                 'changefreq'=>'monthly',
                 'priority'=>0.5
             ),
            array(
                 'loc'=>\Uri::base(false) . 'kinjo_check',
                 'lastmod'=>$today,
                 'changefreq'=>'monthly',
                 'priority'=>0.5
             ),
            array(
                'loc'=>\Uri::base(false) . 'faq',
                'lastmod'=>$today,
                'changefreq'=>'monthly',
                'priority'=>0.5
            ),
            array(
                'loc'=>\Uri::base(false) . 'contact',
                'lastmod'=>$today,
                'changefreq'=>'monthly',
                'priority'=>0.5
            ),
            array(
                'loc'=>\Uri::base(false) . 'service',
                'lastmod'=>$today,
                'changefreq'=>'monthly',
                'priority'=>0.5
            ),
            array(
                'loc'=>\Uri::base(false) . 'joshikai_policy',
                'lastmod'=>$today,
                'changefreq'=>'monthly',
                'priority'=>0.5
            ),
            array(
                'loc'=>\Uri::base(false) . 'privacy',
                'lastmod'=>$today,
                'changefreq'=>'monthly',
                'priority'=>0.5
            ),
            array(
                'loc'=>\Uri::base(false) . 'link_policy',
                'lastmod'=>$today,
                'changefreq'=>'monthly',
                'priority'=>0.5
            ),
            array(
                'loc'=>\Uri::base(false) . 'legal',
                'lastmod'=>$today,
                'changefreq'=>'monthly',
                'priority'=>0.5
            ),
            array(
                'loc'=>\Uri::base(false) . 'company',
                'lastmod'=>$today,
                'changefreq'=>'monthly',
                'priority'=>0.5
            ),
         );

        // ????????????
        $blogs = Blogs::lists(1, null, 1);
        foreach ($blogs as $blog) {
            array_push($site_data, array(
                'loc'=>'https://kinyu-joshi.jp/report/' . $blog['code'],
                'lastmod'=>date_format(date_create($blog['updated_at']), 'Y-m-d'),
                'changefreq'=>'always',
                'priority'=>0.8
            ));
        }

        // ?????????
        $events = Events::lists(1, null, null, null, "desc", 1, null, 1);
        foreach ($events as $event) {
            array_push($site_data, array(
                'loc'=>'https://kinyu-joshi.jp/joshikai/' . $event['code'],
                'lastmod'=>date_format(date_create($event['updated_at']), 'Y-m-d'),
                'changefreq'=>'always',
                'priority'=>0.8
            ));
        }

        $rootNode = new SimpleXMLElement( "<?xml version='1.0' encoding='UTF8' standalone='yes'?><urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'></urlset>" );

        // ??????????????????
        while($cnt < count($site_data)) {
            $itemNode = $rootNode->addChild('url');
            $itemNode->addChild( 'loc', $site_data[$cnt]['loc']);
            $itemNode->addChild( 'lastmod', $site_data[$cnt]['lastmod']);
            $itemNode->addChild( 'changefreq', $site_data[$cnt]['changefreq']);
            $itemNode->addChild( 'priority', $site_data[$cnt]['priority']);
            $cnt++;
        }

        // ?????????xml????????????????????????
        $dom = new DOMDocument( '1.0' );
        $dom->loadXML( $rootNode->asXML() );
        $dom->formatOutput = true;
        $response = new Response();
        $response->set_header('Content-Type', "xml; charset=utf-8");
        echo $dom->saveXML();
        return $response;
    }
}
