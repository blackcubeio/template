<?php
/**
 * InitController.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package console\controllers
 */

namespace console\controllers;

use yii\console\Controller;
use yii\console\ExitCode;
use Yii;

/**
 * InitController class
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package console\controllers
 */
class InitController extends Controller {


    /**
     * Init application
     * @return int
     */
    public function actionIndex()
    {
        $this->stdout('Blackcube template'."\n");
        return ExitCode::OK;
    }

}
