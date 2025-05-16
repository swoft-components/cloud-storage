<?php declare(strict_types=1);
/**
 * ResponseInterface.php
 *
 * 版权所有(c) 2025 刘杰（king.2oo8@163.com）。保留所有权利。
 *
 * 未经事先书面许可，任何单位或个人不得将本软件的任何部分以任何形式（包括但不限于复制、
 * 传播、披露等）进行使用、传播或向第三方披露。
 *
 * @author 刘杰
 * @contact king.2oo8@163.com
 */

namespace Swoft\CloudStorage\Contract;

/**
 * Interface ResponseInterface
 *
 * @since 2.0.1
 */
interface ResponseInterface
{

    /**
     * @param mixed $result
     */
    public function setResult($result): ResponseInterface;

    /**
     * @return mixed
     */
    public function getResult();

    /**
     * @param int $errorCode
     */
    public function setErrorCode(int $errorCode): ResponseInterface;

    /**
     * @return int
     */
    public function getErrorCode(): int;

    /**
     * @param string $errorMessage
     */
    public function setErrorMessage(string $errorMessage): ResponseInterface;

    /**
     * @return string
     */
    public function getErrorMessage(): string;

    /**
     * @param $raw
     * @return ResponseInterface
     */
    public function setRawData($raw): ResponseInterface;

    /**
     * @return mixed
     */
    public function getRawData();

}
