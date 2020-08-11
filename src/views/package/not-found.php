<?php

/**
 * @var \yii\web\View
 * @var \hiqdev\assetpackagist\models\AssetPackage $package
 */

use yii\helpers\Html;

$this->title = 'Oops... Package was not found';

?>
<hr/>
<h3><?= $this->title ?></h3>

<?php

if ($package->getType() === 'npm') {
    $link = Html::a('npmjs.com', 'https://npmjs.com/search?q=' . $package->getName(), ['target' => '_blank']);
} elseif ($package->getType() === 'bower') {
    $link = Html::a('bower.io', 'https://bower.io/search?q=' . $package->getName(), ['target' => '_blank']);
}

?>

<h4>你确定这个包在 <?= $link ?>中存在?</h4>
<p> 如果存在, 但是资源包又无法从 asset-packagist 获得&mdash;
    <?= Html::a('报告缺陷 GitHub', 'https://github.com/bestyii/asset-packagist/issues/new') ?>
</p>
