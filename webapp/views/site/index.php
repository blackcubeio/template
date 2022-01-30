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
 * @package webapp\views\site
 *
 * @var $items \blackcube\core\models\MenuItem[]
 * @var $this yii\web\View
 */

use blackcube\core\web\helpers\Html;
use yii\helpers\Url;
use webapp\assets\StaticAsset;

$baseUrl = StaticAsset::register($this)->baseUrl;

?>
site / index
