<?php
/**
 * Created by 老成,技术咨询请加群:348455534
 * Date: 2019/10/19
 * Time: 13:15
 */

namespace addons\cmstool\service;


class HttpUtils
{
    public static function get($url,$cookies="")
    {
        $curl = curl_init();//初始化curl
        curl_setopt($curl, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($curl, CURLOPT_HEADER, 0);//设置header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_COOKIE, $cookies);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "user-agent"=>"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36"
        ]);
        $data = curl_exec($curl);//运行curl
        curl_close($curl);
        return $data;
    }
}