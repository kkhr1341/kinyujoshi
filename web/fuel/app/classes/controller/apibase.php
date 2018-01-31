<?php
/**
 * The Base Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Profiles;

class Controller_Apibase extends Controller_Rest
{


//    public function before()
//    {
//        set_exception_handler(function ($e) {
//            $this->error($e->getMessage());
//        });
//    }

//    public function after($response)
//    {
//        $response = parent::after($response);
//        return $response;
//    }

    /**
     * APIの正常系レスポンスを返す
     */
    public function ok($DATA = null, $MESSAGES = null)
    {

        $response = array(
            'api_status' => "ok",
            'data' => $DATA
        );

        echo json_encode($response);
        exit();
    }

    /**
     * APIのエラーレスポンスを返す
     */
    public function error($MESSAGES)
    {
        $this->format = 'json';
        $json = array(
            'api_status' => 'error',
            'message' => $MESSAGES,
        );
        return $this->response($json,200);
    }

}
