<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserDate;

/**
 * UserDateSearch represents the model behind the search form about `backend\models\UserDate`.
 */
class UserDateSearch extends UserDate
{
    public $full_name = "";
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'year', 'entitlement', 'balance'], 'integer'],
            [['full_name'], 'safe'],
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
        $query = UserDate::find();
        $query->select('user_info.*,id, year, entitlement, entitlement - (SELECT SUM(hours_off) AS hours FROM `application` WHERE manager_ok = 1 AND hrm_ok = 1 AND application.user_id = user_info.user_id AND reason = 13 AND YEAR(from_date) = user_date.`year`) AS balance');
        $query->joinWith(['user']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'year' => $this->year,
            'entitlement' => $this->entitlement,
            'balance' => $this->balance,
        ]);
        $query->andFilterWhere(['like','user_info.full_name',$this->full_name]);

        return $dataProvider;
    }

    public function searchUser($params,$user_id)
    {
        $query = UserDate::find();
        $query->select('user_info.*, year, entitlement, entitlement - (SELECT SUM(hours_off) AS hours FROM `application` WHERE user_id = '.$user_id.' AND manager_ok = 1 AND hrm_ok = 1 AND reason = 13 AND YEAR(from_date) = user_date.`year`) AS balance');
        $query->joinWith(['user']);
        $query->where(['user_date.user_id'=>$user_id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'year' => $this->year,
            'entitlement' => $this->entitlement,
            'balance' => $this->balance,
        ]);

        return $dataProvider;
    }
}