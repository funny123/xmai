<?php

/**
 * 单例模式
 * 保证一个类仅有一个实例，并提供一个访问它的全局访问点
 */
class Singleton{
    static private $_instance = null;
    private function __construct(){

    }
    static public function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new Singleton();
        }
        return self::$_instance;
    }
    public function display(){
        echo "it is a singleton class function";
    }

}

// $obj = new Singleton();
$obj = Singleton::getInstance();
var_dump($obj);
$obj->display();
$obj1 = Singleton::getInstance();
var_dump($obj===$obj1);