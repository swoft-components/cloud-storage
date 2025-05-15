<?php declare(strict_types=1);
/**
 * CloudStorage.php
 *
 * 版权所有(c) 2025 刘杰（king.2oo8@163.com）。保留所有权利。
 *
 * 未经事先书面许可，任何单位或个人不得将本软件的任何部分以任何形式（包括但不限于复制、
 * 传播、披露等）进行使用、传播或向第三方披露。
 *
 * @author 刘杰
 * @contact king.2oo8@163.com
 */

namespace Swoft\CloudStorage;

use Swoft\CloudStorage\Contract\UploadInterface;
use Swoft\CloudStorage\Exception\CloudStorageException;

/**
 * Class CloudStorage
 *
 * @since 2.0.1
 */
final class CloudStorage
{

    /**
     * @throws CloudStorageException
     */
    public static function upload(string $cloudFileName, string $localFilePath, string $cloudStorageType = CloudStorageType::QINIU): array
    {
        $obs  = bean($cloudStorageType);
        if ($obs === null) {
            throw new CloudStorageException('CloudStorageType is not found');
        }
        if (!($obs instanceof UploadInterface)) {
            throw new CloudStorageException('CloudStorageType must be instanceof UploadInterface');
        }
        return $obs->upload($cloudFileName, $localFilePath);
    }

}
