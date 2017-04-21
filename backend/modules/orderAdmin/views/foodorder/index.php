<?php
/* @var $this yii\web\View */

use app\modules\order\models\Foodorderitem;

use app\modules\orderAdmin\views\foodorder\widgets\IndexToolBar;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\bootstrap\Alert;



?>

<?php // Runs the Flash Alert and Navigation Bar ?>
<?= IndexToolBar::widget(); ?>



<h1>Food Order - Paid (Not Process Yet)</h1>

<style>
ol {
	padding: 0 0 0 15px;

}

ol li {
	margin: 2px 0;
}

.float_right {
	float: right;
	
}
.center {
	text-align:center;
}


</style>
<div class="row">
<?php 
//echo Yii::$app->params['datetimeSQL'];;
$i=1;
foreach ($models as $model) : ?>

  <?php if (($i)%5==0) echo "<div class='row'>"; ?>
  <div class="col-sm-3">
	<div class="panel panel-success">
	  <div class="panel-heading">
	  <?=$i?><strong>#<?=$model->id?> <?=$model->name?></strong> <span class='float_right'> 
		<?php echo $model->timeDiffMin($model->datetimeCreate)?> min ago</span> 
	  
	  </div>
	  <div class="panel-body">
		<ol>
		<?php $foodItems = 	Foodorderitem::getItems($model->id); ?>
		<?php foreach ($foodItems as $foodItem) :?>
			<li> <?=$foodItem->menuItem->name ?> 
			     <span class='float_right badge'><?=$foodItem->qty?></span>
			</li>
		<?php endforeach;?>
		
		</ol>
		<hr>
		<div class="center">
		<?php 
		$form = ActiveForm::begin([
					'id' => 'status-form',
					'options' => ['class' => 'form-horizontal'],
		]) 
		?>
		<?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
		
		
		<input type='submit' class='btn btn-success' name='process' value='Process'> 

		</input>
		<input type='submit' class='btn btn-warning' name='cancel' value='Cancel'>
		</button></div>
		<?php ActiveForm::end();?>
	  </div>
	</div>
  
  
  </div>


  <?php if (($i+1)%5==0) echo "</div>"; ?>

<?php $i++; endforeach; ?>
</div>
