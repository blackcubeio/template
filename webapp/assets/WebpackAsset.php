<?php
/**
 * WebpackAsset.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package webapp\assets
 */

namespace webapp\assets;

use yii\caching\Cache;
use yii\caching\FileDependency;
use yii\di\Instance;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\AssetBundle;
use yii\web\View;
use Exception;
use Yii;

/**
 * Base webpack assets
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package webapp\assets
 * @since XXX
 */
class WebpackAsset extends AssetBundle
{

    /**
     * @var string name of webpack asset catalog, should be in synch with webpack.config.js
     */
    public $webpackAssetCatalog = 'assets-catalog.json';

    /**
     * string base cache key
     */
    const CACHE_KEY = 'webpack:bundles:';

    /**
     * @var \yii\caching\Cache cache
     */
    public $cache = 'cache';

    /**
     * @inheritdoc
     */
    public $cacheEnabled = false;

    /**
     * @inheritdoc
     */
    public $webpackPath = '@webapp/assets/webpack';

    /**
     * @inheritdoc
     */
    public $webpackDistDirectory = 'build';

    /**
     * @inheritdoc
     */
    public $webpackBundles = [
        // 'manifest',
        // 'vendor',
        'main',
    ];

    /**
     * @var array list of bundles which are css only
     */
    public $cssOnly = [
        'main',
    ];

    /**
     * @var array list of bundles which are js only
     */
    public $jsOnly = [
        'manifest',
        'vendor',
    ];

    public $js = [
    ];
    /**
     * @inheritdoc
     */
    public $css = [
        '//fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'position' => View::POS_HEAD,
        'defer' => 'defer',
    ];

    /**
     * @inheritdoc
     */
    public static function register($view)
    {
        /* @var $view View */
        $bundle = parent::register($view);
        $wp = 'var webpackBaseUrl = \'' .$bundle->baseUrl.'/\';';
        $view->registerJs($wp, View::POS_HEAD);
        return $bundle;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->mergeWebpackBundles();
        parent::init();
    }

    /**
     * Merge webpack bundles with classic bundles and cache it if needed
     * @return void
     * @throws Exception
     * @since XXX
     */
    protected function mergeWebpackBundles()
    {
        try {
            if ((isset($this->webpackPath) === true) && (is_array($this->webpackBundles) === true)) {
                $cacheKey = self::CACHE_KEY . get_called_class();
                $this->sourcePath = $this->webpackPath . '/' . $this->webpackDistDirectory;
                $cache = $this->getCache();
                if (($cache === null) || ($cache->get($cacheKey) === false)) {
                    $assetsFileAlias = $this->webpackPath . '/' . $this->webpackAssetCatalog;
                    $bundles = file_get_contents(Yii::getAlias($assetsFileAlias));
                    $bundles = Json::decode($bundles);
                    if ($cache !== null) {
                        $cacheDependency = Yii::createObject([
                            'class' => FileDependency::class,
                            'fileName' => $assetsFileAlias,
                        ]);
                        $cache->set($cacheKey, $bundles, 0, $cacheDependency);
                    }
                } else {
                    $bundles = $cache->get($cacheKey);
                }
                foreach($this->webpackBundles as $bundle) {
                    if (isset($bundles[$bundle]['js']) === true && in_array($bundle, $this->cssOnly) === false) {
                        $this->js[] = $bundles[$bundle]['js'];
                    }
                    if (isset($bundles[$bundle]['css']) === true && in_array($bundle, $this->jsOnly) === false) {
                        $this->css[] = $bundles[$bundle]['css'];
                    }
                }
            }
        } catch(Exception $e) {
            Yii::error($e->getMessage(), 'webpack');
            throw $e;
        }
    }

    /**
     * @return null|Cache
     * @throws \yii\base\InvalidConfigException
     * @since XXX
     */
    private function getCache()
    {
        if ($this->cacheEnabled === true) {
            $this->cache = Instance::ensure($this->cache, Cache::class);
        }
        return $this->cacheEnabled ? $this->cache : null;
    }
}
