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
            <h5>asset-packagist中国区，该项目基于asset-packagist.org提供的源码，数据是独立的</h5>
        </div>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>这是什么?</h2>

                <p>这个仓库可以让npm和bower包作为composer原生包安装.</p>
                <p><b>不</b> 需要插件 <b>不</b> 需要Node.js.</p>

                <p>我们已经添加了常用的npm和bower包</p>
                <p>
                    当用Composer安装失败的时候,
                    使用顶部的搜索栏检查指定包的健康状态.
                </p>
                <p>For NPM scoped packages use `scope--package` instead of `@scope/package`, e.g. `npm-asset/pusher--chatkit`.(不知道怎么翻译)</p>

                <p><?= Html::a('更多信息 &raquo;', ['/site/about'], ['class' => 'btn btn-default']) ?>
            </div>
            <div class="col-lg-4">
                <h2>用法</h2>

                <p>用以下方法添加包:</p>
                <pre><code>"require": {
    "bower-asset/bootstrap": "^3.3",
    "npm-asset/jquery": "^2.2"
}</code></pre>

                <p>然后加入以下行:</p>
                <pre><code>"repositories": [
    {
        "type": "composer",
        "url": "https://repo.asset-packagist.youtuoweb.com"
    }
]</code></pre>
            </div>
            <div class="col-lg-4">
                <h2>为什么?</h2>

                <p>因为厌倦了 <code><a href="https://github.com/fxpio/composer-asset-plugin">fxp/composer-asset-plugin</a></code>.
                </p>
                <p>
                    它是一个有好想法的项目，也是一个好的实现.但是它有一些问题：当使用<code>composer update</code>时非常缓慢，而且需要全局安装一个插件, 这会影响所有项目. Also there are Travis
                    and Scrutinizer integration special problems, that are a bit annoying(不知道怎么翻译).
                </p>

                <p>问题?</p>
                <p><?= Html::a('更多信息 &raquo;', ['/site/contact'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>

    </div>
</div>
