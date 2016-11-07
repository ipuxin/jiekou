<?php

class Response
{
    //定义默认数据格式
    const JSON = "json";

    /**
     * 按综合方式输出通信数据
     * @param integer $code 状态码
     * @param string $message 提示信息
     * @param array $data 数据
     * @param string $type 数据类型
     * return string
     */
    public static function show($code, $message = '', $data = [], $type = self::JSON)
    {
        if (!is_numeric($code)) {
            return '';
        }

        $type = strtolower(isset($_GET['format']) ? $_GET['format'] : self::JSON);

        //为返回最终的json准备数据
        $result = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        if ($type == 'json') {
            self::jsonEncode($code, $message, $data);
            exit;
        } elseif ($type == 'array') {
            //调试模式:查看组装好,而没有转码的数据
            var_dump($result);
        } elseif ($type == 'xml') {
            self::xmlEncode($code, $message, $data);
            exit;
        } else {
            // TODO
        }
    }

    /**
     * 按json方式输出通信数据
     * @param integer $code 状态码
     * @param string $message 提示信息
     * @param array $data 数据
     * return string
     */
    public static function jsonEncode($code, $message = '', $data = array())
    {

        if (!is_numeric($code)) {
            return '';
        }

        //为返回最终的json准备数据
        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );

        echo json_encode($result);
        exit;
    }

    /**
     * 按xml方式输出通信数据
     * @param integer $code 状态码
     * @param string $message 提示信息
     * @param array $data 数据
     * return string
     */
    public static function xmlEncode($code, $message, $data = [])
    {
        if (!is_numeric($code)) {
            return '';
        }

        //组合接收过来的数据,为拼接数据做准备
        $result = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        header("Content-Type:text/xml");
        $xml = "<?xml version='1.0' encoding='UTF-8'?>\n";
        $xml .= "<root>\n";

        $xml .= self::xmlToEncode($result);

        $xml .= "</root>";
        echo $xml;
    }

    public static function xmlToEncode($data)
    {
        $xml = $attr = "";
        foreach ($data as $key => $value) {

            //如果节点为数字,就定义一个新节点
            if (is_numeric($key)) {
                $attr = "id='{$key}'";
                $key = "item";
            }

            $xml .= "<{$key} {$attr}>";
            $xml .= is_array($value) ? self::xmlToEncode($value) : $value;
            $xml .= "</{$key}>\n";
        }
        return $xml;
    }

}