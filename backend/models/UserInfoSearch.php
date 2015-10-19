<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserInfo;

/**
 * UserInfoSearch represents the model behind the search form about `backend\models\UserInfo`.
 */
class UserInfoSearch extends UserInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'manager'], 'integer'],
            [['first_name', 'last_name', 'full_name', 'phone', 'email', 'position'], 'safe'],
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
        $query = UserInfo::find()
            ->from(UserInfo::tableName() . ' t')
            ->joinWith(['userinfo' => function ($q) {
                    $q->from(UserInfo::tableName() . ' parent');
                }]);
        if(Yii::$app->user->can('manager')){
            $query->where(array('t.manager'=>Yii::$app->user->id));
        }
        if(Yii::$app->user->can('hrm')){
            $query->leftJoin('auth_assignment', 't.user_id = auth_assignment.user_id');
            $query->where('auth_assignment.item_name <> "admin" ');
        }

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
            'user_id' => $this->user_id,
            'manager' => $this->manager,
        ]);

        $query->andFilterWhere(['like', 't.first_name', $this->first_name])
            ->andFilterWhere(['like', 't.last_name', $this->last_name])
            ->andFilterWhere(['like', 't.full_name', $this->full_name])
            ->andFilterWhere(['like', 't.phone', $this->phone])
            ->andFilterWhere(['like', 't.email', $this->email])
            ->andFilterWhere(['like', 't.position', $this->position]);

        return $dataProvider;
    }
}
