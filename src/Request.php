<?php declare(strict_types=1);
/**
 * Request.php
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

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Concern\PrototypeTrait;
use Swoft\CloudStorage\Contract\RequestInterface;

/**
 * Class Request
 *
 * @since 2.0.1
 * @Bean(scope=Bean::PROTOTYPE)
 */
class Request implements RequestInterface
{
    use PrototypeTrait;

    /**
     * Attributes derived from the request.
     *
     * @var array
     */
    protected array $attributes = [];

    /**
     * @return Request
     */
    public static function new(): Request
    {
        return self::__instance();
    }

    /**
     * @inheritdoc
     *
     * @return array Attributes derived from the request.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @inheritdoc
     *
     * @param string $name    The attribute name.
     * @param mixed  $default Default value to return if the attribute does not exist.
     *
     * @return mixed
     * @see getAttributes()
     *
     */
    public function getAttribute(string $name, $default = null)
    {
        return $this->attributes[$name] ?? $default;
    }

    /**
     * @inheritdoc
     *
     * @param string $name  The attribute name.
     * @param mixed  $value The value of the attribute.
     *
     * @return static
     * @see getAttributes()
     *
     */
    public function withAttribute(string $name, $value): self
    {
        $clone = clone $this;

        $clone->attributes[$name] = $value;
        return $clone;
    }

    /**
     * @inheritdoc
     *
     * @param string $name The attribute name.
     *
     * @return static
     * @see getAttributes()
     *
     */
    public function withoutAttribute($name): self
    {
        if (!isset($this->attributes[$name])) {
            return $this;
        }

        $clone = clone $this;

        unset($clone->attributes[$name]);
        return $clone;
    }

}
