<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/28
 * Time: 11:59
 */

function getCosClient()
{
    return new \Qcloud\Cos\Client( [
        'region' => config("cos")['region'],
        'schema' => 'https', //协议头部，默认为http
        'credentials'=>[
            'secretId'  => config("cos")['secretId'],
            'secretKey' => config("cos")['secretKey']]]);
}

function deleteCosFile($data)
{
    try {
        $result = getCosClient()->deleteObject(array(
            'Bucket' => config("cos")['bucket'],
            'Key' => $data['key'],
        ));
        // 请求成功
        $result = ['code'=>1,'data'=>$result];
    } catch (\Exception $e) {
        // 请求失败
        $result = ['code'=>0,'data'=>$e];
    }
    return $result;
}