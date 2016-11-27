<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/6 0006
 * Time: 14:25
 */

namespace Home\Controller;

use Think\Controller;
use Common\Utils\Http;

class BaseController extends Controller
{

    public function _initialize()
    {
        $this->assign('title', '');
    }

    const GATEWAY = 'http://101.201.220.13:8069/api';
    const GATEWAY_TEST = 'http://192.168.0.114:8069/api';

    public function httpRequest($path, $params = array(), $method = 'get')
    {
        if ($method === 'get') {
            $url = (APP_DEBUG == true ? self::GATEWAY_TEST : self::GATEWAY ).$path;
            //var_dump($url);
            $token = md5($url.json_encode($params));
            if (APP_DEBUG) {
                $result = Http::get($url, $params);
            } else {
                $result = S($token);
                if (!$result) {
                    $result = Http::get($url, $params);
                    S($token, $result, 300);
                }
            }
            
        }
        //var_dump($result);die;
        return json_decode($result, true);
    }
}