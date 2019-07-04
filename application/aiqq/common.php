<?php

/**

 * base64转码图片

 * @param $base64

 * @param string $path

 * @return bool|string

 */

function get_base64_img($base64, $path = './uploads/')
{

    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)) {

        $type = $result[2];

        $new_file = $path . time() . ".{$type}";

        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64)))) {

            return $new_file;

        } else {

            return false;

        }

    }

}
