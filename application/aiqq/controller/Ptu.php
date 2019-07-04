<?php

namespace app\aiqq\controller;

use aiqq\sdk\API;
use aiqq\sdk\Configer;
use think\Controller;
use think\facade\Config;
class Ptu extends Controller
{
    protected function initialize()
    {
        // 设置AppID与AppKey
        $appInfo = Config::get('key.');
        Configer::setAppInfo($appInfo['AppID'], $appInfo['AppKey']);
    }

    public function ptu_imgfilter_form()
    {
        return $this->fetch();
    }

    public function ptu_imgfilter()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move('./uploads');
        if($info){
        $img = file_get_contents('./uploads/'.$info->getSaveName());
        $base64 = base64_encode($img);
        $params = array(
            'app_id' => '2109624452',
            'image' => $base64,
            'filter'     => '2',
            'time_stamp' => strval(time()),
            'nonce_str' => strval(rand()),
            'sign' => '',
        );
        //执行调用，输出结果
        $response = API::ptu_imgfilter($params);
        // var_dump($response);exit;
        $response = json_decode($response,1);
        // echo base64_decode($response['data']['image']);
        echo file_put_contents('./uploads/result/'.time().'.png',base64_decode($response['data']['image']));
            // // 成功上传后 获取上传信息
            // // 输出 jpg
            // echo $info->getExtension();
            // // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            // echo $info->getSaveName();
            // // 输出 42a79759f284b767dfcb2a0197904287.jpg
            // echo $info->getFilename(); 
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }

        
        
    }
}

