<?php declare(strict_types=1);
/**
 * Qiniu.php
 *
 * 版权所有(c) 2025 刘杰（king.2oo8@163.com）。保留所有权利。
 *
 * 未经事先书面许可，任何单位或个人不得将本软件的任何部分以任何形式（包括但不限于复制、
 * 传播、披露等）进行使用、传播或向第三方披露。
 *
 * @author 刘杰
 * @contact king.2oo8@163.com
 */

namespace Swoft\CloudStorage\Storage;

use Exception;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Swoft\Bean\Container;
use Swoft\CloudStorage\Contract\FilterInterface;
use Swoft\CloudStorage\Contract\RequestInterface;
use Swoft\CloudStorage\Contract\ResponseInterface;
use Swoft\CloudStorage\Contract\UploadInterface;
use Swoft\CloudStorage\Exception\QiniuException;
use Swoft\CloudStorage\Filter\QiniuFilter;
use Swoft\CloudStorage\Request;
use Swoft\CloudStorage\Response;
use Swoft\CloudStorage\Storage\Qiniu\QiniuOptions;

/**
 * Class Qiniu
 *
 * @since 2.0.1
 */
final class Qiniu implements UploadInterface
{

    /**
     * @var Auth $auth
     */
    private Auth $auth;

    /**
     * @var UploadManager $uploadManager
     */
    private UploadManager $uploadManager;

    /**
     * current bucket
     *
     * @var string
     */
    private string $bucket;

    private int $expires = 3600;

    /**
     * callback url policy
     *
     * @var array|null
     */
    private ?array $policy = null;

    private bool $strictPolicy = true;

    /**
     * 默认过滤器的名称, 可通过 bean 定义注入自定义过滤器
     *
     * @var string $filter
     */
    private string $filter = QiniuFilter::class;

    /**
     * Qiniu constructor.
     *
     * @param UploadManager $uploadManager
     * @param Auth $auth
     * @param string $bucket
     */
    public function __construct(UploadManager $uploadManager, Auth $auth, string $bucket)
    {
        $this->auth = $auth;
        $this->uploadManager = $uploadManager;
        $this->bucket = $bucket;
    }

    /**
     * 上传文件
     *
     * @param string $cloudFileName 云文件名称
     * @param string $localFilePath 本地文件路径
     * @return ResponseInterface
     * @throws QiniuException
     */
    public function upload(string $cloudFileName, string $localFilePath): ResponseInterface
    {
        try {
            // 创建一个带默认请求参数的请求对象
            $request = Request::new()->withAttribute('options', QiniuOptions::new());

            /**
             * 核心代码封装
             *
             * @param RequestInterface $request
             * @return ResponseInterface
             * @throws Exception
             */
            $func = function (RequestInterface $request) use ($cloudFileName, $localFilePath): ResponseInterface
            {
                /** @var QiniuOptions $options */
                $options = $request->getAttribute('options');
                // 获取一个上传 token
                $token = $this->auth->uploadToken(
                    $this->bucket,
                    $cloudFileName,
                    $this->expires,
                    $this->policy,
                    $this->strictPolicy
                );
                $result = $this->uploadManager->putFile(
                    $token,
                    $cloudFileName,
                    $localFilePath,
                    $options->getParams(),
                    $options->getMime(),
                    $options->isCheckCrc(),
                    $options->getResumeRecordFile(),
                    $options->getVersion(),
                    $options->getPartSize(),
                    $options->getRequestOptions()
                );
                return Response::new()->setRawData($result);
            };
            /** @var FilterInterface $bean */
            $bean = Container::getInstance()->getSingleton($this->filter);
            return $bean->filter($request, $func);
        } catch (Exception $e) {
            throw new QiniuException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * 上传二进制数据
     *
     * @param string $blob                  二进制数据
     * @param string|null $cloudFileName    云文件名称（可为空）
     * @return array
     * @throws QiniuException
     */
    public function uploadBlob(string $blob, string $cloudFileName = null): ResponseInterface
    {
        try {
            // 创建一个带默认请求参数的请求对象
            $request = Request::new()->withAttribute('options', QiniuOptions::new());

            /**
             * 上传核心代码
             *
             * @param RequestInterface $request
             * @return ResponseInterface
             */
            $func = function (RequestInterface $request) use ($blob, $cloudFileName): ResponseInterface {
                $token = $this->auth->uploadToken(
                    $this->bucket,
                    null,
                    $this->expires,
                    $this->policy,
                    $this->strictPolicy
                );
                /** @var QiniuOptions $options */
                $options = $request->getAttribute('options');
                $result = $this->uploadManager->put(
                    $token,
                    $cloudFileName,
                    $blob,
                    $options->getParams(),
                    $options->getMime(),
                    'default_filename',
                    $options->getRequestOptions()
                );
                return Response::new()->setRawData($result);
            };
            /** @var FilterInterface $bean */
            $bean = Container::getInstance()->getSingleton($this->filter);
            return $bean->filter($request, $func);
        } catch (Exception $e) {
            throw new QiniuException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

}
