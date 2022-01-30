<?php
/**
 * index.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package www
 */

use yii\web\Application;

// init autoloaders
require dirname(__DIR__).'/vendor/autoload.php';

require dirname(__DIR__).'/common/config/bootstrap.php';

require dirname(__DIR__).'/vendor/yiisoft/yii2/Yii.php';

$config = require dirname(__DIR__).'/webapp/config/main.php';

(new Application($config))->run();
