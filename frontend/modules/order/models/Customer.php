<?php

namespace frontend\modules\order\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $email
 * @property string $contactNo
 * @property string $pass
 */
class Customer extends \yii\db\ActiveRecord
{
    static private $keyLength = 6;
	
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'email', 'contactNo', 'pass'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 150],
            [['contactNo'], 'string', 'max' => 25],
            [['pass'], 'string', 'max' => 7],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'email' => 'Email',
            'contactNo' => 'Contact No',
            'pass' => 'Pass',
        ];
    }
	
	// 1 = yes 0 = no; 
	public function isCustomer($email) {
		$model = Customer::findOne(['email'=>$email]);
		if($model!==null) return true;
		else false;
		
	}
	
	public function getKey() {
		$length = Customer::$keyLength; 
	
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
		}
    return $randomString;
	}		
	
}
