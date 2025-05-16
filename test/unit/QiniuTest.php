<?php declare(strict_types=1);
/**
 * QiniuTest.php
 *
 * 版权所有(c) 2025 刘杰（king.2oo8@163.com）。保留所有权利。
 *
 * 未经事先书面许可，任何单位或个人不得将本软件的任何部分以任何形式（包括但不限于复制、
 * 传播、披露等）进行使用、传播或向第三方披露。
 *
 * @author 刘杰
 * @contact king.2oo8@163.com
 */

namespace SwoftTest\CloudStorage\Unit;

use PHPUnit\Framework\TestCase;
use Swoft\CloudStorage\Contract\ResponseInterface;
use Swoft\CloudStorage\Exception\QiniuException;
use Swoft\CloudStorage\Storage\Qiniu;

class QiniuTest extends TestCase
{

    /**
     * 测试文件上传
     *
     * @return void
     * @throws QiniuException
     */
    public function testUpload(): void
    {
        $cloudFileName = 'test.jpg';
        $localFilePath = __DIR__. DIRECTORY_SEPARATOR. 'test.jpg';

        /** @var Qiniu $qiniu */
        $qiniu = bean(Qiniu::class);
        $this->assertInstanceOf(Qiniu::class, $qiniu);

        $response = $qiniu->upload($cloudFileName, $localFilePath);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertIsInt($response->getErrorCode());
        $this->assertEquals(0, $response->getErrorCode());
    }

    /**
     * 测试二进制数据上传
     *
     * @return void
     * @throws QiniuException
     */
    public function testUploadBlob(): void
    {
        $cloudFileName = 'test1.jpg';
        $localFilePath = __DIR__. DIRECTORY_SEPARATOR. 'test.jpg';
        $content = file_get_contents($localFilePath);
        $this->assertNotEmpty($content);
        /** @var Qiniu $qiniu */
        $qiniu = bean(Qiniu::class);
        $this->assertInstanceOf(Qiniu::class, $qiniu);

        $response = $qiniu->uploadBlob($content, $cloudFileName);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertIsInt($response->getErrorCode());
        $this->assertEquals(0, $response->getErrorCode());
    }

}
