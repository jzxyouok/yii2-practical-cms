<?php

namespace frontend\modules\order\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\order\models\Menuitem;

/**
 * MenuitemSearch represents the model behind the search form of `app\models\Menuitem`.
 */
class MenuitemSearch extends Menuitem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'menuCatID', 'status'], 'integer'],
            [['name', 'des', 'image'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Menuitem::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'menuCatID' => $this->menuCatID,
            'price' => $this->price,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'des', $this->des])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
