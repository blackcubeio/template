<?php
/**
 * common.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package app\config
 */

use creocoder\flysystem\AwsS3Filesystem;
use creocoder\flysystem\LocalFilesystem;
use yii\db\Connection;
use yii\caching\DummyCache;
use yii\caching\DbCache;
use yii\db\mysql\Schema as MysqSchema;
use yii\db\pgsql\Schema as PgsqlSchema;
use yii\i18n\Formatter;
use yii\log\FileTarget;
use yii\rbac\DbManager;
use yii\redis\Connection as RedisConnection;
use yii\redis\Cache as RedisCache;

$config = [
    'sourceLanguage' => 'en',
    'language' => 'fr',
    'timezone' => 'Europe/Paris',
    'extensions' => require dirname(__DIR__, 2) . '/vendor/yiisoft/extensions.php',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@approot' => dirname(__DIR__, 2),
        '@app' => dirname(__DIR__) . '/',
        '@webapp' => dirname(__DIR__, 2) . '/webapp',
        '@console' => dirname(__DIR__, 2) . '/console',
        '@data' => dirname(__DIR__, 2) . '/data',
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'version' => getenv('APP_VERSION'),
    'bootstrap' => [
        'log',
        'blackcube',
        'bo',
    ],
    'modules' => [
        'blackcube' => [
            'class' => blackcube\core\Module::class,
            // 'cmsEnabledmodules' => [''],
            // 'allowedParameterDomains' => ['HOSTS'],
            // 'cache' => 'cache',
        ],
        'bo' => [
            'class' => blackcube\admin\Module::class, //
            'adminTemplatesAlias' => '@app/admin',
            'additionalAssets' => [],
            'modules' => [
            ],
            // 'cache' => 'cache',
        ],
    ],
    'components' => [
        'db' => [
            'class' => Connection::class,
            'charset' => 'utf8',
            'dsn' => getenv('DB_DRIVER').':host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
            'tablePrefix' => getenv('DB_TABLE_PREFIX'),
            'enableSchemaCache' => getenv('DB_SCHEMA_CACHE'),
            'schemaCacheDuration' => getenv('DB_SCHEMA_CACHE_DURATION'),
        ],
        'cache' => [
            'class' => DummyCache::class,
            // 'class' => DbCache::class,
            // 'class' => RedisCache::class,
            // 'redis' => 'redis',

        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => YII_DEBUG ? ['error', 'warning', 'profile']:['error', 'warning'],
                ],
            ],
        ],
        /*/
        'i18n' => [
            'translations' => [
                'blackcube.admin*' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@app/i18n',
                    'fileMap' => [
                        'blackcube/models' => 'models.php',
                    ]
                ]
            ]
        ]
        /**/
    ],
    'params' => [
    ],
];

if (getenv('DB_DRIVER') === 'pgsql') {
    $config['components']['db']['schemaMap'] = [
        getenv('DB_DRIVER') => [
            'class' => getenv('DB_DRIVER') === 'pgsql' ? PgsqlSchema::class : MysqSchema::class,
            'defaultSchema' => getenv('DB_SCHEMA')
        ]
    ];
}

if (getenv('FILESYSTEM_TYPE') === 'local') {
    $config['components']['fs'] = [
        'class' => LocalFilesystem::class,
        'path' => getenv('FILESYSTEM_LOCAL_PATH'),
        'cache' => (getenv('FILESYSTEM_CACHE') == 1) ? 'cache' : null,
        'cacheKey' => (getenv('FILESYSTEM_CACHE') == 1) ? 'flysystem' : null,
        'cacheDuration' => (getenv('FILESYSTEM_CACHE') == 1) ? getenv('FILESYSTEM_CACHE_DURATION') : null,
    ];
} elseif (getenv('FILESYSTEM_TYPE') === 's3') {
    $config['components']['fs'] = [
        'class' => AwsS3Filesystem::class,
        'key' => getenv('FILESYSTEM_S3_KEY'),
        'secret' => getenv('FILESYSTEM_S3_SECRET'),
        'bucket' => getenv('FILESYSTEM_S3_BUCKET'),
        'region' => 'us-east-1',
        'version' => 'latest',
        'endpoint' => getenv('FILESYSTEM_S3_ENDPOINT'),
        'pathStyleEndpoint' => (getenv('FILESYSTEM_S3_PATH_STYLE') == 1) ? true : false,
        'cache' => (getenv('FILESYSTEM_CACHE') == 1) ? 'cache' : null,
        'cacheKey' => (getenv('FILESYSTEM_CACHE') == 1) ? 'flysystem' : null,
        'cacheDuration' => (getenv('FILESYSTEM_CACHE') == 1) ? getenv('FILESYSTEM_CACHE_DURATION') : null,
    ];
}


return $config;
