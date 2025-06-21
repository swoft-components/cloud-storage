<?php declare(strict_types=1);
/**
 * UploadInterface.php
 *
 * 版权所有(c) 2025 刘杰（king.2oo8@163.com）。保留所有权利。
 *
 * 未经事先书面许可，任何单位或个人不得将本软件的任何部分以任何形式（包括但不限于复制、
 * 传播、披露等）进行使用、传播或向第三方披露。
 *
 * @author 刘杰
 * @contact king.2oo8@163.com
 */

namespace SwoftComponents\CloudStorage\Contract;

use SwoftComponents\Stdlib\Contract\ResponseInterface;

/**
 * 上传接口
 *
 * @since 2.0.1
 */
interface UploadInterface
{

    /**
     * 上传文件
     *
     * @param string $cloudFileName 云文件名称
     * @param string $localFilePath 本地文件路径
     * @return ResponseInterface 上传文件信息
     */
    public function upload(string $cloudFileName, string $localFilePath): ResponseInterface;

    /**
     * 上传二进制数据
     *
     * @param string $blob 二进制数据
     * @param string|null $cloudFileName 云文件名称
     * @return ResponseInterface 上传文件信息
     */
    public function uploadBlob(string $blob, ?string $cloudFileName = null): ResponseInterface;

}
