<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Files extends Base
{

    public static function lists($username, $mode)
    {

        $datas = \DB::select(\DB::expr('mode, name, type, size, url, thumb, etag'))->from('files')
            ->where('username', '=', $username)
            ->where('mode', '=', $mode)
            ->execute()
            ->as_array();


        $results = [];

        switch ($mode) {
            case 'image':
                foreach ($datas as $key => $file) {
                    $results[] = [
                        'thumb' => $file['thumb'],
                        'url' => $file['url'],
                        'name' => $file['name'],
                        'size' => $file['size'],
                        'id' => $file['etag'],
                    ];
                }
                break;
            case 'file':
                foreach ($datas as $key => $file) {
                    $results[] = [
                        'title' => $file['name'],
                        'name' => $file['name'],
                        'url' => $file['url'],
                        'size' => $file['size'],
                        'id' => $file['etag'],
                    ];
                }
                break;
        }

        return $results;
    }

    public static function create($username, $mode, $etag, $title, $size, $url, $thumb, $name, $type)
    {

        $data = [
            'username' => $username,
            'mode' => $mode,
            'etag' => $etag,
            'title' => $title,
            'size' => $size,
            'url' => $url,
            'thumb' => $thumb,
            'name' => $name,
            'type' => $type,
            'created_at' => \DB::expr('NOW()')
        ];

        $file = \DB::select('id')->from('files')->where('etag', $etag)->execute()->current();
        if (empty($file)) {
            return \DB::insert('files')->set($data)->execute();
        } else {
            unset($data['created_at']);
            return \DB::update('files')->set($data)->where('id', '=', $file['id'])->execute();
        }
    }
}
