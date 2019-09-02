<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;

$this->title = 'Contact';
$this->params['subtitle'] = 'GitHub issues is the preferred way';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        You can contact us in several ways:
    </p>

    <ul>
        <li><a href="https://github.com/haohetao/asset-packagist/issues">GitHub issues</a> is the preferred way, you're welcome to contribute too</li>
        <li>my email: <a href="mailto:haohetao@gmail.com.com">sol@hiqdev.com</a></li>
    </ul>
</div>
