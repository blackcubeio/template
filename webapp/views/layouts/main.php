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
 * @package webapp\views\layouts
 *
 * @var $this yii\web\View
 * @var $content string
 */

use yii\helpers\Html;
use yii\helpers\Url;
use webapp\assets\StaticAsset;
use webapp\assets\WebpackAsset;

WebpackAsset::register($this);
$baseUrl = StaticAsset::register($this)->baseUrl;
$this->beginPage(); ?><!DOCTYPE html>
<?php echo Html::beginTag('html', ['lang' => Yii::$app->language]); ?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php echo Html::tag('meta', '', ['name' => 'X-Version', 'content' => Yii::$app->version]); ?>
        <title>
            <?php echo empty($this->title) ? 'Template website' : $this->title; ?>
        </title>
        <?php $this->head(); ?>
    </head>
    <body>
        <?php $this->beginBody(); ?>
        <main>
            <?php echo $content; ?>
        </main>
        <?php $this->endBody(); ?>
    </body>
<?php echo Html::endTag('html'); ?>
<?php $this->endPage();
