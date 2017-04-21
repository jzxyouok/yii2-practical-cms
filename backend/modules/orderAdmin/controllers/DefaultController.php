<?php

namespace app\modules\orderAdmin\controllers;

use yii\web\Controller;
use Yii;
/**
 * Default controller for the `orderAdmin` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
	 
	public function beforeAction($action) {
		
		$this->layout = "/column2";
		Yii::$app->view->params['sideBar'] = $this->renderPartial('_sideBar',[],true);		
		return true;
	} 	 
	 
    public function actionIndex()
    {
        return $this->render('index');
    }
}
