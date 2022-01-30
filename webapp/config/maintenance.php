<?php
/**
 * maintenance.php
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

$result = null;
if (YII_MAINTENANCE === true) {
    $allowedIp = preg_split('/\s*,\s*/', getstrenv('YII_MAINTENANCE_ALLOWED_IPS'));
    if (in_array($_SERVER['REMOTE_ADDR'], $allowedIp) === false) {
        $result = ['technical/maintenance'];
    }
}

return $result;
