<?php

namespace Fuel\Migrations;

class Create_index_application_code_in_application_credit_payments
{
	public function up()
	{
        \DBUtil::create_index(
            'application_credit_payments', // テーブル名
            'application_code', // カラム名
            'idx_application_credit_payments_application_code', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
	}

	public function down()
	{
        \DBUtil::drop_index(
            'application_credit_payments', // テーブル名
            'idx_application_credit_payments_application_code'
        );
	}
}

