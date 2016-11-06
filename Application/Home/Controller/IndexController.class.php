<?php
namespace Home\Controller;

class IndexController extends BaseController
{
    public function index()
    {
        $reuslt = $this->httpRequest('/jcsj/get_picture/type');
        var_dump($reuslt);
        $this->display();
    }
}