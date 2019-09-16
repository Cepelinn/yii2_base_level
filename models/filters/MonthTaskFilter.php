<?php


namespace app\models\filters;

use yii\base\Model;
use app\models\tables\Tasks;
use yii\data\ActiveDataProvider;

class MonthTaskFilter extends Tasks
{
    public function rules()
    {
        return [
          ['deadline', 'string']
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params){

        $query = Tasks::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())){
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'deadline', $this->deadline]);

        return $dataProvider;
    }
}