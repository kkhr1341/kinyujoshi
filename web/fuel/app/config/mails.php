<?php
return array(
    'templates' => array(
        1 => array(
            'name' => '会員登録完了メール（自動返信）',
            'view' => 'regist/body',
            'params' => array(
                'name' => 'テスト　太郎'
            )
        ),
        2 => array(
            'name' => '会員登録完了メール（スタッフ宛て）',
            'view' => 'regist/return',
            'params' => array(
                'name' => 'テスト　太郎'
            )
        ),
        3 => array(
            'name' => '退会完了メール（自動返信）',
            'view' => 'withdrawal/body',
            'params' => array()
        ),
        4 => array(
            'name' => '退会完了メール（スタッフ宛て）',
            'view' => 'withdrawal/return',
            'params' => array(
                'email' => 'taro@test.com'
            )
        ),
        5 => array(
            'name' => 'きんじょパスポート登録完了（スタッフ宛て）',
            'view' => 'passport/return',
            'params' => array(
                'name' => 'てすと　太郎',
                'message' => 'テストメッセージが入りますテストメッセージが入ります',
            )
        ),
        6 => array(
            'name' => '女子会申し込み完了メール（自動返信）キャンセル日時の指定あり',
            'view' => 'joshikai/body',
            'params' => array(
                'name' => 'てすと　太郎',
                'event' => array(
                    'incur_cancellation_fee_date' => '2018-12-20'
                )
            )
        ),
        7 => array(
            'name' => '女子会申し込み完了メール（自動返信）キャンセル日時の指定なし',
            'view' => 'joshikai/body',
            'params' => array(
                'name' => 'てすと　太郎',
                'event' => array(
                    'incur_cancellation_fee_date' => '2018-12-20'
                )
            )
        ),
        8 => array(
            'name' => '女子会キャンセルメール（スタッフ宛て）',
            'view' => 'joshikai/cancel',
            'params' => array(
                'name' => 'てすと　太郎',
            )
        ),
        9 => array(
            'name' => 'メールアドレス変更完了メール（スタッフ宛て）',
            'view' => 'email_change_notify/return',
            'params' => array(
                'username' => 'test',
                'before_email' => 'user1@test.com',
                'after_email' => 'user2@test.com',
            )
        ),
        10 => array(
            'name' => 'コメント登録完了メール（スタッフ宛て）',
            'view' => 'comment/body',
            'params' => array(
                'message' => 'これはテストメッセージですこれはテストメッセージです'
            )
        ),
        11 => array(
            'name' => 'ビジネスフォーム問い合わせ完了メール（自動返信）',
            'view' => 'business_inquiry/body',
            'params' => array()
        ),
        12 => array(
            'name' => 'ビジネスフォーム問い合わせ完了メール（スタッフ宛て）',
            'view' => 'business_inquiry/return',
            'params' => array(
                'category_name' => '座談会・アンケートを実施したい',
                'company' => '株式会社TOE THE LINE',
                'department' => '部署',
                'name' => 'テスト　太郎',
                'tel' => '03-1111-2222',
                'email' => 'user@test.com',
                'transmission' => 'インターネット検索',
                'appointment_date1' => '2019-01-01',
                'appointment_date2' => '2019-01-02',
                'appointment_date3' => '2019-01-03',
                'message' => "これはテストメッセージです\nこれはテストメッセージです",
            )
        ),
    )
);