<?php

/** @var yii\web\View $this */
$this->title = '关于 Asset Packagist';
$this->params['subtitle'] = 'Composer + Bower + NPM = friends forever!';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1>工作原理</h1>

    <p>
        Asset Packagist 提供关于Bower和NPM包的信息，类似于Packagist为Composer包的信息。
    <p>
    </p>
        因此，当您在启用资源包（Asset Package）的项目中运行<code>composer</code>，composer知道bower-asset和npm-asset包的所有可用版本，并知道如何下载它们的文件。

    </p>

    <p>首先将 Bower 和 NPM 包 加入到我们自己的仓库中. 脚本会收集包信息并且以Packagist的格式处理json文件.
        例如，你可以看看我们有什么用 Bower <code>moment</code> 包:
    </p>

    <p><a href="/p/bower-asset/moment/latest.json">https://asset-packagist.cn/p/bower-asset/moment/latest.json</a>
    <p>

    <p>该文件包含了该包的所有版本的说明，格式如下:</p>

    <pre><code>
    "2.13.0.0": {
      "uid": 1000600,
      "name": "bower-asset/moment",
      "version": "2.13.0.0",
      "type": "bower-asset",
      "dist": {
        "type": "zip",
        "url": "https://api.github.com/repos/moment/moment/zipball/d6651c21c6131fbb5db891b60971357739015688",
        "reference": "d6651c21c6131fbb5db891b60971357739015688"
      },
      "source": {
        "type": "git",
        "url": "https://github.com/moment/moment.git",
        "reference": "d6651c21c6131fbb5db891b60971357739015688"
      }
    },
    </code></pre>

    <p>
        所以，当您运行<code>composer</code>时，它会下载Asset Packagist 库提供的包信息，然后 Composer 解析依赖项并找到所需包的正确版本，然后将包文件下载到项目的<code>vendor</code>目录中
         (实际上composer并不关心这些文件是PHP还是JS或其他文件).</p>

    <p>所有的JSON文件都作为静态文件存储在 Asset Packagist 端， 项目中 Composer 会有效的找到这些文件，这样一切都能尽快完成。</p>

    <h1>安装到自定义路径</h1>

    <p>Asset Packagist 不是插件, 所以他不受 Composer的包安装位置所限制.<br>
        默认 <code>bower-asset/bootstrap</code> 包将会安装到
        <code>vendor/bower-asset/bootstrap</code> 目录中.</p>

    <p>你可以通过 <code><a
                    href="https://github.com/oomphinc/composer-installers-extender">oomphinc/composer-installers-extender</a></code>
        插件，来自定义安装路径，如:</p>
    <pre><code>
    "require": {
        "oomphinc/composer-installers-extender": "^1.1",
        "bower-asset/bootstrap": "^3.3",
        "npm-asset/jquery": "^2.2"
    },
    "extra": {
        "installer-types": ["bower-asset", "npm-asset"],
        "installer-paths": {
            "public/assets/{$vendor}/{$name}/": ["type:bower-asset", "type:npm-asset"]
        }
    },
    "repositories": [
        {
            "type": "composer",
            "url": "https://asset-packagist.cn"
        }
    ]
    </code></pre>

    <h1>Yii2</h1>

    <p>Yii2 默认会将 Bower 和 NPM 包 分别安装到 <code>vendor/bower</code> 和 <code>vendor/npm</code>目录中.</p>

    <p>因此, 在Yii2项目中引用 asset-packagist, 必须在程序的配置文件中重新指定 Bower 和 NPM 别名的映射，如:</p>

    <pre><code>
    $config = [
        ...
        'aliases' =&gt; [
            '@bower' =&gt; '@vendor/bower-asset',
            '@npm'   =&gt; '@vendor/npm-asset',
        ],
        ...
    ];
    </code></pre>

    <h1>从 composer-asset-plugin 迁移</h1>

    <p>在同一台服务器中运行了多个应用时，从 <a href="https://github.com/fxpio/composer-asset-plugin">composer-asset-plugin</a>迁移是个麻烦事. 你需要注意：当这个插件在全局安装时， asset packagist
        与 asset plugin 同时存在会有冲突. 所以, 为了不影响其他应用的情况下停掉这个插件, 你可以通过在 <code>composer.json</code>
        文件中 config 选项中禁用掉这个插件。 <i>(你的 plugin 版本需要 ≥ 1.3.0 )</i>:</p>

    <pre><code>
    "config": {
        "fxp-asset": {
            "enabled": false
        }
    }
    </code></pre>

    <h1>致谢</h1>

    <p>提供优化版本的中文开发者 <a href="https://github.com/haohetao/asset-packagist.dev">haohetao/asset-packagist.dev</a></p>
    <p>原始作者 <a href="https://github.com/hiqdev/asset-packagist.dev">hiqdev/asset-packagist.dev</a></p>
    <p>这个项目基于 Francois Pluchino's <a href="https://github.com/fxpio/composer-asset-plugin">composer-asset-plugin</a>
        来转换 Bower 和 NPM 包信息成为 Composer 格式.</p>
    <p>搜索驱动 <a href="https://libraries.io/">https://libraries.io/</a>.</p>
</div>
