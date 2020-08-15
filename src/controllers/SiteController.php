<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\controllers;

use hiqdev\assetpackagist\models\AssetPackage;
use Yii;
use yii\web\Response;
use yii2tech\sitemap\File;


class SiteController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionContact()
    {
        return $this->render('contact');
    }

    public function actionSitemap($refresh = 0)
    {
        // get content from cache:
        $content = Yii::$app->cache->get('sitemap.xml');
        if ($content === false || $refresh = 1) {
            // if no cached value exists - create an new one
            // create sitemap file in memory:
            $sitemap = new File();
            $sitemap->fileName = 'php://memory';

            // write your site URLs:
            $sitemap->writeUrl(['site/index'], ['priority' => '0.9']);
            $sitemap->writeUrl(['site/about'], ['priority' => '0.9']);
            $sitemap->writeUrl(['site/contact'], ['priority' => '0.9']);
// or to iterate the row one by one

            $query = (new\yii\db\Query())
                ->from('package');

            foreach ($query->each() as $package) {

                $sitemap->writeUrl(['package/detail', 'fullname' => AssetPackage::buildFullName($package['type'], $package['name'])], ['priority' => '0.8']);
                $sitemap->writeUrl(['package/search', 'query' => $package['name']], ['priority' => '0.9']);
            }

            // get generated content:
            $content = $sitemap->getContent();

            // save generated content to cache
            Yii::$app->cache->set('sitemap.xml', $content);
        }

        // send sitemap content to the user agent:
        $response = Yii::$app->getResponse();
        $response->format = Response::FORMAT_RAW;
        $response->getHeaders()->add('Content-Type', 'application/xml;');
        $response->content = $content;

        return $response;
    }
}
