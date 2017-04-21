<?php
/* This is a class to work with local variables without a database */

namespace frontend\modules\order\models;

use Yii;
use yii\helpers\Url;
use yii\base\Object;
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
class Savedvar {


	
	private static function getFile() {
		return Url::to('@app/config/savedvar.txt');
		
	}

	
	// load the variable into obj 
	public function load() {
		$file = Savedvar::getFile();
		if(!file_exists($file)) file_put_contents($file, '');

		return json_decode(file_get_contents($file), true);
		
	}
	
	// save var 
	
	public static function put($key,$value) {
		$a = Savedvar::load();
		
		@$a[$key] = $value; 
		$str = json_encode($a);
		file_put_contents(Savedvar::getFile(),$str);
	}
	
	public static function get($key) {
		$a = Savedvar::load();
		if(isset($a[$key])) return $a[$key];
		else return '';
	}
	
	public static function flush() {
		file_put_contents(Savedvar::getFile(), "");
	}
	
}