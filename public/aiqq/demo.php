<?php

require('./include.php');

//请在此填入AppID与AppKey
$app_id = '2109624452';
$app_key = '6mKezVaJvmsnTfko';

//设置AppID与AppKey
Configer::setAppInfo($app_id, $app_key);

// 以下为具体接口的调用demo，在调用时，不用再次传入app_id和app_key，
// 如需更换app_id和app_key，请再次调用 Configer::setAppInfo($app_id, $app_key)。
// timestamp和nonce_str为可选参数，如果不传，则API函数内部会自动取当前时间戳和生成随机字符串。
// 图片和语音文件数据兼容原始数据（未经base64）。


// 文本翻译（AI Lab）
$params = array(
    'type' => '0',
    'text' => '今天天气怎么样',
);

$response = API::texttrans($params);
var_dump($response);
// exit;
// 通用OCR识别
$image_data = file_get_contents('./data/generalocr.jpg');
$params = array(
    'image' => base64_encode($image_data),
);

$response = API::generalocr($params);
var_dump($response);

// 语音识别-流式版(WeChat AI)
// 自动分片，只返回最终结果
$speech_data = file_get_contents('./data/wxasrs.mp3');
$params = array(
    'speech'    => base64_encode($speech_data),
    'format'    => 8,     //MP3
    'rate'      => 16000, //16KHz
    'bits'      => 16,    //16位采样
    'speech_id' => "{$app_id}_" . md5(time()),
);

$response = API::wxasrs($params);
var_dump($response);

// 自定义分片规则和是否返回中间结果
$speech_data = file_get_contents('./data/wxasrs.mp3');
$chunk_size  = 6400; //每个分片6400Byte
$total_chunk = ceil(strlen($speech_data) / $chunk_size);
$params = array(
    'format'    => 8,     //MP3
    'rate'      => 16000, //16KHz
    'bits'      => 16,    //16位采样
    'cont_res'  => 1,
    'speech_id' => "{$app_id}_" . md5(time()),
);
for ($i = 0; $i < $total_chunk; ++$i)
{
    $chunk_data = substr($speech_data, $i * $chunk_size, $chunk_size);
    $params['speech_chunk'] = base64_encode($chunk_data);
    $params['len']          = strlen($chunk_data);
    $params['seq']          = $i * $chunk_size;
    $params['end']          = ($i == ($total_chunk-1)) ? 1 : 0;
    $response = API::wxasrs_perchunk($params);
    var_dump($response);
}

