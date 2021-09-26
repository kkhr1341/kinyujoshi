<?php

namespace Fuel\Migrations;

class Add_unique_key_coupon_code_to_event_coupons
{
	public function up()
	{
        \DBUtil::create_index(
            'event_coupons', // テーブル名
            array('event_code', 'coupon_code'), // カラム名
            'idx_event_coupons_coupon_code', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
	}

	public function down()
	{
        \DBUtil::drop_index(
            'event_coupons', // テーブル名
            'idx_event_coupons_coupon_code'
        );
	}
}
