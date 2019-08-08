<?php
namespace app\index\controller;

use \Justmd5\PinDuoDuo\PinDuoDuo;
use think\Controller;
class Index extends Controller
{

    public $pinduoduo;
    protected function initialize()
    {

        // require __DIR__ . '/vendor/autoload.php';
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
    public function index()
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
        $pinduoduo = new PinDuoDuo($config);
        // $result   = $pinduoduo->api->request('pdd.ddk.goods.detail', ['goods_id_list' => ['395581006']]);
        // $data['number'] = 3;
        // $data['p_id_name_list'][] = 'php1';
        // $data['p_id_name_list'][] = 'php2';
        // $data['p_id_name_list'][] = 'php3';
        // $data['pid'] = '8141691_103897493';
        // $data['resource_type'] = 4;
        $data['keyword'] = '手机';
        $data['with_coupon'] = true;
        $data['pid'] = '8141691_103897493';
        // $result   = $pinduoduo->api->request('pdd.ddk.goods.pid.generate', $data);
        $result   = $pinduoduo->api->request('pdd.ddk.goods.search', $data);
        return json($result);
    }
    public function prom_generate(){
        $data['generate_weapp_webview'] = true;
        $data['p_id_list'] = ['8141691_103897493'];
        $result   = $this->pinduoduo->api->request('pdd.ddk.rp.prom.url.generate', $data);
        return json($result);
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
