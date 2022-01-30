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
use yii\log\SyslogTarget;
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
        '@modules' => dirname(__DIR__, 2) . '/modules',
        '@plugins' => dirname(__DIR__, 2) . '/plugins',
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'version' => getstrenv('APP_VERSION'),
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
            'dsn' => getstrenv('DB_DRIVER').':host=' . getstrenv('DB_HOST') . ';port=' . getstrenv('DB_PORT') . ';dbname=' . getstrenv('DB_DATABASE'),
            'username' => getstrenv('DB_USER'),
            'password' => getstrenv('DB_PASSWORD'),
            'tablePrefix' => getstrenv('DB_TABLE_PREFIX'),
            'enableSchemaCache' => getboolenv('DB_SCHEMA_CACHE'),
            'schemaCacheDuration' => getintenv('DB_SCHEMA_CACHE_DURATION'),
        ],
        'cache' => [
            'class' => DummyCache::class,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => YII_DEBUG ? ['error', 'warning', 'profile']:['error', 'warning'],
                    'maskVars' => [
                        '_SERVER.HTTP_AUTHORIZATION',
                        '_SERVER.PHP_AUTH_USER',
                        '_SERVER.PHP_AUTH_PW',
                        '_SERVER.DB_PASSWORD',
                        '_SERVER.DB_ROOT_PASSWORD',
                        '_SERVER.REDIS_PASSWORD',
                        '_SERVER.PROFIDEO_PASSWORD',
                        '_SERVER.FILESYSTEM_S3_SECRET',
                    ],
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

if (getstrenv('DB_DRIVER') === 'pgsql') {
    $config['components']['db']['schemaMap'] = [
        getstrenv('DB_DRIVER') => [
            'class' => getstrenv('DB_DRIVER') === 'pgsql' ? PgsqlSchema::class : MysqSchema::class,
            'defaultSchema' => getstrenv('DB_SCHEMA')
        ]
    ];
}

if (getboolenv('') === true) {
    $config['components']['log']['targets'][] = [
        'class' => SyslogTarget::class,
        'enabled' => getboolenv('SYSLOG_ENABLED'),
        'levels' => YII_DEBUG ? ['error', 'warning', 'profile']:['error', 'warning'],
        'identity' => getstrenv('SYSLOG_IDENTITY'),
        'maskVars' => [
            '_SERVER.HTTP_AUTHORIZATION',
            '_SERVER.PHP_AUTH_USER',
            '_SERVER.PHP_AUTH_PW',
            '_SERVER.DB_PASSWORD',
            '_SERVER.DB_ROOT_PASSWORD',
            '_SERVER.REDIS_PASSWORD',
            '_SERVER.PROFIDEO_PASSWORD',
            '_SERVER.FILESYSTEM_S3_SECRET',
        ],
    ];
}
if (getboolenv('REDIS_ENABLED')) {
    $config['components']['redis'] = [
        'class' => RedisConnection::class,
        'hostname' => getstrenv('REDIS_HOST'),
        'port' => getintenv('REDIS_PORT'),
        'database' => getintenv('REDIS_DATABASE'),
    ];
    $password = getstrenv('REDIS_PASSWORD');
    if ($password !== false && empty($password) === false) {
        $config['components']['redis']['password'] = $password;
    }
    $config['components']['cache'] = [
        'class' => RedisCache::class,
        'redis' => 'redis'
    ];
}
if (getstrenv('FILESYSTEM_TYPE') === 'local') {
    $config['components']['fs'] = [
        'class' => LocalFilesystem::class,
        'path' => getstrenv('FILESYSTEM_LOCAL_PATH'),
        'cache' => (getboolenv('FILESYSTEM_CACHE') === true) ? 'cache' : null,
        'cacheKey' => (getboolenv('FILESYSTEM_CACHE') === true) ? 'flysystem' : null,
        'cacheDuration' => (getboolenv('FILESYSTEM_CACHE') === true) ? getintenv('FILESYSTEM_CACHE_DURATION') : null,
    ];
} elseif (getstrenv('FILESYSTEM_TYPE') === 's3') {
    $config['components']['fs'] = [
        'class' => AwsS3Filesystem::class,
        'key' => getstrenv('FILESYSTEM_S3_KEY'),
        'secret' => getstrenv('FILESYSTEM_S3_SECRET'),
        'bucket' => getstrenv('FILESYSTEM_S3_BUCKET'),
        'region' => getstrenv('FILESYSTEM_S3_REGION'),
        'version' => 'latest',
        'endpoint' => getstrenv('FILESYSTEM_S3_ENDPOINT'),
        'pathStyleEndpoint' => getboolenv('FILESYSTEM_S3_PATH_STYLE'),
        'cache' => (getboolenv('FILESYSTEM_CACHE') === true) ? 'cache' : null,
        'cacheKey' => (getboolenv('FILESYSTEM_CACHE') === true) ? 'flysystem' : null,
        'cacheDuration' => (getboolenv('FILESYSTEM_CACHE') === true) ? getintenv('FILESYSTEM_CACHE_DURATION') : null,
    ];
}
return $config;
