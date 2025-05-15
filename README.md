# Swoft Cloud Storage

## intro

This component is a cloud storage component for swoft.
Current version 2.0.1, support qiniu cloud storage. 

## Install

- composer command

```bash
composer require swoft/cloud-storage
```

## LICENSE

The Component is open-sourced software licensed under the [Apache license](LICENSE).

## Usage
```php
    // bean.php 中配置 bean 定义
    // accessKey, secretKey 可以在 qiniu 个人中心获取, bucket 是七牛的空间名称
    
    return [
        ...
        'qiniu' => [
            'bucket' => '配置七牛bucket名称'
        ],
        'qiniuAuth' => [
            'accessKey' => '配置授权秘钥 key',
            'secretKey' => '配置授权秘钥 secret',
        ],
        ...
    ];
```
```php
    // 上传文件到七牛云
    use Swoft\CloudStorage\CloudStorage;
    use Swoft\CloudStorage\CloudStorageType;
    
    $cloudFileName = 'test.jpg';
    $localFilePath = __DIR__. DIRECTORY_SEPARATOR. 'test.jpg';
    // upload file to cloud qiniu 
    $result = CloudStorage::upload($cloudFileName, $localFilePath, CloudStorageType::QINIU);
    var_dump($result);
```
