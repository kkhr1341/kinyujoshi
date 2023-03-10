<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
 
    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }
 
    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        
        $conn_param = $this->parse_url_param($conn->httpRequest->getRequestTarget());
        //個人チャットを開いたときの処理
        if ($conn_param["mode"] == "private") {
            //ログイン状態を確認してクライアントに送信
            $this->login_status_send($conn, $conn_param, 'online');
        }
        
        echo "New connection! ({$conn->resourceId})\n";
    }
 
    public function onMessage(ConnectionInterface $from, $msg) {

        $session = $from->Session;
        var_dump("ooooooooooooooooooooooo");
        var_dump($session->get("username"));
        var_dump("nyoo");

        $from_param = $this->parse_url_param($from->httpRequest->getRequestTarget());
        
        if ($from_param["mode"] == "room") {
            foreach ($this->clients as $client) {
                //同じルームの人対象に送信。
                $client_param = $this->parse_url_param($client->httpRequest->getRequestTarget());
                if ($from_param["room"] === $client_param["room"]) {
                    $client->send($msg);
                }
            }
        }
        
        if ($from_param["mode"] == "private") {
          
            $send_comp_flag = 0;
            foreach ($this->clients as $client) {
                //対象を指定
                $client_param = $this->parse_url_param($client->httpRequest->getRequestTarget());
                if ($from_param["target"] === $client_param["myself"]) {
                    if ($from_param["myself"] === $client_param["target"]) {
                        $client->send($msg);
                        $send_comp_flag = 1;
                    }
                }
            }
            if ($send_comp_flag) {
                foreach ($this->clients as $client) {
                    //自分に送信
                    $client_param = $this->parse_url_param($client->httpRequest->getRequestTarget());
                    if ($from_param["target"] === $client_param["target"]) {
                        if ($from_param["myself"] === $client_param["myself"]) {
                            $client->send($msg);
                        }
                    }
                }
            }
            if ($send_comp_flag == 0) {
                $error["type"] = 'error';
                $error["code"] = '1';
                $error["detail"] = '相手がエラーのため送信に失敗しました';
                $from->send(json_encode($error));
            }
        }
    }
 
    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $conn_param = $this->parse_url_param($conn->httpRequest->getRequestTarget());

        if ($conn_param["mode"] == "private") {// 個人チャットの場合、退室を相手に伝える
          //ログイン状態を確認してクライアントに送信
            $this->login_status_send($conn, $conn_param, 'offline');
        }
        
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }
 
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn_param = $this->parse_url_param($conn->httpRequest->getRequestTarget());

        if ($conn_param["mode"] == "private") {// 個人チャットの場合、退室を相手に伝える
          //ログイン状態を確認してクライアントに送信
            $this->login_status_send($conn, $conn_param, 'offline');
        }
        $conn->close();
    }
    
    public function login_status_send(&$conn, $connect_param, $send_param) {
      foreach ($this->clients as $client) {
          $client_param = $this->parse_url_param($client->httpRequest->getRequestTarget());
          if ($connect_param["target"] === $client_param["myself"]) {
              if ($connect_param["myself"] === $client_param["target"]) {//互いにオンラインである
                
                  $msg["type"] = "info";
                  $msg["status"] = $send_param;
                  //既存入室者に、相手がオンラインになったことを伝える
                  $client->send(json_encode($msg));
                  //新規入室者に、相手が既にオンラインであることを伝える
                  $conn->send(json_encode($msg));
              }
          }
      }
    }
    
    public function parse_url_param($string) {
        $query = str_replace("/?", "", $string);
        parse_str($query, $return_param);
        return $return_param;
    }
}