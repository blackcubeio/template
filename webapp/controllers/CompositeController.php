<?php
/**
 * CompositeController.php
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

use blackcube\core\web\controllers\BlackcubeController;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use blackcube\core\web\actions\SitemapAction;
use blackcube\core\models\Category;
use blackcube\core\models\Slug;
use blackcube\core\models\Composite;
use Yii;

/**
 * CompositeController class
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package webapp\controllers
 * @since XXX
 */
class CompositeController extends BlackcubeController
{

    /**
     * @return \yii\web\Response|string
     * @since XXX
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'composite' => $this->getElement()
        ]);
    }

}
