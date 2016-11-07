<?php
header('Content-type:text/html;Charset=utf-8');
/*
 * APP接口,方案三:定时任务产生缓存
 * 测试页:/index.php?page=1&pagesize=12
 */

//引入数据库封装类
require_once('./db.php');
//引入文件缓存封装类
require_once('./file.php');

//接收get参数
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = isset($_GET['pagesize']) ? $_GET['pagesize'] : 1;

//判断参数是否合法
if (!is_numeric($page) || !is_numeric($pageSize)) {
    file_put_contents('./logs_cron/' . date('y-m-d') . '-log.txt', '页数或每页显示个数有误');
    return;
}

//起始纪录,就是本页前面所有纪录的下一个
$offset = ($page - 1) * $pageSize;
$sql = "select * from users where id>10 order by id desc limit {$offset},{$pageSize};";

//把结果存为数组
$contents = [];
//如果不存在缓存文件,就从数据库中获取
$cache = new File();

//连接数据库
try {
    $connect = DB::getInstance()->connect();
} catch (Exception $e) {
    file_put_contents('./logs_cron/' . date('y-m-d') . '-log.txt', $e->getMessage());
    return;
}

$result = mysql_query($sql, $connect);

//mysql_fetch_array($result);返回索引数组 MYSQL_NUM 和关联数组 MYSQL_ASSOC
while ($content = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $contents[] = $content;
}
echo '来自crontab新建: 共有: ' . mysql_num_rows($result) . '条记录<br>';
echo '来自crontab新建: 共有: ' . mysql_num_fields($result) . '个字段<br>';
echo '<hr>';
mysql_close();

//如果有内容,就放入缓存文件中
if ($contents) {
    $cache->cacheData('index_cron_cache', $contents);
} else {
    file_put_contents('./logs_cron/' . date('y-m-d') . '-log.txt', '没有相关数据');
}
