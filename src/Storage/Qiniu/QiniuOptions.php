<?php declare(strict_types=1);
/**
 * QiniuOptions.php
 *
 * 版权所有(c) 2025 刘杰（king.2oo8@163.com）。保留所有权利。
 *
 * 未经事先书面许可，任何单位或个人不得将本软件的任何部分以任何形式（包括但不限于复制、
 * 传播、披露等）进行使用、传播或向第三方披露。
 *
 * @author 刘杰
 * @contact king.2oo8@163.com
 */

namespace SwoftComponents\CloudStorage\Storage\Qiniu;

use Qiniu\Http\RequestOptions;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class QiniuOptions
 *
 * @since 2.0.1
 * @Bean(scope=Bean::PROTOTYPE)
 */
final class QiniuOptions
{
    private ?array $params = null;

    private string $mime = 'application/octet-stream';

    private bool $checkCrc = false;

    /**
     * 断点续传的已上传的部分信息记录文件
     *
     * @var string|null
     */
    private ?string $resumeRecordFile = null;

    /**
     * 分片上传版本 目前支持v1/v2版本 默认v1
     *
     * @var string
     */
    private string $version = 'v1';

    /**
     * 分片上传 v2 字段 默认大小为 4MB 分片大小范围为 1MB - 1GB
     *
     * @var int
     */
    private int $partSize = 4194304;

    /**
     * RequestOptions http 请求对象
     *
     * @var RequestOptions|null
     */
    private ?RequestOptions $requestOptions = null;

    public static function new(): QiniuOptions
    {
        return \bean(self::class);
    }

    /**
     * @return array|null
     */
    public function getParams(): ?array
    {
        return $this->params;
    }

    /**
     * @param array|null $params
     * @return QiniuOptions
     */
    public function setParams(?array $params): QiniuOptions
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return string
     */
    public function getMime(): string
    {
        return $this->mime;
    }

    /**
     * @param string $mime
     * @return QiniuOptions
     */
    public function setMime(string $mime): QiniuOptions
    {
        $this->mime = $mime;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCheckCrc(): bool
    {
        return $this->checkCrc;
    }

    /**
     * @param bool $checkCrc
     * @return QiniuOptions
     */
    public function setCheckCrc(bool $checkCrc): QiniuOptions
    {
        $this->checkCrc = $checkCrc;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResumeRecordFile(): ?string
    {
        return $this->resumeRecordFile;
    }

    /**
     * @param string|null $resumeRecordFile
     * @return QiniuOptions
     */
    public function setResumeRecordFile(?string $resumeRecordFile): QiniuOptions
    {
        $this->resumeRecordFile = $resumeRecordFile;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return QiniuOptions
     */
    public function setVersion(string $version): QiniuOptions
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return int
     */
    public function getPartSize(): int
    {
        return $this->partSize;
    }

    /**
     * @param int $partSize
     * @return QiniuOptions
     */
    public function setPartSize(int $partSize): QiniuOptions
    {
        $this->partSize = $partSize;
        return $this;
    }

    /**
     * @return RequestOptions|null
     */
    public function getRequestOptions(): ?RequestOptions
    {
        return $this->requestOptions;
    }

    /**
     * @param RequestOptions|null $requestOptions
     * @return QiniuOptions
     */
    public function setRequestOptions(?RequestOptions $requestOptions): QiniuOptions
    {
        $this->requestOptions = $requestOptions;
        return $this;
    }

}
