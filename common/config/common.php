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

use blackcube\core\components\Flysystem;
use blackcube\core\components\FlysystemLocal;
use blackcube\core\components\FlysystemAwsS3;
use blackcube\core\Module as CoreModule;
use blackcube\admin\Module as BoModule;
use yii\db\Connection;
use yii\caching\CacheInterface;
use yii\caching\DummyCache;
use yii\caching\DbCache;
use yii\caching\FileCache;
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
    'container' => [
        'definitions' => [
        ],
        'singletons' => [
            Connection::class => [
                'charset' => 'utf8',
                'dsn' => getstrenv('DB_DRIVER').':host=' . getstrenv('DB_HOST') . ';port=' . getstrenv('DB_PORT') . ';dbname=' . getstrenv('DB_DATABASE'),
                'username' => getstrenv('DB_USER'),
                'password' => getstrenv('DB_PASSWORD'),
                'tablePrefix' => getstrenv('DB_TABLE_PREFIX'),
                'enableSchemaCache' => getboolenv('DB_SCHEMA_CACHE'),
                'schemaCacheDuration' => getintenv('DB_SCHEMA_CACHE_DURATION'),
            ],
            Flysystem::class => [
                'class' => FlysystemLocal::class,
                'path' => getstrenv('FILESYSTEM_LOCAL_PATH'),
            ],
            CacheInterface::class => DummyCache::class,
        ]
    ],
    'bootstrap' => [
        'log',
        'blackcube',
        'bo',
    ],
    'modules' => [
        'blackcube' => [
            'class' => CoreModule::class,
            // 'cmsEnabledmodules' => [''],
            // 'allowedParameterDomains' => ['HOSTS'],
        ],
        'bo' => [
            'class' => BoModule::class, //
            'adminTemplatesAlias' => '@app/admin',
            'additionalAssets' => [],
            'modules' => [
            ],
        ],
    ],
    'components' => [
        'db' => Connection::class,
        'cache' => CacheInterface::class,
        'fs' => Flysystem::class,
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
                        '_SERVER.FILESYSTEM_S3_SECRET',
                    ],
                ],
            ],
        ],
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

if (getboolenv('SYSLOG_ENABLED') === true) {
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
            '_SERVER.FILESYSTEM_S3_SECRET',
        ],
    ];
}

if (getboolenv('REDIS_ENABLED')) {
    $config['container']['singletons'][RedisConnection::class] = [
        'class' => RedisConnection::class,
        'hostname' => getstrenv('REDIS_HOST'),
        'port' => getintenv('REDIS_PORT'),
        'database' => getintenv('REDIS_DATABASE'),
    ];
    $password = getstrenv('REDIS_PASSWORD');
    if ($password !== false && empty($password) === false) {
        $config['container']['singletons'][RedisConnection::class]['password'] = $password;
    }

    $config['container']['singletons'][CacheInterface::class] = [
        'class' => RedisCache::class,
        'redis' => RedisConnection::class
    ];
    $config['components']['redis'] = RedisConnection::class;

}

if (getstrenv('FILESYSTEM_TYPE') === 's3') {
    $config['container']['singletons'][Flysystem::class] = [
        'class' => FlysystemAwsS3::class,
        'key' => getstrenv('FILESYSTEM_S3_KEY'),
        'secret' => getstrenv('FILESYSTEM_S3_SECRET'),
        'bucket' => getstrenv('FILESYSTEM_S3_BUCKET'),
        'region' => getstrenv('FILESYSTEM_S3_REGION'),
        'version' => 'latest',
        'endpoint' => getstrenv('FILESYSTEM_S3_ENDPOINT'),
        'pathStyleEndpoint' => getboolenv('FILESYSTEM_S3_PATH_STYLE'),
    ];
}
return $config;
