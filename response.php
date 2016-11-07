<?php

class Response
{
    /**
     * 按综合方式输出通信数据
     * @param integer $code 状态码
     * @param string $message 提示信息
     * @param array $data 数据
     * @param string $type 数据类型
     * return string
     */
    public static function showJSON($code, $message = '', $data = [])
    {
        if (!is_numeric($code)) {
            return '';
        }

        //为返回最终的json准备数据
        $result = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        echo json_encode($result,JSON_UNESCAPED_UNICODE);
        exit;
    }
}