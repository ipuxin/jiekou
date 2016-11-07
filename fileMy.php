<?php

class File
{
    //存放缓存文件目录
    private $_dir;
    //定义缓存文件后缀名
    const EXT = '.txt';

    public function __construct()
    {
        //取得当前文件的目录,再此基础上设置缓存目录
        $this->_dir = dirname(__FILE__) . '/files/';
    }

    /**
     * @param string $name 缓存文件的文件名
     * @param string $value 要缓存的数据
     * @param int $cacheTime 缓存时间
     * @return bool|int|mixed
     */
    public function cacheData($name = '', $value = '', $cacheTime = 0)
    {
        //拼接文件路径和文件名
        $filename = $this->_dir . $name . self::EXT;

        // 如果存在$value值,将value值写入缓存
        if ($value !== '') {
            //当传入的$value值为null时,执行删除
            if (is_null($value)) {
                //屏蔽警告提示,当删除不存在的文件事会有警告
                return @unlink($filename);
            }

            //判断目录是否存在
            $dir = dirname($filename);
            //如果目录不存在,就创建
            if (!is_dir($dir)) {
                mkdir($dir, 0777);
            }

            //准备写入文件,首先转换为字符串
//            $cacheTime = sprintf('%011d', $cacheTime);
//            return file_put_contents($filename, $cacheTime . json_encode($value));

            //如果成功返回的是字节数,否则返回false
            return file_put_contents($filename, json_encode($value));
        }

        //如果不存在$value,就开始执行获取缓存程序
        //如果不存在$value,也没有找到文件需要的缓存文件,就终止
        if (!is_file($filename)) {
            return false;
        } else {
            //返回数组,而非对象,故加第二个参数
            return json_decode(file_get_contents($filename), true);
        }
//        //否则就获取缓存文件内容
//        $contents = file_get_contents($filename);
//        $cacheTime = (int)substr($contents, 0, 11);
//        $value = substr($contents, 11);
//        if ($cacheTime != 0 && ($cacheTime + filemtime($filename) < time())) {
//            unlink($filename);
//            return FALSE;
//        }
//        return json_decode($value, true);

    }
}

//$file = new File();
//
//echo $file->cacheData('test1');