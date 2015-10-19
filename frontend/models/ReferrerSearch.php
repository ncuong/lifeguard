<?php
/**
 * Created by PhpStorm.
 * User: VIETBINH
 * Date: 10/6/15
 * Time: 9:14 AM
 */

namespace frontend\models;

use Faker\Provider\cs_CZ\DateTime;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;


/**
 * ApplicationSearch represents the model behind the search form about `backend\models\Application`.
 */
class ReferrerSearch extends User
{
    public $full_name;
    public $from_date;
    public $to_date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code','from_date','to_date','first_name' ,'referrer','email','sex','graduate_high_school', 'city','state','zip','mobile','status'],'safe']
        ];
    }

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

        $query = User::find();
//        $query->joinWith(['user','reasonApplication']);
        $query->where('status != '.User::STATUS_DELETED);
        $query->andwhere('id != '.Yii::$app->user->id);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => [
                            'created_at' => SORT_DESC,
                            'first_name' => SORT_ASC,
                            ]
                    ]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'state' => $this->state,
            'sex' => $this->sex,
            'zip'=>$this->zip,
            'code'=>$this->code,
            'referrer'=>$this->referrer,
            'graduate_high_school'=>$this->graduate_high_school

        ]);
        if($this->status != null){
            $query->andFilterWhere(['status'=>$this->status]);
        }
        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->orFilterWhere(['like', 'last_name', $this->first_name]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'city', $this->city]);
        $query->andFilterWhere(['like', 'mobile', $this->mobile]);
        return $dataProvider;
    }

    public function searchTreeView($params)
    {
        $user = User::findIdentity(Yii::$app->user->id);
        $query = User::find();
        $query->where('status != '.User::STATUS_DELETED);
//        $query->andwhere('id != '.Yii::$app->user->id);

        $query->andwhere('referrer IS NULL OR referrer = "'.$user->code.'" ');

//        if($params == null){
//            $query->andwhere(['referrer'=>$user->code]);
//
//        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => [
                'created_at' => SORT_DESC,
                'first_name' => SORT_ASC,
            ]
            ]
        ]);


        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'state' => $this->state,
            'sex' => $this->sex,
            'zip'=>$this->zip,
            'code'=>$this->code,
            'referrer'=>$this->referrer,
            'graduate_high_school'=>$this->graduate_high_school

        ]);
        if($this->status != null){
            $query->andFilterWhere(['status'=>$this->status]);
        }
        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->orFilterWhere(['like', 'last_name', $this->first_name]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'city', $this->city]);
        $query->andFilterWhere(['like', 'mobile', $this->mobile]);
        return $dataProvider;
    }

    public function reportOne($params)
    {
        $query = User::find();
//        $query->joinWith(['user','reasonApplication']);
        $query->where('status != '.User::STATUS_DELETED);
        $query->andwhere('id != '.Yii::$app->user->id);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => [
                'created_at' => SORT_DESC,
                'first_name' => SORT_ASC,
            ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'state' => $this->state,
            'sex' => $this->sex,
            'zip'=>$this->zip,
            'code'=>$this->code,
            'referrer'=>$this->referrer,
            'graduate_high_school'=>$this->graduate_high_school

        ]);
        if($this->status != null){
            $query->andFilterWhere(['status'=>$this->status]);
        }

        if($this->from_date != '' && $this->from_date != null){
            $date = str_replace('/', '-', $this->from_date);
            $query->andWhere("DATE_FORMAT(FROM_UNIXTIME(created_at), '%Y-%m-%d') >= '".date('Y-m-d', strtotime($date))."' ");
        }
        if($this->to_date != '' && $this->to_date !=null){
            $date = str_replace('/', '-', $this->to_date);
            $query->andWhere("DATE_FORMAT(FROM_UNIXTIME(created_at), '%Y-%m-%d') <= '".date('Y-m-d', strtotime($date))."' ");
        }

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->orFilterWhere(['like', 'last_name', $this->first_name]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'city', $this->city]);
        $query->andFilterWhere(['like', 'mobile', $this->mobile]);
        return $dataProvider;
    }
}
