<?php
return array(
    // メンテナンスモードフラグ
    'active' => true,
    // メンテナンス画面をスルーする URL パス
    'through_path_list' => array(
        'admin',
    ),
    // メンテナンス画面をスルーする 接続 IP
    'through_ip_list' => array(
        '172.31.9.195',
        '172.19.0.1',
    ),
);
