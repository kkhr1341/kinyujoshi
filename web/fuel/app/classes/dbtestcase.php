<?php
/**
 * 電子書籍『はじめてのフレームワークとしてのFuelPHP 第2版』の一部です。
 *
 * @version    1.0
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2014 Kenji Suzuki
 * @link       https://github.com/kenjis/fuelphp1st-2nd
 */


abstract class DbTestCase extends TestCase
{
    // フィクスチャデータ
    protected $tables = array(
        // テーブル名 => ファイル名
    );

    protected function setUp()
    {
        parent::setUp();

        if ( ! empty($this->tables))
        {
            $this->dbfixt($this->tables);
        }
    }

    protected function dbfixt($tables)
    {
        $tables = is_string($tables) ? func_get_args() : $tables;

        DB::query('SET FOREIGN_KEY_CHECKS = 0;')->execute();
        foreach ($tables as $table => $file)
        {
            $fixt_name = $file . '_fixt';
            $this->$fixt_name = DbFixture::load($table, $file);
        }
        DB::query('SET FOREIGN_KEY_CHECKS = 1;')->execute();
    }
}
