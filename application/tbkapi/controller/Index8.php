<?php
namespace app\tbkapi\controller;

use think\Controller;
use think\facade\Cache;
use think\facade\Request;

class Index extends Controller
{
    protected $appkey = '27697571';
    protected $secret = '2a41dfd60d1f8ae345a05fc577009b16';
    protected function initialize()
    {

    }
    public function index()
    {
        include_once EXTEND_PATH . '/taobaoke/TopClient.php';
        return 'tbkapi';
    }
    public function demo()
    {
        include_once EXTEND_PATH . '/taobaoke/TopSdk.php';
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkContentGetRequest;
        $req->setAdzoneId("72220263");
        // $req->setType("1");
        // $req->setBeforeTimestamp("1491454244598");
        // $req->setCount("10");
        // $req->setCid("2");
        // $req->setImageWidth("300");
        // $req->setImageHeight("300");
        // $req->setContentSet("1");
        $resp = $c->execute($req);
        return json($resp);
    }
    // taobao.tbk.dg.material.optional( 淘宝客-推广者-物料搜索 )
    public function material()
    {

        include_once EXTEND_PATH . '/taobaoke/TopSdk.php';
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkDgMaterialOptionalRequest;
       
        $req->setAdzoneId("72200643");
        // $req->setStartDsr("10");
        // $req->setPageSize("20");
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
        // $req->setCat("16,18");
        // $req->setQ("女装");
        // $req->setMaterialId("2836");
        // $req->setHasCoupon("false");
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
    // taobao.tbk.sc.invitecode.get( 淘宝客-公用-私域用户邀请码生成 )
    public function invitecode()
    {
        include_once EXTEND_PATH . '/taobaoke/TopSdk.php';
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkScInvitecodeGetRequest;
        // $req->setRelationId("11");
        $req->setRelationApp("common");
        $req->setCodeType("1");
        $session = Cache::get('access_token');
        $session2 = "6302922932fa7ecf8ae8d1edbacdb4c7693d7971176ad4c381086540";

        $resp = $c->execute($req, $session);
        return json($resp);
    }
    // taobao.tbk.sc.publisher.info.get( 淘宝客-公用-私域用户备案信息查询 )
    public function publisher_info()
    {
        include_once EXTEND_PATH . '/taobaoke/TopSdk.php';
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkScPublisherInfoGetRequest;
        $req->setInfoType("1");
        $req->setRelationApp("common");
        $session = Cache::get('access_token');
        $resp = $c->execute($req, $session);
        return json($resp);
    }
    // taobao.tbk.order.details.get( 淘宝客-推广者-所有订单查询 )
    public function order_details()
    {
        include_once EXTEND_PATH . '/taobaoke/TopSdk.php';
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkOrderDetailsGetRequest;
        $req->setStartTime("2019-08-21 19:30:22");
        $req->setEndTime("2019-08-21 21:10:22");
        $req->setOrderScene("1");

        $resp = $c->execute($req);
        return json($resp);
    }
    public function auth()
    {
        $url = 'https://oauth.taobao.com/authorize';
        $postfields = array('response_type' => 'code',
            'client_id' => '27697571',
            'client_secret' => '2a41dfd60d1f8ae345a05fc577009b16',
            // 'code' => 'test',
            'redirect_uri' => 'http://pdd.0512688.com/tbkapi/index/callback');
        $post_data = '';

        foreach ($postfields as $key => $value) {
            $post_data .= "$key=" . urlencode($value) . "&";}
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        //指定post数据
        curl_setopt($ch, CURLOPT_POST, true);

        //添加变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, substr($post_data, 0, -1));
        $output = curl_exec($ch);
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // echo $httpStatusCode;
        curl_close($ch);
        // var_dump($output);
    }
    public function callback()
    {
        $code = Request::param('code');
        $url = 'https://oauth.taobao.com/token';
        $postfields = array('grant_type' => 'authorization_code',
            'client_id' => '27697571',
            'client_secret' => '2a41dfd60d1f8ae345a05fc577009b16',
            'code' => $code,
            'redirect_uri' => 'http://pdd.0512688.com/tbkapi/index/callback');
        $post_data = '';

        foreach ($postfields as $key => $value) {
            $post_data .= "$key=" . urlencode($value) . "&";}
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        //指定post数据
        curl_setopt($ch, CURLOPT_POST, true);

        //添加变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, substr($post_data, 0, -1));
        $output = curl_exec($ch);
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // echo $httpStatusCode;
        curl_close($ch);
        $output = json_decode($output, 1);
        // var_dump($output);
        Cache::set('refresh_token', $output['refresh_token'], $output['re_expires_in']);
        Cache::set('access_token', $output['refresh_token'], $output['expires_in']);
        return Cache::get('access_token');
        // return $code;
    }
}
