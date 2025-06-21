<?php declare(strict_types=1);
/**
 * QiniuFilter.php
 *
 * 版权所有(c) 2025 刘杰（king.2oo8@163.com）。保留所有权利。
 *
 * 未经事先书面许可，任何单位或个人不得将本软件的任何部分以任何形式（包括但不限于复制、
 * 传播、披露等）进行使用、传播或向第三方披露。
 *
 * @author 刘杰
 * @contact king.2oo8@163.com
 */

namespace SwoftComponents\CloudStorage\Filter;

use Closure;
use Qiniu\Http\Error;
use Swoft\Bean\Annotation\Mapping\Bean;
use SwoftComponents\CloudStorage\Contract\FilterInterface;
use SwoftComponents\Stdlib\Contract\RequestInterface;
use SwoftComponents\Stdlib\Contract\ResponseInterface;

/**
 * Class QiniuFilter
 *
 * @since 2.0.1
 * @Bean()
 */
class QiniuFilter implements FilterInterface
{

    /**
     * @param RequestInterface $request
     * @param Closure $handle
     * @return ResponseInterface
     */
    public function filter(RequestInterface $request, Closure $handle): ResponseInterface
    {
        /** @var ResponseInterface $response */
        $response = $handle($request);
        $result = $response->getRawData();
        if (!empty($result[0]) && empty($result[1])) {
            return $response->setErrorCode(0)
                ->setErrorMessage('success')
                ->setResult($result[0]);
        }
        if (!empty($result[1])) {
            /** @var Error $error */
            $error = $result[1];
            return $response->setErrorCode($error->code())
                ->setErrorMessage($error->message());
        }
        return $response->setErrorCode(999)
            ->setErrorMessage('error');
    }
}
