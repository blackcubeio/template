<?php
/**
 * main.php
 *
 * PHP version 7.1+
 *
 * @author Philippe Gaultier <pgaultier@ibitux.com>
 * @copyright 2010-2018 Ibitux
 * @license https://www.ibitux.com/license license
 * @version XXX
 * @link https://www.ibitux.com
 * @package console\config
 */

use yii\console\controllers\MigrateController;
$config = require dirname(__DIR__, 2).'/common/config/common.php';

$config['basePath'] = dirname(__DIR__);
$config['id'] = 'blackcube/template-console';
$config['name'] = 'Blackcube template console application';
$config['aliases']['@webroot'] = dirname(__DIR__, 2).'/www';

$config['controllerNamespace'] = 'console\controllers';

$config['controllerMap'] = [
    'migrate' => [
        'class' => MigrateController::class,
        'migrationNamespaces' => [
            'app\\migrations\\'
        ],
    ],
];
// $config['params'] = [];

return $config;
