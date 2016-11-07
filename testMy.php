<?php
header("Content-Type:text/html;Charset=utf-8");
require_once './responseMy.php';
require_once './fileMy.php';

$_dbConfig = [
    'host' => '127.0.0.1',
    'user' => 'root',
    'password' => '7852147852',
    'database' => 'video',
    'doubleArray' => [
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => '7852147852',
        'database' => 'video',
    ],
    'number' => ['a', 'c', 1, 3, 5],
];

$file = new File();

//写入缓存
$file->cacheData('file_put_contents', $_dbConfig);
if ($file) {
    echo 'is ok';
} else {
    echo 'no';
}

//获取缓存
$file->cacheData('file_put_contents');
if ($file) {
    echo '获取缓存成功 is ok<br>';
    var_dump($file->cacheData('file_put_contents'));
    exit;
} else {
    echo 'no';
}

//删除缓存
$file->cacheData('file_put_contents', null);
if ($file) {
    echo '缓存删除 is ok<br>';
    exit;
} else {
    echo 'no';
}

//Response::show(200,'成功返回',$_dbConfig,'xml');
//echo '<hr>';
//Response::jsonEncode(200,'成功返回',$_dbConfig);
//Response::xmlEncode(200,'成功返回',$_dbConfig);




