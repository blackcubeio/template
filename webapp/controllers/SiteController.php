<?php
/**
 * SiteController.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package webapp\controllers
 */

namespace webapp\controllers;

use yii\web\Controller;
use blackcube\core\web\actions\SitemapAction;
use Yii;

/**
 * SiteController class
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package webapp\controllers
 * @since XXX
 */
class SiteController extends Controller
{

    /**
     * @return \yii\web\Response|string
     * @since XXX
     */
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }
}
