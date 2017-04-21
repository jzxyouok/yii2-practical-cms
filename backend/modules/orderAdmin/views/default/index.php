<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Menucat */

?>
<div class="orderadmin-mainOptions">

    <h1><?= Html::encode($this->title) ?> Options</h1>

	<?php $class = 'list-group-item list-group-item-action';?>
	<div class="list-group">

	  <?= Html::a('Edit Admin Account',['index'],["class"=>$class])?>
	  <?= Html::a('Manage Customers',['customer/'],["class"=>$class])?>

	 

	</div>	

</div>
