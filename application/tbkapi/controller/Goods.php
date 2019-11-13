<?php

namespace app\tbkapi\controller;

use think\Controller;
use think\facade\Request;

class Goods extends Controller
{
    protected $appkey = '27697571';
    protected $secret = '2a41dfd60d1f8ae345a05fc577009b16';
    public function index()
    {
        return 'tbkapi/goods';
    }
    // taobao.tbk.dg.material.optional( 淘宝客-推广者-物料搜索 )
    public function material()
    {

        include_once EXTEND_PATH . '/taobaoke/TopSdk.php';
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkDgMaterialOptionalRequest;
        $page = Request::param('page') ?? 1;
        $cat = Request::param('cat') ?? 16;
        $req->setAdzoneId("72200643");
        // $req->setStartDsr("10");
        $req->setPageSize("20");
        $req->setPageNo($page);
        // $req->setPlatform("1");
        // $req->setEndTkRate("1234");
        // $req->setStartTkRate("1234");
        // $req->setEndPrice("10");
        // $req->setStartPrice("10");
        // $req->setIsOverseas("false");
        // $req->setIsTmall("false");
        // $req->setSort("tk_rate_des");
        // $req->setItemloc("杭州");
        $req->setCat($cat);
        // $req->setQ("女装");
        // $req->setMaterialId("2836");
        $req->setHasCoupon("true");
        // $req->setIp("13.2.33.4");
        // $req->setNeedFreeShipment("true");
        // $req->setNeedPrepay("true");
        // $req->setIncludePayRate30("true");
        // $req->setIncludeGoodRate("true");
        // $req->setIncludeRfdRate("true");
        // $req->setNpxLevel("2");
        // $req->setEndKaTkRate("1234");
        // $req->setStartKaTkRate("1234");
        // $req->setDeviceEncrypt("MD5");
        // $req->setDeviceValue("xxx");
        // $req->setDeviceType("IMEI");
        $resp = $c->execute($req);
        return json($resp);
    }

    // taobao.tbk.dg.optimus.material( 淘宝客-推广者-物料精选 )
    public function optimus()
    {
        include_once EXTEND_PATH . '/taobaoke/TopSdk.php';
        $MaterialId = Request::param('MaterialId') ?? 3759;
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkDgOptimusMaterialRequest;
        $req->setPageSize("20");
        $req->setAdzoneId("72200643");
        $req->setPageNo("1");
        $req->setMaterialId($MaterialId);
        // $req->setDeviceValue("xxx");
        // $req->setDeviceEncrypt("MD5");
        // $req->setDeviceType("IMEI");
        // $req->setContentId("323");
        // $req->setContentSource("xxx");
        // $req->setItemId("33243");
        $resp = $c->execute($req);
        return json($resp);
    }
}
