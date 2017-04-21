<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\helpers\ArrayHelper;
use frontend\modules\order\models\{Menucat,Menuitem};

/* @var $this yii\web\View */
/* @var $searchModel app\models\MenuitemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menuitems';
$this->params['breadcrumbs'][] = $this->title;

//filter menu cat 
$menuCatA = ArrayHelper::map(Menucat::find()->all(),'id','name');

?>
<div class="menuitem-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Menuitem', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',

			['attribute'=>'menuCatID',
			 'value'=>function ($model) { return $model->menucat->name; },
			 'filter'=> $menuCatA
			 ],
			
            'name',
            'des',
            'price',
            // 'image',
            ['attribute'=>'status',
			 'value'=>function ($model) { return $model->getStatus($model->status); },
			 'filter'=> Menuitem::getStatus()
			 ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
