<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace SwoftComponents\CloudStorage;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use SwoftComponents\CloudStorage\Storage\Qiniu;
use Swoft\Helper\ComposerJSON;
use Swoft\SwoftComponent;

/**
 * Class AutoLoader
 *
 * @since 2.0.1
 */
class AutoLoader extends SwoftComponent
{
    /**
     * Get namespace and dirs
     *
     * @return array
     */
    public function getPrefixDirs(): array
    {
        return [
            __NAMESPACE__ => __DIR__,
        ];
    }

    /**
     * @return array
     */
    public function metadata(): array
    {
        $jsonFile = dirname(__DIR__) . '/composer.json';

        return ComposerJSON::open($jsonFile)->getMetadata();
    }

    public function beans(): array
    {
        return [
            'qiniu' => [
                'class' => Qiniu::class,
                [
                    \bean('qiniuUploadManager'),
                    \bean('qiniuAuth'),
                    'default'
                ],
            ],
            'qiniuUploadManager' => [
                'class' => UploadManager::class,
            ],
            'qiniuAuth' => [
                'class' => Auth::class,
                [
                    'accessKey' => 'accessKey',
                    'secretKey' => 'secretKey',
                    'options' => null
                ]
            ]
        ];
    }
}
