<?php


namespace app\modules\orderAdmin\controllers;

use Yii;
use frontend\modules\order\models\Menucat;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenucatController implements the CRUD actions for Menucat model.
 */
class MenucatController extends Controller
{
 
	public function beforeAction($action) {
		
		$this->layout = "/column2";
		Yii::$app->view->params['sideBar'] = $this->renderPartial('/default/_sideBar',[],true);		
		Yii::$app->view->params['breadcrumbs'][] = ['url'=>['/orderAdmin/menucat/mainoptions'],
													'label'=>'Menu Options'];	
		return true;
	} 

 /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menucat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Menucat::find()->orderBy('sortOrder'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionMainoptions() {
		return $this->render('mainoptions');
	}


    /**
     * Creates a new Menucat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menucat();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

	public function actionView($id) {
		
		return $this->redirect(['menuitem/index','MenuitemSearch[menuCatID]'=>$id]);
		
	}
    /**
     * Updates an existing Menucat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Menucat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Menucat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menucat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menucat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
