<?php

/**
 * The User Logout Controller.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Logout extends Controller_Base
{
    public function action_index()
    {
        \Auth::logout();
        Response::redirect('/');
    }
}
