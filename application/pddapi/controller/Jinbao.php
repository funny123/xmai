<?php

namespace app\pddapi\controller;

use think\Controller;
use \Justmd5\PinDuoDuo\PinDuoDuo;

class Jinbao extends Controller
{
    protected $pinduoduo;
    protected function initialize()
    {

        $config = [
            'client_id' => '1dfde17c1c5743bb8551a43528f69a27',
            'client_secret' => '414cfb00d9b1407c46e09b52ee6222cff0745b2c',
            'debug' => true,
            'member_type' => 'JINBAO', //用户角色 ：MERCHANT(商家授权),H5(移动端),多多客(JINBAO),
            'redirect_uri' => 'http://pdd.0512688.com',
            'log' => [
                'name' => 'pinduoduo',
                'file' => __DIR__ . '/pinduoduo.log',
                'level' => 'debug',
                'permission' => 0777,
            ],
        ];
        $this->pinduoduo = new PinDuoDuo($config);
    }

    /**
     * 多多进宝商品查询
     * pdd.ddk.goods.search
     *
     */
    public function top_goods_list()
    {
        $data['p_id'] = '8141691_103897493';
        $data['keyword'] = '熨斗';
        $data['page_size'] = 10;
        $data['custom_parameters'] = 'marlon';
        $result = $this->pinduoduo->api->request('pdd.ddk.goods.search', $data);
        return json($result);
    }
    /**
     * pdd.ddk.goods.detail
     * （多多进宝商品详情查询）
     */
    public function good_detail()
    {
        $data['pid'] = '8141691_103897493';
        $data['goods_id_list'] = ['6221928302'];
        $data['custom_parameters'] = 'mf';
        $result = $this->pinduoduo->api->request('pdd.ddk.goods.detail', $data);
        return json($result);
    }
    /**
     * pdd.ddk.phrase.generate
     * （生成多多口令接口）
     */
    public function phrase_generate()
    {
        // $data['p_id'] = '8141691_103897493';
        $data['p_id'] = '8141691_41691862';
        $data['goods_id_list'] = [6221928302];
        $data['custom_parameters'] = 'mf';
        $data['style'] = 1;
        $result = $this->pinduoduo->api->request('pdd.ddk.phrase.generate', $data);
        return json($result);
    }
    /**
     * pdd.ddk.goods.promotion.url.generate
     * （多多进宝推广链接生成）
     */
    public function promotion_url_generate()
    {
        $data['p_id'] = '8141691_103897493';
        $data['goods_id_list'] = ['3019115554'];
        $data['custom_parameters'] = 'marlon';
        $data['generate_weapp_webview'] = true;
        // $data['generate_we_app'] = true;
        $data['generate_weiboapp_webview'] = true;
        $data['generate_short_url'] = true;
        $result = $this->pinduoduo->api->request('pdd.ddk.goods.promotion.url.generate', $data);
        return json($result);
    }
    /**
     * pdd.ddk.order.list.range.get
     * （用时间段查询推广订单接口）
     */
    public function order_list_range()
    {
        // $data['p_id'] = '8141691_103897493';
        $data['start_time'] = '2019-08-01 00:00:00';
        $data['end_time'] = '2019-08-08 19:00:00';
        // $data['custom_parameters'] = 'mf';
        // $data['style'] = 1;
        $result = $this->pinduoduo->api->request('pdd.ddk.order.list.range.get', $data);
        return json($result);
    }
    /**
     * pdd.ddk.order.detail.get（查询订单详情）
     */
    public function order_detail()
    {

        $data['order_sn'] = '190808-337774838633563';
        $result = $this->pinduoduo->api->request('pdd.ddk.order.detail.get', $data);
        return json($result);
    }
    /**
     * pdd.ddk.lottery.url.gen（多多客生成转盘抽免单url）
     */
    public function lottery_url()
    {
        $data['pid_list'] = ['8141691_103897493'];
        $data['generate_weapp_webview'] = true;//是否生成唤起微信客户端链接，true-是，false-否，默认false
        $data['generate_short_url'] = true;//是否生成短链接，true-是，false-否
        $data['custom_parameters'] = 'marlon';//自定义参数，为链接打上自定义标签。自定义参数最长限制64个字节。
        $data['generate_we_app'] = true;//是否生成大转盘和主题的小程序推广链接
        $data['multi_group'] = true;//true--生成多人团推广链接 false--生成单人团推广链接（默认false）1、单人团推广链接：用户访问单人团推广链接，可直接购买商品无需拼团。2、多人团推广链接：用户访问双人团推广链接开团，若用户分享给他人参团，则开团者和参团者的佣金均结算给推手
        $result = $this->pinduoduo->api->request('pdd.ddk.lottery.url.gen', $data);
        return json($result);
    }
    /**
     * pdd.ddk.rp.prom.url.generate（生成红包推广链接）
     */
    public function prom_url_generate()
    {
        $data['p_id_list'] = ['8141691_103897493'];
        $data['generate_short_url'] = true;//是否生成短链接，true-是，false-否
        $data['custom_parameters'] = 'marlon';//自定义参数，为链接打上自定义标签。自定义参数最长限制64个字节。
        $data['generate_weapp_webview'] = true;//是否生成唤起微信客户端链接，true-是，false-否，默认false
        $data['we_app_web_view_short_url'] = true;
        $data['we_app_web_wiew_url'] = true;
        $data['generate_we_app'] = true;
        $result = $this->pinduoduo->api->request('pdd.ddk.rp.prom.url.generate', $data);
        return json($result);
    }
}
