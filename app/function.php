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

/**
 * 删除存储桶上的文件
 * @param $data
 * @return array
 */
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

/**
 * 下载存储桶上的文件
 * @param $data
 * @return array
 */
function downloadCosFile($data)
{
    try {
        $signedUrl = getCosClient()->getObjectUrl(config("cos")['bucket'], $data['fileKeyName'], $data['expire']?$data['expire']:'+10 minutes');
        $result = ['code'=>1,'data'=>$signedUrl];
    } catch (\Exception $e) {
        $result = ['code'=>0,'data'=>$e];
    }
    return $result;
}

/**
 * 将将存储桶上的文件保存到本地
 * @param $key  key
 * @param $localPath 本地保存路径
 * @return array
 */
function downloadCosFileSavelocal($key,$localPath)
{
    try {
        $localPath = @$localPath;
        $result = getCosClient()->getObject([
                'Bucket' => config("cos")['bucket'],
                'Key' => $key,
                'SaveAs' => $localPath]
        );
        print_r($result);
        $result = ['code'=>1,'data'=>$localPath];
    } catch (\Exception $e) {
        // 请求失败
        $result = ['code'=>0,'data'=>$e];
    }
    return $result;
}

