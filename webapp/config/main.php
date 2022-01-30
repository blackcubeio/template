<?php
/**
 * main.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package webapp\config
 */

use yii\redis\Session as RedisSession;
use yii\rest\UrlRule as RestUrlRule;
use yii\web\JsonParser;
use yii\web\ErrorHandler;

$config = require dirname(dirname(__DIR__)).'/common/config/common.php';

$config['basePath'] = dirname(__DIR__);
$config['id'] = 'blackcube/template';
$config['name'] = 'Blackcube template web application';

$config['controllerNamespace'] = 'webapp\controllers';

$config['components']['request'] = [
    'cookieValidationKey' => getstrenv('YII_COOKIE_VALIDATION_KEY'),
    'parsers' => [
        'application/json' => JsonParser::class,
    ],
];
$proxyIp = getstrenv('PROXY_TRUSTED_HOSTS');
if (empty($proxyIp) === false) {
    $config['components']['request']['trustedHosts'] = [
        $proxyIp
    ];
}

if (getboolenv('REDIS_ENABLED') === true) {
    $config['components']['session'] = [
        'class' => RedisSession::class,
        'redis' => 'redis',
        'useCookies' => true,
    ];

}

if (defined('YII_ENV') && YII_ENV !== 'dev') {
    $config['components']['errorHandler'] = [
        'class' => ErrorHandler::class,
        'errorAction' => 'technical/maintenance'
    ];
}
/**/

/*/
$config['components']['session'] = [
    'class' => 'yii\web\Session',
    'useCookies' => true,
];
/**/

if (defined('YII_ENV') && YII_ENV === 'dev') {
    $yiiGii = class_exists(yii\gii\Module::class);
    if ($yiiGii && defined('YII_DEBUG') && YII_DEBUG == true) {
        $config['modules']['gii'] = [
            'class' => yii\gii\Module::class,
            'allowedIPs' => ['*']
        ];
        $config['bootstrap'][] = 'gii';
    }
    $yiiDebug = class_exists(yii\debug\Module::class);
    if ($yiiDebug && defined('YII_DEBUG') && YII_DEBUG == true) {
        $config['modules']['debug'] = [
            'class' => yii\debug\Module::class,
            'allowedIPs' => ['*']
        ];
        $config['bootstrap'][] = 'debug';
    }
}

$config['components']['assetManager'] = [
    'linkAssets' => true,
];

$config['catchAll'] = require(__DIR__ . '/maintenance.php');

$config['defaultRoute'] = 'site/index';

$config['components']['urlManager'] = [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => false, // should be true in real life
    'showScriptName' => false,
    'rules' => [
        [
            'pattern' => '',
            'route' => $config['defaultRoute'],
        ],
        /*/
        [
            'pattern' => 'maintenance',
            'route' => 'technical/maintenance'
        ],
        /**/
    ],
];

// $config['params'] = [];


return $config;
