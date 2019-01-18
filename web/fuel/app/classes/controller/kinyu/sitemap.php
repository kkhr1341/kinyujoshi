<?php
include 'mock_site_data.php';

class Controller_SiteMap extends Controller_Rssbase
{
    public function action_index()
    {
        $document = new DOMDocument();
        $Site_Map_Data = new Site_Map_Data;
        $site_data = $Site_Map_Data::get_site_data();
        $document->formatOutput = true;
        $cnt = 0;

        while ($cnt < count($site_data)) {

            $loc = $document->createElement('loc');
            $loc->appendChild($document->createTextNode($site_data[$cnt]['loc']));
            $lastMod = $document->createElement('lastmod');
            $lastMod->appendChild($document->createTextNode($site_data[$cnt]['lastmod']));
            $changeFreq = $document->createElement('changefreq');
            $changeFreq->appendChild($document->createTextNode($site_data[$cnt]['changefreq']));
            $priority = $document->createElement('priority');
            $priority->appendChild($document->createTextNode($site_data[$cnt]['priority']));
            $item = $document->createElement('item');
            $item->appendChild($loc);
            $item->appendChild($lastMod);
            $item->appendChild($priority);
            $document->appendChild($item);
            $document->saveXML();
            $cnt++;

        }

        // コードの生成
        $response = new Response();

        // XML を出力します
        $response->set_header('Content-Type', "xml; charset=utf-8");

        // キャッシュをなしにします
        $response->set_header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->set_header('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
        $response->set_header('Pragma', 'no-cache');

        $response->body($document->savaXML());
        return $response;
    }
}
