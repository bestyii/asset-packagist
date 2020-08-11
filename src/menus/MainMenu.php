<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\menus;

use Yii;

/**
 * Main menu.
 *
 * @author Andrii Vasyliev <sol@hiqdev.com>
 */
class MainMenu extends \hiqdev\yii2\menus\Menu
{
    public function items()
    {
        return [
            'about' => [
                'label' => Yii::t('hisite', '关于'),
                'url' => ['/site/about'],
            ],
            'bestyii' => [
                'label' => 'Best Yii 开发者社区',
                'url' => 'https://www.bestyii.com',
            ]
        ];
    }
}
