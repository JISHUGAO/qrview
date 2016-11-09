<?php
namespace Home\Controller;

class IndexController extends BaseController
{

    private $urls = array(
        'getCompany' => '/jcsj/get_company/head',            //获取公司信息
        'getPicture' => '/jcsj/get_picture/head',            //获取图片
        'getCommodityList' => '/jcsj/get_commodity_list/get_commodity_list', //获得商品详情
        'getSearch' => '/kcgl/get_search',   //商品真伪查询
    );

    public function _initialize()
    {
        parent::_initialize();
        $this->assign('title', '');

        $this->company = session('company');
        if (!$this->company) {
            $companyResult = $this->httpRequest($this->urls['getCompany']);//获取公司信息
            session('company', $companyResult['data'][0]);
            $this->company = $companyResult['data'][0];
        }

        $imgsResult = $this->httpRequest($this->urls['getPicture']);//获取图片
        if ($imgsResult['status'] !== 'yes') {
            $this->error();
        }
        $this->assign('imgs', $imgsResult['data']);
        $this->assign('company', $this->company);
    }

    public function index()
    {

        //$searchResult = $this->httpRequest($this->urls['getSearch']);//获取图片

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
        $productResult = $this->httpRequest($this->urls['getCommodityList']);//获得商品详情
        if ($productResult['status'] !== 'yes') {
            $this->error();
        }
//var_dump($productResult['data'][0]);die;
        $title = '产品展示';
        $this->assign('products', $productResult['data']);

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