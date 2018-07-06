<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */


class Controller_Api_Diagnosticchart extends Controller_Apibase
{

    public function action_route($route_id = 1)
    {
        switch ($route_id) {
            case 1:
                return $this->ok(array(
                    'label' => $this->get_route_label($route_id),
                    'yes_route_id' => $this->get_next_route($route_id, 1),
                    'no_route_id' => $this->get_next_route($route_id, 0),
                    'yes_type_id' => '',
                    'no_type_id' => '',
                ));
                break;
            case 2:
                return $this->ok(array(
                    'label' => $this->get_route_label($route_id),
                    'yes_route_id' => $this->get_next_route($route_id, 1),
                    'no_route_id' => $this->get_next_route($route_id, 0),
                    'yes_type_id' => 1,
                    'no_type_id' => 1,
                ));
                break;
        }
    }

    public function action_type($type_id)
    {
        switch ($type_id) {
            case 1:
                return $this->ok(array(
                    'type' => 'A',
                    'color' => '#6bef76',
                    'charactor_image' => '/images/diagnosticchart/A.png',
                    'catch_copy' => '人生100年時代に備えたい',
                    'title' => 'そろそろきちんとやらなきゃさん',
                    'description' => '金融？何のこと？\n自分が何がワカラナイか\nそれすらワカラナイ•••\n金融とか投資とか自分には関係ない？\nでもそろそろお金の整理からはじめたい！',
                ));
                break;
        }
    }

    private function get_route_label($route_id)
    {
        switch ($route_id) {
            case 1:
                return '社会人になって\n5年目以上\nそろそろ、いい大人です！';
                break;
            case 2:
                return '家族や友達とお金の話が\nオープンにできる関係。';
                break;
            case 3:
                return '漠然とした未来への\nもやもや不安がある•••\n私のミライって大丈夫？';
                break;
                break;
            default:
                return '';
                break;
        }
    }

    private function get_next_route($route_id, $yes_no)
    {
        if($route_id == 1) {
            if($yes_no == 1) {
                return 2;
            }
            if($yes_no == 0) {
                return 2;
            }
        }
        return '';
    }
}
