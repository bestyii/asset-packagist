<?php

use hiqdev\assetpackagist\assets\AppAsset;
use yii\helpers\Html;

/** @var yii\web\View $this */
$bundle = AppAsset::register($this);
$logoUrl = $bundle->baseUrl . '/logo';

$this->title = Yii::$app->name;
$this->params['noTitle'] = true;

?>
<div class="container site-index">
    <div style="text-align:center;margin:30px 0px 20px">
        <div>
            <img src="<?= $logoUrl ?>/composer.png" height="140px">
            <img src="<?= $logoUrl ?>/bower.svg" height="100px" style="margin:10px">
            <img src="<?= $logoUrl ?>/npm.svg" height="80px" style="margin:10px">
            <h3>Composer + Bower + NPM = friends forever!</h3>
            <h5>asset-packagist.cn中国区，该项目基于分支asset-packagist.org，数据是独立的</h5>
        </div>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>这是什么?</h2>

                <p>这个仓库可以让 npm 和 bower 包作为 composer 原生包安装.</p>
                <p><b>不</b> 需要插件 <b>不</b> 需要Node.js.</p>

                <p>我们已经添加了常用的 npm 和 bower 包.</p>
                <p>
                    ⚠️ 当用 Composer 安装失败的时候,
                    使用顶部的搜索栏检查指定包的健康状态.
                </p>
                <p><strong>搜索技巧</strong></p>
                <ul>
                    <li>Npm库中不带有 scope 方式命名的包, 如`jquery`用`npm-asset/jquery`代替进行精准搜索.</li>
                    <li>Npm库中以 scope 方式命名的包,将原生命名 `@scope/package`替换成 `scope--package` 格式进行搜索, 如. `npm-asset/pusher--chatkit`.</li>

                </ul>

                <p><?= Html::a('更多 &raquo;', ['/site/about'], ['class' => 'btn btn-default']) ?>
            </div>
            <div class="col-lg-4">
                <h2>用法</h2>

                <p>用以下方法添加包:</p>
                <pre><code>"require": {
    "bower-asset/bootstrap": "^3.3",
    "npm-asset/jquery": "^2.2"
}</code></pre>

                <p>然后加入以下行:</p>
                <pre><code>"repositories": {

    {
        "type": "composer",
        "url": "https://asset-packagist.cn"
    }
}</code></pre>
            </div>
            <div class="col-lg-4">
                <h2>为什么?</h2>

                <p> <code><a href="https://github.com/fxpio/composer-asset-plugin">fxp/composer-asset-plugin</a></code> 让人恼火.
                </p>
                <p>
                    它是一个非常有创意的项目，也是一个好的实现.
                </p>
                <p>
                    但是它有一些问题：当使用<code>composer update</code>时非常缓慢，而且需要全局安装一个插件, 这会影响所有项目. <br> 与此同时，Travis
                    和 Scrutinizer 联合使用中也会有些奇葩问题, 令人抓狂.
                </p>
            </div>
        </div>

    </div>
</div>
