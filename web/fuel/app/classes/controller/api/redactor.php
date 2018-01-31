<?php

use Aws\S3\S3Client;
use Aws\Credentials\Credentials;

use \Model\Files;

class Controller_Api_Redactor extends Controller_Apibase
{
    private function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    }

    private function upload($mode)
    {

        \Config::load('s3', true);

        $file_name = @$_FILES['file']['name'];
        $size = $this->formatBytes(@$_FILES['file']['size']);
        $username = Auth::get('username');
        $update = date("Ymd");
        $updatedev = date("YmdHis");

        try {

            if ($mode == 'image') {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime_type = $finfo->file($_FILES['file']['tmp_name']);
                //出力
                switch ($mime_type) {
                    case 'image/gif':
                    case 'image/jpeg':
                    case 'image/x-png':
                    case 'image/png':
                        break;
                    default:
                        echo json_encode(array('error' => true, 'message' => 'PNG/JPEG/GIFのみアップロード可能です'));
                        exit();
                        break;
                }
            }
            $credentials = new Credentials(\Config::get('s3.access_key'), \Config::get('s3.secret_key'));

            $s3 = S3Client::factory(array(
                'signature' => 'v4',
                'credentials' => $credentials,
                'region' => 'ap-northeast-1',
                'endpoint' => \Config::get('s3.endpoint'),
                'version' => "latest",
                'use_path_style_endpoint' => true,
                //'version' => '2006-03-01'
            ));
            $res = $s3->putObject(array(
                'Bucket' => \Config::get('s3.bucket'),
                'Key' => "stock/{$username}/images/{$updatedev}{$file_name}",
                'Body' => fopen($_FILES['file']['tmp_name'], 'r'),
                'ACL' => 'public-read',
                'ContentType' => $_FILES['file']['type'],
            ));

            $thumb = "";
            switch ($mode) {
                case "image":
                    // サムネイルを作る
                    $image = new Imagick($_FILES['file']['tmp_name']);
                    $tmp_file_path = "/tmp/thumb_{$file_name}";

                    $thumbImg = clone $image;
                    $thumbImg->thumbnailImage(300, 0);
                    $thumbImg->writeImage($tmp_file_path);


                    $thumbres = $s3->putObject(array(
                        'Bucket' => \Config::get('s3.bucket'),
                        'Key' => "stock/{$username}/images/thumb_{$updatedev}{$file_name}",
                        'Body' => fopen($tmp_file_path, 'r'),
                        'ACL' => 'public-read',
                        'ContentType' => $_FILES['file']['type'],
                    ));

                    $thumb = $thumbres->get('ObjectURL');
                    $image->clear();
                    $thumbImg->clear();
                    break;
                default:
                    break;
            }
            $url = $res->get('ObjectURL');
            if (\Config::get('s3.asset_path')) {
                $url = preg_replace("/^http:\/\/(.+?)\/(.+)/", \Config::get('s3.asset_path') . "/$2", $url);
            }

            $etag = $res->get('ETag');
            $etag = str_replace("\"", "", $etag);
            $title = "";

            Files::create($username, $mode, $etag, $title, $size, $url, $thumb, $file_name, $_FILES['file']['type']);

        } catch (S3Exception $e) {
            return $this->error('アップロード中に問題が発生しました。');
//            //エラー処理
//            echo json_encode(array('error' => true, 'message' => 'アップロード中に問題が発生しました。'));
//            exit();
        }

        $array = array(
            'url' => $url,
            'id' => $etag,
            'name' => $file_name
        );

        return $this->ok($array);
    }

    public function action_list($mode)
    {

        if (!Auth::check()) {
            exit();
        }


        $username = Auth::get('username');
        $files = Files::lists($username, $mode);

        return $this->ok($files);
    }

    public function action_upload($mode)
    {

        if (!Auth::check()) {
            exit();
        }

        $this->upload($mode);
    }
}
