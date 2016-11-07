<?php
header("Content-Type:text/html;Charset=utf-8");
require_once './response.php';

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

$file = Response::showJSON(200,'success',$_dbConfig);





