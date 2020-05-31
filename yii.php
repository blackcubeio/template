<?php
/**
 * yii.php
 *
 * PHP version 5.6+
 *
 * Initial console script
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package base
 */

use yii\console\Application;

// fcgi doesn't have STDIN and STDOUT defined by default
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));

// init autoloaders
require __DIR__.'/vendor/autoload.php';

require __DIR__.'/common/config/bootstrap.php';

require __DIR__.'/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__.'/console/config/main.php';
$exitCode = (new Application($config))->run();
exit($exitCode);
