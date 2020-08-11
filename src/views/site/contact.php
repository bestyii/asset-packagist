<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;

$this->title = '联系我们';
$this->params['subtitle'] = 'GitHub issues is the preferred way';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
       可以通过以下方式联系我们:
    </p>

    <ul>
        <li><a href="https://github.com/bestyii/asset-packagist/issues">GitHub issues</a> 欢迎一起维护</li>
        <li>电邮: <a href="mailto:info@bestyii.com">info@bestyii.com</a></li>
    </ul>
</div>
