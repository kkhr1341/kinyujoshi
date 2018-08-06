<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\DiagnosticChartRoutePaths;
use \Model\DiagnosticChartRoutes;
use \Model\DiagnosticChartRouteTypes;
use \Model\DiagnosticChartTypes;
use \Model\DiagnosticChartTypeUsers;

class Controller_Api_Diagnosticchart extends Controller_Apibase
{

    public function action_route($code = '3nCQWo')
    {
        $route_data = DiagnosticChartRoutes::getDataByCode($code);
        return $this->ok(array(
            'current_route_code' => $route_data['code'],
            'question' => $route_data['question'],
            'yes_route_code' => DiagnosticChartRoutePaths::getNextRouteCode($code, 1),
            'no_route_code' => DiagnosticChartRoutePaths::getNextRouteCode($code, 0),
            'yes_type_code' => DiagnosticChartRouteTypes::getTypeCode($code, 1),
            'no_type_code' => DiagnosticChartRouteTypes::getTypeCode($code, 0),
        ));
    }

    public function action_type()
    {
        $db = \Database_Connection::instance();
        $db->start_transaction();
        try {
            $chart_type = DiagnosticChartTypes::getDataByCode(\Input::post('type_code'));
            $username = \Auth::get('username');
            DiagnosticChartTypeUsers::save($username, \Input::post('type_code'), \Input::post('routes'));
            $db->commit_transaction();
            return $this->ok(array(
                'type' => $chart_type['type'],
                'character_name' => $chart_type['character_name'],
                'type_image' => $chart_type['type_image'],
                'catch_copy' => $chart_type['catch_copy'],
                'description' => $chart_type['description'],
                'character_image' => $chart_type['character_image'],
            ));
        } catch (\Exception $e) {
            $db->rollback_transaction();
            throw $e;
        }
    }
}
