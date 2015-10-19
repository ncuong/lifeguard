<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Application;


/**
 * ApplicationSearch represents the model behind the search form about `backend\models\Application`.
 */
class ApplicationSearch extends Application
{
    /**
     * @inheritdoc
     */
    public $full_name = "";

    public function rules()
    {
        return [
            [['id', 'user_id', 'type', 'reason', 'manager_id_ok', 'hrm_id_ok', 'manager_ok', 'hrm_ok', 'calculate_date_off', 'manager_readed', 'hrm_readed'], 'integer'],
            [['full_name','from_date', 'to_date', 'from_hour', 'to_hour', 'title', 'content', 'date_create', 'date_update'], 'safe'],
            [['deleted'], 'boolean'],
            [['hours_off'], 'match', 'pattern'=>'/^[0-9]{1,12}(\.[0-9]{0,4})?$/'],
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

        $query = Application::find();
        $query->joinWith(['user','reasonApplication']);
        $query->where(array('application.user_id'=>Yii::$app->user->id));
        $query->orderBy(['from_date'=>SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->from_date = Yii::$app->request->get('from_date');
        $this->to_date = Yii::$app->request->get('to_date');

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'from_hour' => $this->from_hour,
            'to_hour' => $this->to_hour,
            'hours_off' => $this->hours_off,
            'date_create' => $this->date_create,
            'date_update' => $this->date_update,
            'type' => $this->type,
            'reason' => $this->reason,
            'manager_ok' => $this->manager_ok,
            'hrm_ok' => $this->hrm_ok,
        ]);
        //--- Date
        if($this->from_date != '')
        {
            $query->andWhere("from_date >= '".$this->from_date."' ");
        }
        if($this->to_date != ''){
            $query->andWhere("to_date <= '".$this->to_date."' ");
        }
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);
        return $dataProvider;
    }

    public function searchApplicationOfRoom($params,$id)
    {
        $query = Application::find();
        $query->joinWith(['user','reasonApplication']);
        if(Yii::$app->user->can('manager')){
            $query->where(['manager'=>$id]);
            $query->andwhere('reason_application.type_id != -11');//Ko xem cac don xin chuyen tien
            $query->orderBy = ['manager_readed'=>SORT_ASC,'from_date'=>SORT_DESC];
        }
        if(Yii::$app->user->can('hrm')){
            //$query->andWhere(['manager_ok'=>1]);
            $query->orderBy = ['hrm_readed'=>SORT_ASC,'from_date'=>SORT_DESC];
        }

        if(Yii::$app->user->can('director')){
            $query = Application::find();
            $query->joinWith(['user','reasonApplication']);
            $query->where(['manager'=>$id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->from_date = Yii::$app->request->get('from_date');
        $this->to_date = Yii::$app->request->get('to_date');

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'from_hour' => $this->from_hour,
            'to_hour' => $this->to_hour,
            'hours_off' => $this->hours_off,
            'deleted' => $this->deleted,
            'date_create' => $this->date_create,
            'date_update' => $this->date_update,
            'type' => $this->type,
            'reason' => $this->reason,
            'calculate_date_off' => $this->calculate_date_off,
            'manager_readed' => $this->manager_readed,
            'hrm_readed' => $this->hrm_readed,
        ]);
        //--- Manager
        //Accept
        if($this->manager_ok != -1){
            $query->andFilterWhere(['manager_ok'=>$this->manager_ok]);
        }
        //Waiting
        else
            $query->andFilterWhere(['manager_readed'=>-1]);

        //---- HRM
        //Accept
        if($this->hrm_ok != -1){
            $query->andFilterWhere(['hrm_ok'=>$this->hrm_ok]);
        }
        //Waiting
        else
            $query->andFilterWhere(['hrm_readed'=>-1]);

        //--- Date
        if($this->from_date != '')
        {
            $query->andWhere("from_date >= '".$this->from_date."' ");
        }
        if($this->to_date != ''){
            $query->andWhere("to_date <= '".$this->to_date."' ");
        }
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like','user_info.full_name',$this->full_name])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
