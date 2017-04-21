<?php

namespace frontend\modules\order\models;

use Yii;

/**
 * This is the model class for table "foodorder".
 *
 * @property int $id
 * @property string $name
				 
 * @property string $contactNo
 * @property string $address
 * @property string $remark
 * @property string $itemTotal
 * @property string $gst
 * @property string $total
 * @property string $datetimeCreate
 * @property string $datetimeClose
 * @property int $status
 */
class Foodorder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	

	//delivery 
	static public $deliveryFee;         #model to form 
	 
	public static $STATUS_OPEN = 0;
	public static $STATUS_PAID = 1;
	public static $STATUS_CANCEL = 2;
	public static $STATUS_PROCESS = 3;
	public static $STATUS_SHIPPED = 4; 
	public static $timeF = 'H:i'; 
	public static $timeF_short = 'H:i j-M'; 
	public static $timeF_long = 'H:i, d M Y'; 
	
	// cost
	public static $gst = 0.00; 
	public static $deliveryFeeLocalSmall = 5;
	public static $deliveryFeeLocalBig = 0; 
	public static $deliveryFeeAll = 15;
	public static $min_amount = 30;
	
	// Paypal Config
	
	// Set to sandbox 
	public static $paypalUrl = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	//public static $paypalUrl = 'https://www.paypal.com/cgi-bin/webscr';
	
	public static $paypalEmail = 'admin-facilitator@wesvault.com';
	public static $paypalBusinessName = 'admin-facilitator@wesvault.com';
	public static $paypalCurrency = 'SGD';
	public static $paypalItemName = 'India House Food Order';

	
	public static $paypalReturn = '';
	public static $paypalCancel = '';
	public static $paypalIPN = '';

	
	//Email 
	
	public static $emailFrom = '';
	public static $storeName = '';
	


	
    public static function tableName()
    {
        return 'foodorder';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contactNo', 'name','email','address', 'itemTotal', 'gst', 'total'], 'required'],
            [['status'], 'integer'],
            [['itemTotal', 'gst', 'total'], 'number'],
            [['datetimeCreate', 'datetimeClose'], 'safe'],
            [['contactNo'], 'string', 'max' => 20],
            [['address','email'], 'string', 'max' => 80],
            [['remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
			'name'=>'Your Name',
			'email'=>'Email',
            'contactNo' => 'Contact No',
            'address' => 'Delivery Address',
            'remark' => 'Remarks',
            'itemTotal' => 'Item Total',
			'deliveryFee' => 'delivery Fee',
            'gst' => 'Gst',
            'total' => 'Total',
            'datetimeCreate' => 'Datetime Create',
            'datetimeClose' => 'Datetime Close',
            'status' => 'Status',
        ];
    }
	
	public function datetimeCreateF() {
		return date(Foodorder::$timeF_short,strtotime($this->datetimeCreate));
	}
	
	public function datetimeCloseF() {
		return \Yii::$app->formatter->asTime($this->datetimeClose,'short');
	}
	
	public function timeDiffMin($sqlDateTime) {
		$start = strtotime($sqlDateTime);
		
		$now = strtotime(Yii::$app->params['datetimeSQL']);
		$diff = round(abs($now-$start) / 60);
		return $diff;
	}
	
	public static function moneyF($amt) {
		return Yii::$app->formatter->asDecimal($amt,2);
	}
	
	// Send Paid Email 
	
	public static function sendPaidEmail($model) {
		
		$emailVars = [  
						
		
					  ];
		
		Yii::$app->mailer->compose('paid', $emailVars)
							 ->setFrom(FoodOrder::$emailFrom)
							 ->setTo($model->email)
							 ->setSubject(FoodOrder::$storeName.'- You have made an order')
							 ->send();
	}
	
	
}
