<?php
namespace Home\Controller;

class IndexController extends BaseController
{

    public function _initialize()
    {
        parent::_initialize();
        $this->assign('title', '');

        $this->company = session('company');
        if (!$this->company) {
            $companyResult = $this->httpRequest('/jcsj/get_company/head');//获取公司信息
            session('company', $companyResult['data'][0]);
            $this->company = $companyResult['data'][0];
        }

        $this->assign('company', $this->company);
    }

    public function index()
    {
        $imgsResult = $this->httpRequest('/jcsj/get_picture/head');//获取图片
        if ($imgsResult['status'] !== 'yes') {
            $this->error();
        }

        $this->assign('imgs', $imgsResult['data']);
        $this->display();
    }

    /**
     * 企业介绍
     */
    public function introduction()
    {
        $title = '企业介绍';
        $this->assign('title', $title);
        $this->display();
    }

    /**
     * 产品展示
     */
    public function show_product()
    {
        $title = '产品展示';
        $this->assign('title', $title);
        $this->display('show');
    }

    /**
     * 联系我们
     */
    public function about_us()
    {

        $title = '联系我们';
        $this->assign('info', $this->company);
        $this->assign('title', $title);
        $this->display();
    }

    /**
     * 追溯
     */
    public function trace()
    {

        $this->display();
    }
}