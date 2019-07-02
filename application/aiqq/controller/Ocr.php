<?php

namespace app\aiqq\controller;

use think\Controller;
use think\facade\Config;
use aiqq\sdk\API;
use aiqq\sdk\Configer;
use aiqq\sdk\HttpUtil;
use aiqq\sdk\Signature;

class Ocr extends Controller
{
    public function index()
    {
        dump(Config::get('key.'));
        return 'Ocr';
    }
    public function ocr()
    {
        // 设置AppID与AppKey
        $appInfo = Config::get('key.');
        Configer::setAppInfo($appInfo['AppID'], $appInfo['AppKey']);
        $params = array(
            'app_id'     => '2109624452',
            'type'       => '0',
            'text'       => '什么',
            'time_stamp' => strval(time()),
            'nonce_str'  => strval(rand()),
            'sign'       => '',
        );
        //执行调用，输出结果
        $response = API::texttrans($params);
        var_dump($response);
    }

    public function generalocr(){
        $img = './static/data/generalocr.jpg';
        $base64 = base64_encode($img);
        // 设置AppID与AppKey
        $appInfo = Config::get('key.');
        Configer::setAppInfo($appInfo['AppID'], $appInfo['AppKey']);
        $params = array(
            'app_id'     => '2109624452',
            'image'      => $base64,
            'time_stamp' => strval(time()),
            'nonce_str'  => strval(rand()),
            'sign'       => '',
        );
         //执行调用，输出结果
         $response = API::generalocr($params);
         var_dump($response);
    }

}
