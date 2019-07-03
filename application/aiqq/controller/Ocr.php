<?php

namespace app\aiqq\controller;

use aiqq\sdk\API;
use aiqq\sdk\Configer;
use think\Controller;
use think\facade\Config;

class Ocr extends Controller
{
    protected function initialize()
    {
        // 设置AppID与AppKey
        $appInfo = Config::get('key.');
        Configer::setAppInfo($appInfo['AppID'], $appInfo['AppKey']);
    }
    public function index()
    {
        dump(Config::get('key.'));
        return 'Ocr';
    }
    public function ocr()
    {
        $params = array(
            'app_id' => '2109624452',
            'type' => '0',
            'text' => '什么',
            'time_stamp' => strval(time()),
            'nonce_str' => strval(rand()),
            'sign' => '',
        );
        //执行调用，输出结果
        $response = API::texttrans($params);
        var_dump($response);
    }

    public function generalocr_form()
    {
        return $this->fetch();
    }
    
    public function generalocr()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move('./uploads');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getFilename(); 
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }

        $img = file_get_contents('./uploads/'.$info->getSaveName());
        $base64 = base64_encode($img);
        $params = array(
            'app_id' => '2109624452',
            'image' => $base64,
            'time_stamp' => strval(time()),
            'nonce_str' => strval(rand()),
            'sign' => '',
        );
        //执行调用，输出结果
        $response = API::generalocr($params);
        var_dump($response);
    }

}
