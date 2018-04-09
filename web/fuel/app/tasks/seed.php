<?php
namespace Fuel\Tasks;

class Seed {
    public static function run($model_name=null) {
        if ($model_name) {
            echo "Importing $model_name...";
            include(APPPATH.'seeds'.DS.$model_name.'.php');
            echo "$model_name imported.";
        }
        else {
            echo "Please specify a model name.";
        }

    }

    public static function all() {
        echo "Importing all seeds...";

        \DB::query('SET FOREIGN_KEY_CHECKS = 0;')->execute();
        foreach (\File::read_dir(APPPATH.'seeds') as $file) {
            include(APPPATH.'seeds'.DS.$file);
        }
        \DB::query('SET FOREIGN_KEY_CHECKS = 1;')->execute();

        echo "All seed imported.";
    }

    public static function reset($model_name=null) {
        if ($model_name)
        {
            \DBUtil::truncate_table(\Inflector::pluralize($model_name));

            echo "All records on model $model_name successfully reset.";
        }
        else {
            echo "Please specify a model name.";
        }
    }
}

