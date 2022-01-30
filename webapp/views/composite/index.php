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
 * @package webapp\views\composite
 *
 * @var $article \blackcube\core\models\Composite
 * @var $this yii\web\View
 */

use yii\helpers\Html;
use yii\helpers\Url;
use webapp\assets\StaticAsset;

$baseUrl = StaticAsset::register($this)->baseUrl;
?>
composite / index
<?php foreach($article->getBlocs()->active()->each() as $bloc): ?>
    <?php /* @var $bloc \blackcube\core\models\Bloc */ ?>
    <?php // display blocs ?>
<?php endforeach; ?>
