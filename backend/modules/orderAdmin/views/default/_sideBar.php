<?php 

use yii\helpers\Html;

$class = 'list-group-item list-group-item-action';
?>

<br>
<div class="list-group">
  <div class="list-group-item list-group-item-success">
    Options
  </div>
  <?= Html::a('Main',['/orderAdmin'],["class"=>$class])?>
  <?= Html::a('Menu',['menucat/mainoptions'],["class"=>$class])?>
  <?= Html::a('Orders',['foodorder/mainoptions'],["class"=>$class])?>
  <?= Html::a('Logout',['logout'],["class"=>$class])?>
</div>
