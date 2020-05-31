<?php
/**
 * TechnicalController.php
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
use Yii;

/**
 * TechnicalController class
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package webapp\controllers
 * @since XXX
 */
class TechnicalController extends Controller
{
    /**
     * @return string|yii\web\Response
     * @since XXX
     */
    public function actionMaintenance()
    {
        return $this->render('maintenance', [
        ]);
    }

    /**
     * @return string|yii\web\Response
     * @since XXX
     */
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        } else {
            return $this->render('generic-error', []);
        }
    }
}
