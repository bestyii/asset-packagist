<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\components;

use hiqdev\assetpackagist\exceptions\AssetFileStorageException;
use hiqdev\assetpackagist\models\AssetPackage;
use Yii;
use yii\base\Component;
use yii\helpers\Json;

class Storage extends Component implements StorageInterface
{
    protected $_path;
    protected $_locker;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->_path = Yii::getAlias('@storage', false);
    }

    protected function acquireLock()
    {
        /* @var $mutex \yii\mutex\Mutex */
        $mutex = Yii::$app->mutex;

        if (!$mutex->acquire('lock', 5)) {
            throw new \Exception('failed get lock');
        }
    }

    protected function releaseLock()
    {
        /* @var $mutex \yii\mutex\Mutex */
        $mutex = Yii::$app->mutex;

        $mutex->release('lock');
    }

    protected function acquireLock2()
    {
        /* @var $mutex \yii\mutex\Mutex */
        $mutex = Yii::$app->mutex;

        if (!$mutex->acquire('lock2', 5)) {
            throw new \Exception('failed get lock');
        }
    }

    protected function releaseLock2()
    {
        /* @var $mutex \yii\mutex\Mutex */
        $mutex = Yii::$app->mutex;

        $mutex->release('lock2');
    }

    protected function acquireLock3()
    {
        /* @var $mutex \yii\mutex\Mutex */
        $mutex = Yii::$app->mutex;

        if (!$mutex->acquire('lock3', 5)) {
            throw new \Exception('failed get lock');
        }
    }

    protected function releaseLock3()
    {
        /* @var $mutex \yii\mutex\Mutex */
        $mutex = Yii::$app->mutex;

        $mutex->release('lock3');
    }

    protected function acquireLock4()
    {
        /* @var $mutex \yii\mutex\Mutex */
        $mutex = Yii::$app->mutex;

        if (!$mutex->acquire('lock4', 5)) {
            throw new \Exception('failed get lock');
        }
    }

    protected function releaseLock4()
    {
        /* @var $mutex \yii\mutex\Mutex */
        $mutex = Yii::$app->mutex;

        $mutex->release('lock4');
    }
    /**
     * {@inheritdoc}
     */
    public function getNextId()
    {
        $this->acquireLock();
        try {
            $nextID = $this->readLastId() + 1;
            $this->writeLastId($nextID);
        } finally {
            $this->releaseLock();
        }

        return $nextID;
    }

    protected function readLastId()
    {
        $path = $this->getLastIdPath();

        return (file_exists($path) ? (int) file_get_contents($path) : 0) ?: 1000000;
    }

    protected function writeLastId($value)
    {
        if (file_put_contents($this->getLastIdPath(), $value) === false) {
            throw new AssetFileStorageException('Filed to write lastId to the storage');
        }
    }

    protected function getLastIdPath()
    {
        return $this->buildPath('lastid');
    }

    /**
     * {@inheritdoc}
     */
    public function writePackage(AssetPackage $package)
    {
        $name = $package->getNormalName();
        $data = [
            'packages' => [
                $name => $package->getReleases(),
            ],
        ];
        $json = Json::encode($data);
        $hash = hash('sha256', $json);
        $path = $this->buildHashedPath($name, $hash);
        $latestPath = $this->buildHashedPath($name);
        if (!file_exists($path)) {
            $this->acquireLock2();
            try {
                if ($this->mkdir(dirname($path)) === false) {
                    throw new AssetFileStorageException('Failed to create a directory for asset-package', $package);
                }
                if (file_put_contents($path, $json) === false) {
                    throw new AssetFileStorageException('Failed to write package', $package);
                }
                if (file_put_contents($latestPath, $json) === false) {
                    throw new AssetFileStorageException('Failed to write file "latest.json" for asset-packge', $package);
                }
                $this->writeProviderLatest($name, $hash);
            } finally {
                $this->releaseLock2();
            }
        } else {
            touch($latestPath);
        }

        return $hash;
    }

    /**
     * {@inheritdoc}
     */
    public function readPackage(AssetPackage $package)
    {
        $name = $package->getNormalName();
        $path = $this->buildHashedPath($name);
        clearstatcache(false, $path);
        if (!file_exists($path)) {
            return null;
        }
        $json = file_get_contents($path);
        $updateTime = filemtime($path);
        $hash = hash('sha256', $json);
        $data = Json::decode($json);
        $releases = isset($data['packages'][$name]) ? $data['packages'][$name] : [];

        return compact('hash', 'releases', 'updateTime');
    }

    protected function buildPath()
    {
        $args = func_get_args();
        array_unshift($args, $this->_path);

        return implode(DIRECTORY_SEPARATOR, $args);
    }

    protected function buildHashedPath($name, $hash = 'latest')
    {
        return $this->buildPath('p', $name, $hash . '.json');
    }

    protected function writeProviderLatest($name, $hash)
    {
        $latestPath = $this->buildHashedPath('provider-latest');
        if (file_exists($latestPath)) {
            $data = Json::decode(file_get_contents($latestPath) ?: '[]');
        }
        if (!isset($data) || !is_array($data)) {
            $data = [];
        }
        if (!isset($data['providers'])) {
            $data['providers'] = [];
        }
        $data['providers'][$name] = ['sha256' => $hash];
        $json = Json::encode($data);
        $hash = hash('sha256', $json);
        $path = $this->buildHashedPath('provider-latest', $hash);

        if (!file_exists($path)) {
            $this->acquireLock3();

            try {
                if ($this->mkdir(dirname($path)) === false) {
                    throw new AssetFileStorageException('Failed to create a directory for provider-latest storage');
                }
                if (file_put_contents($path, $json) === false) {
                    throw new AssetFileStorageException('Failed to write package to provider-latest storage for package "' . $name . '"');
                }
                if (file_put_contents($latestPath, $json) === false) {
                    throw new AssetFileStorageException('Failed to write file "latest.json" to provider-latest storage for package "' . $name . '"');
                }
                $this->writePackagesJson($hash);
            } finally {
                $this->releaseLock3();
            }
        } else {
            touch($latestPath);
        }

        return $hash;
    }

    protected function writePackagesJson($hash)
    {
        $data = [
            'providers-url'     => '/p/%package%/%hash%.json',
            'provider-includes' => [
                'p/provider-latest/%hash%.json' => [
                    'sha256' => $hash,
                ],
            ],
        ];
        $this->acquireLock4();
        $filename = $this->buildPath('packages.json');
        try {
            if (file_put_contents($filename, Json::encode($data)) === false) {
                throw new AssetFileStorageException('Failed to write main packages.json');
            }
            touch($filename);
        } finally {
            $this->releaseLock4();
        }
    }

    /**
     * Creates directory $dir and sets chmod 777.
     * @param string $dir
     * @return bool whether the directory was created successfully
     */
    protected function mkdir($dir)
    {
        if (!file_exists($dir)) {
            return @mkdir($dir, 0777, true);
        }

        return true;
    }

    public function readJson($path)
    {
        return Json::decode(file_get_contents($this->buildPath($path)));
    }

    protected function readPackagesJson()
    {
        $data = $this->readJson('packages.json');

        return $data['provider-includes'];
    }

    protected function readProvider($path)
    {
        $data = $this->readJson($path);

        return $data['providers'];
    }

    /**
     * {@inheritdoc}
     */
    public function listPackages()
    {
        $packages = [];
        $providers = $this->readPackagesJson();
        foreach ($providers as $path => $data) {
            $path = strtr($path, ['%hash%' => $data['sha256']]);
            $packages = array_merge($packages, $this->readProvider($path));
        }

        return $packages;
    }
}
