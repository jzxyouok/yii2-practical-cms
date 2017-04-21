<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\Session;

use frontend\modules\order\models\FoodOrder;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile("https://unpkg.com/vue/dist/vue.js",['position'=>\yii\web\View::POS_HEAD]);

?>

<style>
ul li {
	padding:10px;
}

</style>
<div class="food-order-index">

    <h1><?= Html::encode($this->title) ?></h1>


  <div id="app">


	<ul>
	<?php foreach ($models as $model) : ?>
	
	<li> <strong><?=$model->name?></strong> <br> <?=$model->des?> <br>
	<button class='btn btn-primary' v-on:click='subItem(<?=$model->id?>,<?=$model->price?>)'>Remove Me</button>
	<button class='btn btn-danger' v-on:click='addItem(<?=$model->id?>,"<?=$model->name?>",<?=$model->price?>)'>Add Me</button>
	</li>
	<?php endforeach;?>
	
	</ul>
	Items: {{items}}
	<ul class="list-group">
		<li class="list-group-item" v-for="item in items">
		Itemname {{item.itemName}} , #{{item.itemID}} ,  Qty: {{item.qty}} 
		</li>
	</ul>
	<br>
	
	<p> Delivery is free if in local and order > $30<p>
	<p> $5 if in local. </p>
	<p> For All other orders. Delivery is $15. </p>
	<br> <br>
	
	<p> <h2> The online ordering is currently <?=$isOpen?> </h2></p>
	<p> <strong>Total:</strong> {{subTotal}}</p>
	
	<p> <input type='checkbox' v-model="checked" id='checkbox' > I live in Tanjong Rhu </input> </p>
	
	<p> <style>Delivery Charges: </style>{{getTotal}} </p>
	<br>
	<p> <strong>Grand Total:</strong> {{getGrandTotal}}
	
	<?php 
		
		$items = @$_POST['items'];
		$session = Yii::$app->session;
		if($session->isActive) $session->open;
		
		
		$session['items'] = $items;
		$session['deliveryAmt'] = @$_POST['deliveryAmt'];
		$items = json_decode($items);
		print_r($items[0]);
		echo (@$_POST['deliveryAmt']);
		
		
		
	?>
	<?=Html::beginForm('','post')?>
	<input type='hidden' name='items' v-bind:value="JSON.stringify(items)"></input>
	<input type='hidden' name='deliveryAmt' v-bind:value="deliveryAmt"></input>
	<?=Html::submitButton()?>
	<?=Html::endForm()?>
   <br>
   <?= Html::a('order',['create'])?>
  </div>

  <script>
  
  function inArray(items,itemID) {
	for (var i=0; i< items.length; i++){
		if(items[i].itemID==itemID) return i;
	}
	return false;
  }
  
  
  
var vm = new Vue({
      el: '#app',
      data: {
		items: [],
		subTotal: 0,
		checked: 0,
		deliveryAmt: 0,
		grandTotal: 0,

      },
	  
      methods: {
		submit : function () {
				alert(JSON.stringify(this.items))
		},
	  
	  
		addItem: function (itemID,itemName,price) {
					
					var itemIndex = inArray(this.items,itemID)
					//alert(itemIndex)
					if(itemIndex === false) {
						this.items.push({'itemID':itemID, 'itemName':itemName, qty:1})
					}
					else {
						this.items[itemIndex].qty = this.items[itemIndex].qty + 1 
					}
					
					this.subTotal = this.subTotal + price;
				},
		subItem: function (itemID,price) {
					var itemIndex = inArray(this.items,itemID)
					//alert(itemIndex)
					if(itemIndex === false) {
					}
					else {
						
						if(this.items[itemIndex].qty === 1) {
							//alert('Splice Array')
							this.items.splice(itemIndex,1);
						}
						else {
						this.items[itemIndex].qty = this.items[itemIndex].qty - 1 
						}
					this.subTotal = this.subTotal - price;		
					}
				
			},

		showme : function(){
			alert (checked)
			
		}
	  },
	  
	  computed: {
		 getTotal: function() {
			 var deliveryAmt;
			 if (this.checked==false) deliveryAmt = <?= FoodOrder::$deliveryFeeAll ?>;
			 else if (this.subTotal>30) deliveryAmt = <?= FoodOrder::$deliveryFeeLocalBig?>;
			 else deliveryAmt = <?= FoodOrder::$deliveryFeeLocalSmall?>;
			 
			 this.deliveryAmt = deliveryAmt;
			 return this.deliveryAmt;

				 
		 },
	  
	     getGrandTotal: function() {
			this.grandTotal = this.subTotal + this.deliveryAmt;	
			return this.grantTotal;
		 }
			 
	  }
	  

    })
  </script>

</div>