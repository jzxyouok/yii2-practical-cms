<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Menucat */

$this->title = 'Food Orders - Main';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foodorder-view">

    <h1><?= Html::encode($this->title) ?> Options</h1>

	<?php $class = 'list-group-item list-group-item-action';?>
	<div class="list-group">

	  <?= Html::a('Display - Paid',['index'],["class"=>$class])?>
	  <?= Html::a('Display - Processed',['indexprocessed'],["class"=>$class])?>
	  <?= Html::a('Display - Shipped',['indexshipped'],["class"=>$class])?>
	 

	</div>	

</div>
