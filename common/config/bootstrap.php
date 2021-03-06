<?php
/**
 * bootstrap.php
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
use Dotenv\Dotenv;

/**
 * @param string $name environment var
 * @return bool
 */
function getboolenv($name) {
    $value = $_ENV[$name] ?? ($_SERVER[$name] ?? false);
    return filter_var($value, FILTER_VALIDATE_BOOLEAN);
}

/**
 * @param string $name environment var
 * @param string $default default value
 * @return string
 */
function getstrenv($name, $default = '') {
    $value = $_ENV[$name] ?? ($_SERVER[$name] ?? false);
    return $value === false ? $default : $value;
}

/**
 * @param string $name environment var
 * @param int $default default value
 * @return int
 */
function getintenv($name, $default = 0) {
    $value = $_ENV[$name] ?? ($_SERVER[$name] ?? false);
    if ($value !== false) {
        $value = filter_var($value, FILTER_VALIDATE_INT);
    }
    return $value === false ? (int)$default : $value;
}

try {
    $dotEnv = Dotenv::createImmutable(dirname(__DIR__, 2));
    $dotEnv->safeLoad();
    $dotEnv->required([
        'YII_ENV',
        'APP_VERSION',
        'DB_DRIVER',
        'DB_DATABASE',
        'DB_USER',
        'DB_HOST',
        'DB_PORT',
        'DB_PASSWORD',
        'DB_SCHEMA',
//        'DB_TABLE_PREFIX',
    ]);
    $dotEnv->required('YII_COOKIE_VALIDATION_KEY')->notEmpty();
    $dotEnv->required('DB_DRIVER')->allowedValues(['mysql', 'pgsql']);
    $dotEnv->required('DB_SCHEMA_CACHE')->isBoolean();
    $dotEnv->required('DB_SCHEMA_CACHE_DURATION')->isInteger();
    $dotEnv->required('FILESYSTEM_TYPE')->allowedValues(['local', 's3']);
    $dotEnv->required('FILESYSTEM_CACHE')->isBoolean();
    $dotEnv->required('FILESYSTEM_CACHE_DURATION')->isInteger();
    if (getenv('FILESYSTEM_TYPE') === 's3') {
        $dotEnv->required([
            'FILESYSTEM_S3_KEY',
            'FILESYSTEM_S3_SECRET',
            'FILESYSTEM_S3_BUCKET',
            'FILESYSTEM_S3_ENDPOINT',
            'FILESYSTEM_S3_PATH_STYLE'
        ])->notEmpty();
    } elseif (getenv('FILESYSTEM_TYPE') === 'local') {
        $dotEnv->required([
            'FILESYSTEM_LOCAL_PATH'
        ])->notEmpty();
    }
    if (getboolenv('REDIS_ENABLED')) {
        $dotEnv->required('REDIS_HOST');
        $dotEnv->required('REDIS_PORT')->isInteger();
        $dotEnv->required('REDIS_DATABASE')->isInteger();
    }
} catch (Exception $e) {
    die('Application not configured');
}

// get wanted debug
$debug = getboolenv('YII_DEBUG');
if ($debug === true) {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

// get if app is in maintenance mode
$maintenance = getboolenv('YII_MAINTENANCE');
defined('YII_MAINTENANCE') or define('YII_MAINTENANCE', $maintenance);

$currentEnvironment = getstrenv('YII_ENV');
defined('YII_ENV') or define('YII_ENV', $currentEnvironment);
