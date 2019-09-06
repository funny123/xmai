<?php
namespace app\index\controller;

use think\Controller;
use \Justmd5\PinDuoDuo\PinDuoDuo;

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
        $result = $pinduoduo->api->request('pdd.ddk.goods.search', $data);
        return json($result);
    }
    public function prom_generate()
    {
        $data['generate_weapp_webview'] = true;
        $data['p_id_list'] = ['8141691_103897493'];
        $result = $this->pinduoduo->api->request('pdd.ddk.rp.prom.url.generate', $data);
        return json($result);
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
    public function xinge()
    {
        $appId = '56ae0d3f7257c';
        $secretKey = 'cbbf12c06d1007c855880a8ecffd2bd0';
        $accessId = 'accessId';
        $token = '8db6338df5e7dead4b7d5619cb570a5aca95377e';
        $push = new \tencent\xinge\XingeApp($appId, $secretKey, $accessId = '');
        $mess = new \tencent\xinge\Message();
        $mess->setType('notify');
        $mess->setTitle("满100.00元减50元");
        $mess->setContent("2019春秋新款毛针织衫女开衫弹力修身短款V领女装外搭上衣女装");
        $mess->setExpireTime(86400);
        $mess->setSendTime(date('Y-m-d H:i:s'));
        #含义：样式编号0，响铃，震动，不可从通知栏清除，不影响先前通知
        $style = new \tencent\xinge\Style(0, 1, 1, 0, 0);
        $action = new \tencent\xinge\ClickAction();
        $action->setActionType($action::TYPE_URL);
        $action->setUrl("http://uland.taobao.com/coupon/edetail?e=5Rg5mfhsVzgNfLV8niU3RwXoB%2BDaBK5LQS0Flu%2FfbSp4QsdWMikAalrisGmre1Id522H2TxuqpIhtv4ObojqPLKxO5GT1H3ZFohcQNuroYv%2B0SRKzePlva1ZVFsfG5JnNnaruHLt%2B7%2Bhu673DXLEITcFYNeUR5rBogEDjku2hTPJI4Ns%2Ft58tPiW7C7BAjuEi6ISTZ7d1fnn1ap%2BXMS85c1rh%2B4QgJspTA0FRtOwCuw%3D&&app_pvid=59590_11.1.230.234_641_1567774064305&ptl=floorId:2836;app_pvid:59590_11.1.230.234_641_1567774064305;tpp_pvid:100_11.8.222.151_48836_6811567774064310221&xId=PaqBVq2BEAGSPnw4uAFjftTNyx964sRYseovTe2di2hfQ2tIkFIoQ7JLLv44N6u8JuLQMAP1szDbQMRSKDGj6o&union_lens=lensId%3A0b01e6ea_0d05_16d069dbef9_0420");
        #打开url需要用户确认
        // $action->setComfirmOnUrl(1);
        $custom = array('key1' => 'value1', 'key2' => 'value2');
        $mess->setStyle($style);
        $mess->setAction($action);
        $mess->setCustom($custom);
        $acceptTime1 = new \tencent\xinge\TimeInterval(0, 0, 23, 59);
        $mess->addAcceptTime($acceptTime1);
        $ret = $push->PushSingleDevice($token, $mess);
        return json($ret);
    }
}
