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
        '192.168.0.5',
        '192.168.0.10',
    ),
);
