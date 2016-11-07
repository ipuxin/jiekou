<?php

/*
* 单例模式只能被自身实例化,不能在其他类中实例化
*/

class DB
{

//保存类的实例的静态成员变量
    static private $_instance;
// 数据库链接静态变量
    static private $_connectSource;

// 链接数据库配置
    private $_dbConfig = [
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => '111',
        'database' => 'xsphp',
    ];

//构造函数设定为非public(防止外部使用new创建对象)
    private function __construct()
    {

    }

//设定一个访问这个实例的公共静态方法
    static public function getInstance()
    {
        /*
        * 判断一个对象是否是某个类的实例
        * 如果$_instance 不是 自身的实例,
        * 就说明自身类没有被实例化
        */
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /*
    * 数据库链接
    */
    public function connect()
    {
//如果不存在数据库连接资源,才创建新的连接
        if (!self::$_connectSource) {
// 设置数据库连接资源
            self::$_connectSource = @mysql_connect($this->_dbConfig['host'], $this->_dbConfig['user'], $this->_dbConfig['password']);

//如果连接失败,抛出异常
            if (!self::$_connectSource) {
//                 抛出异常处理
                throw new Exception('mysql connect error ');
            }

// 选择一个数据库
            mysql_select_db($this->_dbConfig['database'], self::$_connectSource);

// 设置字符编码
            mysql_query("set names UTF8", self::$_connectSource);
        }
// 返回资源链接
        return self::$_connectSource;
    }
}