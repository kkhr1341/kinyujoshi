<?php
class Site_Map_Data {

    public function get_site_data() {

        $today = date('Y-m-d');
        return $site_data = array(
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
    } 
}
?>
