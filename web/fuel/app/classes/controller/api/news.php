<?php

use \Model\News;

class Controller_Api_News extends Controller_Apibase
{
    public function action_create()
    {
        if (!Auth::has_access('news.admin')) {
            exit();
        }
        return $this->ok(News::create(\Input::all()));
    }

    public function action_save()
    {
        if (!Auth::has_access('news.admin')) {
            exit();
        }
        return $this->ok(News::save(\Input::all()));
    }

    public function action_delete()
    {
        if (!Auth::has_access('news.admin')) {
            exit();
        }
        return $this->ok(News::delete(\Input::all()));
    }
}
