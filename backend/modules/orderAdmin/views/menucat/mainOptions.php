<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Menucat */

$this->title = 'Menu - Main';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menucat-view">

    <h1><?= Html::encode($this->title) ?> Options</h1>

	<?php $class = 'list-group-item list-group-item-action';?>
	<div class="list-group">

	  <?= Html::a('Menu Categories',['menucat/index'],["class"=>$class])?>
	  <?= Html::a('Menu Items',['menuitem/index'],["class"=>$class])?>

	</div>	

</div>
