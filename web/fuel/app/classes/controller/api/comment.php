<?php

use \Model\Comment;

class Controller_Api_Comment extends Controller_Base
{

    public function action_create()
    {
        $this->ok(Comment::create(\Input::all()));
    }
}
