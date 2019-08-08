<?php

class Solution {

    /**
     * @param String $S
     * @return Integer[][]
     */
    function largeGroupPositions($s) {
       $len = strlen($s);
        $result = [];
        $count = 1;
        for($i=0;$i<$len;$i++){
            if($s[$i]==$s[$i+1]){
                $count++;
            }elseif($count>=3){
                array_push($result,[$i,$i+$count]);
                $count = 1;
            }else{
                $count=1;
            }
        }
        return $result;
    }
}

$solution = new Solution();
$str = "abcdddeeeeaabbbcd";
$result = $solution->largeGroupPositions($str);
var_dump($result);