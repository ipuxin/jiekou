<?php
header('Content-type:text/html;Charset=utf-8');
/*
 * APP接口,方案三:定时任务产生缓存
 * list.php页面从缓存提取数据
 * /list.php?format=xml
 * 测试页:/index.php?page=1&pagesize=12
 */

//引入接口封装类
require_once('./response.php');
//引入文件缓存封装类
require_once('./file.php');

$cache = new File();
$contents = $cache->cacheData('index_cron_cache');

if ($contents) {
    return Response::show(200, '首页数据获取成功', $contents);
} else {
    return Response::show(400, '首页数据获取失败', $contents);
}