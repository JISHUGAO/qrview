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

    public function httpRequest($path, $params, $method = 'get')
    {
        if ($method === 'get') {
            $result = Http::get(self::GATEWAY.$path, $params);
        }
        //var_dump($result);die;
        return json_decode($result, true);
    }
}