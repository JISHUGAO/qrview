<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/6 0006
 * Time: 14:32
 */

namespace Common\Utils;

class Http
{
    public static function get($url, $params = array())
    {
        $url = $url. ($params == array() ? '': '?'.http_build_query($params));
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true) ;
        $output = curl_exec($curl);

        curl_close($curl);
        return $output;
    }
}