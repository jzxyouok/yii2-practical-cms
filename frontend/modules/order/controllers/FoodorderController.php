<?php

namespace app\modules\order\controllers;

use Yii;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use frontend\modules\order\components\{IpnListener,NexmoMessage};


use frontend\modules\order\models\{FoodOrder,Menuitem,Foodorderitem,Customer,SavedVar};

/**
 * FoodorderController implements the CRUD actions for FoodOrder model.
 */
class FoodorderController extends Controller
{
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

	/*turn off csrf validation for paypal */
	public function beforeAction($action)
	{            
		if ($action->id == 'paypal_return' ||
			$action->id == 'paypal_ipn'
			
			) {
			$this->enableCsrfValidation = false;
		}

		return parent::beforeAction($action);
	}	
	
	
    /**
     * Lists all FoodOrder models.
     * @return mixed
     */
	// The Menu Page  
    public function actionMenu()
    {
		$savedVarM = new SavedVar();
		$isOpen = $savedVarM->get('isOpen');
		
		$models= MenuItem::find()->where(['status'=>1])->all();
		
		
		return $this->render('menu',['models'=>$models,'isOpen'=>$isOpen]);
    }

    /**
     * Displays a single FoodOrder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FoodOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
		
	 
    public function actionCreate()
    {
        $model = new FoodOrder();

        if ($model->load(Yii::$app->request->post())) {
			//if customer not exist create one 
			
			if(!Customer::isCustomer($model->email)) {
				$customerM = new Customer;
				$customerM->name = $model->name;
				$customerM->email = $model->email;
				$customerM->address = $model->address;
				$customerM->contactNo = $model->contactNo;
				$customerM->pass = Customer::getKey();
				$customerM->save();
			}
			
			
			
			$model->status = FoodOrder::$STATUS_PAID;
			$model->datetimeCreate = Yii::$app->params['datetimeSQL'];
			$model->save();

			//gets from session 
			$session = Yii::$app->session;
			$items = json_decode($session['items']);
			Foodorderitem::addItems($model->id,$items);
			
			
			// SMS send 1 to customer , 1 to kitchen 
			
			// Send an email 
			
							 
			;
			// forwards to paypal 
			/*$model = FoodOrder::findOne(1);
			
			return $this->render('paypal',[
						'model'=>$model
				]);
			*/
	
			
            return $this->redirect(['/orderAdmin/foodorder/index']);
        } else {
			
			$session = Yii::$app->session;
			if($session->isActive) $session->open;
			$model->deliveryFee = $session['deliveryAmt'];
            
			return $this->render('create', [
                'model' => $model,
				
			]);
        }
    }
	
	public function actionPaypal_return() {
		/* $sms = new NexmoMessage ('fa39000d','bc6a995b');
		
		$to = '6596674603';
		$from = 'WESVAULT';
		$msg = 'NEXMO TEST';
		$sms->sendText ( $to,$from,$msg ); */
		return $this->render('paypalReturn');
	}
	
	public function actionPaypal_cancel() {
		return $this->render('paypalCancel');
	}
	
	public function actionPaypal_ipn() {

		$listener = new IpnListener();
		try {
				$listener->requirePostMethod();
				$verified = $listener->processIpn();
			} catch (Exception $e) {
				error_log($e->getMessage());
				exit(0);
			}	
	

			if ($verified) {
			// 1 update paypal info txn
				$txn = 'txn123';
				$id = '1';
				$model = FoodOrder::findOne($id);
				$model->txn = $txn;
				
			// change status to $STATUS_PAID 	
				$model->status = FoodOrder::$STATUS_PAID;
				$model->datetimeCreate = Yii::$app->params['datetimeSQL'];
				$model->save();		
			
			// sms SMS 
			

			} else {
			//show error
			}	
		
	}

    /**
     * Updates an existing FoodOrder model.
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
     * Deletes an existing FoodOrder model.
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
     * Finds the FoodOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FoodOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FoodOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
