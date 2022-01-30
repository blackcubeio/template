<?php
/**
 * StaticAsset.php
 *
 * PHP version 7.1+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package webapp\assets
 */

namespace webapp\assets;

use yii\web\AssetBundle;
use yii\web\View;
use Yii;

/**
 * Base static assets
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\assets
 * @since XXX
 */
class StaticAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@webapp/assets/static';

    /**
     * @inheritdoc
     */
    public $js = [
    ];

    /**
     * @inheritdoc
     */
    public $css = [
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];

}
