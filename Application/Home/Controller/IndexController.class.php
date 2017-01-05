<?php
namespace Home\Controller;

class IndexController extends BaseController
{
    protected $company;

    private $urls = array(
        'getCompany' => '/jcsj/get_company/head',            //获取公司信息
        'getPicture' => '/jcsj/get_picture',            //获取图片
        'getCommodityList' => '/jcsj/get_commodity_list/get_commodity_list', //获得商品详情
        'getSearch' => '/kcgl/get_search',   //商品真伪查询

        'getBatchList' => '/kcgl/get_batch_list', //商品批次
        'getMaterialBatch' => '/kcgl/get_material_batch', //商品的原材料信息
        'getCommodityMaking' => '/kcgl/get_commodity_making', //商品加工过程
        'getCommodityProduce' => '/kcgl/get_commodity_produce', //商品生产过程
        'getCommodityCheck' => '/kcgl/get_commodity_check', //商品质检报告

        'getAgentList' => '/jcsj/get_agent_list', //追溯经销商
        //'getVideo' => '/batch/get_video/11', //获得视频
        'getCompanyList' => '/jcsj/get_company_list', //获得公司简介
        'getVideo' => '/jcsj/get_mp4',
        'getWechat' => '/jcsj/get_wechat/wechat', //获得微信公众号
    );

    public function _initialize()
    {
        parent::_initialize();
        if (!session('code')) {
            session('code', I('get.code', APP_DEBUG ? 1001001 : 20010001));
        }
//        3227320100031519
//        4463609080121162
//        6708040736192232
        $this->code = session('code');
        //echo 123;die;
        $this->company = session('company');
        if (!$this->company) {
            $companyResult = $this->httpRequest($this->urls['getCompany']);//获取公司信息
            $this->company = $companyResult['data'][0];
            $this->company['web2'] = (substr($this->company['web'], 0, 4) == 'http') ?
                $this->company['web'] :
                'http://'.$this->company['web'];
            session('company', $this->company);
        }
        //echo 123;die;
        $imgsResult = $this->httpRequest($this->urls['getPicture'].'/head');//获取图片
        //$bottomImgsResult = $this->httpRequest($this->urls['getPicture'].'/body');//获取图片
        /*if ($imgsResult['status'] !== 'yes') {
            $this->error();
        }*/

        $wechatResult = $this->httpRequest($this->urls['getWechat']);
//var_dump($wechatResult);die;
        $this->assign('wechat_url', $wechatResult['data']);
        //$this->assign('bottomImg', $bottomImgsResult['data']);
        $this->assign('title', $this->company['name']);
        $this->assign('imgs', $imgsResult['data']);
        $this->assign('company', $this->company);
    }

    public function index()
    {

        $searchResult = $this->httpRequest($this->urls['getSearch']."/".$this->code);//获取图片
        //var_dump($searchResult);die;
        //echo 123;die;
        $this->assign('content', $searchResult['data']);
        $this->display();
    }

    /**
     * 企业介绍
     */
    public function introduction()
    {
        $title = '企业介绍';
        $companyResult = $this->httpRequest($this->urls['getCompanyList'].'/'.$this->code);
//var_dump($companyResult);die;
        $this->assign('company', $companyResult['data']);
        $this->assign('title', $title);
        $this->display();
    }

    /**
     * 产品展示
     */
    public function show_product()
    {
        $productResult = $this->httpRequest($this->urls['getCommodityList']);//获得商品详情
        /*if ($productResult['status'] !== 'yes') {
            $this->error();
        }*/
        //var_dump($productResult);die;
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
        /*'getBatchList' => 'kcgl/get_batch_list', //商品批次
        'getMaterialBatch' => 'kcgl/get_material_batch', //商品的原材料信息
        'getCommodityMaking' => 'kcgl/get_commodity_making', //商品加工过程
        'getCommodityProduce' => 'kcgl/get_commodity_produce', //商品生产过程
        'getCommodityCheck' => 'kcgl/get_commodity_check', //商品质检报告*/
        $batchResult = $this->httpRequest($this->urls['getBatchList'].'/'.$this->code);
        $materialBatchResult = $this->httpRequest($this->urls['getMaterialBatch'].'/'.$this->code);
        $commodityMakingResult = $this->httpRequest($this->urls['getCommodityMaking'].'/'.$this->code);
        $commodityProduceResult = $this->httpRequest($this->urls['getCommodityProduce'].'/'.$this->code);
        $commodityCheckResult = $this->httpRequest($this->urls['getCommodityCheck'].'/'.$this->code);

        //var_dump($commodityMakingResult);die;
        /*$videoMaking = $this->httpRequest($this->urls['getVideo'], [
            'code' => $this->code,
            'type' => ''
            ]);
        $videoProduce = $this->httpRequest($this->urls['getVideo'], [
            'code' => $this->code,
            'type' => ''
            ]);*/

        //var_dump($batchResult['data']);echo '<br/>';
        //var_dump($materialBatchResult);echo '<br/>';
        //var_dump($commodityMakingResult);echo '<br/>';
        //var_dump($commodityProduceResult);echo '<br/>';
        //var_dump($commodityCheckResult);echo '<br/>';
        //die;
//var_dump($video);die;
        //$this->assign('videoMaking', $videoMaking['data']);
        //$this->assign('videoProduce', $videoMaking['data']);

        $baseMp4Url = (APP_DEBUG == true ? self::GATEWAY_TEST : self::GATEWAY).$this->urls['getVideo'];
        $mp4Urls = [
            'ycl' => $baseMp4Url.'/ycl',
            'sc' => $baseMp4Url.'/sc',
            'jg' => $baseMp4Url.'/jg'
        ];
        $this->assign('mp4_urls', $mp4Urls);
        $this->assign('batch', $batchResult['data']);

        $this->assign('materialBatch', $materialBatchResult['data']);
        $this->assign('commodityMaking', $commodityMakingResult['data']);
        $this->assign('commodityProduce', $commodityProduceResult['data']);

        $this->assign('commodityCheck', $commodityCheckResult['data']);
        $this->display();
    }


    /**
     * 查询经销商
     */
    public function queryMerchant()
    {
        $password = I('get.password');
        $agent = $this->httpRequest($this->urls['getAgentList'].'/'.$password, ['code' => $this->code]);
        //print_r($agent);die;
        $this->ajaxReturn($agent);
    }
}