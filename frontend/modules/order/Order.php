<?php

namespace app\modules\order;

/**
 * order module definition class
 
 * swift mailer 
 		'mailer' => [
					'class' => 'yii\swiftmailer\Mailer',
				],	
 
 */
class Order extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\order\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
