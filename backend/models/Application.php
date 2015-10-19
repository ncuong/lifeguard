<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "application".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $from_date
 * @property string $to_date
 * @property string $from_hour
 * @property string $to_hour
 * @property integer $hours_off
 * @property string $title
 * @property string $content
 * @property boolean $deleted
 * @property string $date_create
 * @property string $date_update
 * @property boolean $manager_ok
 * @property boolean $hrm_ok
 * @property integer $type
 * @property integer $reason
 * @property integer $manager_id_ok
 * @property integer $hrm_id_ok
 * @property integer $calculate_date_off
 * @property boolean $manager_readed
 * @property boolean $hrm_readed
 *
 * @property UserInfo $user
 */
class Application extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'from_date', 'to_date', 'content', 'type', 'hours_off'], 'required'],
            [['user_id', 'type', 'reason', 'manager_id_ok', 'hrm_id_ok', 'manager_ok', 'hrm_ok', 'manager_readed', 'hrm_readed', 'calculate_date_off'], 'integer'],
            [['from_date', 'to_date', 'from_hour', 'to_hour', 'date_create', 'date_update'], 'safe'],
            [['content'], 'string'],
            [['deleted'], 'boolean'],
            [['hours_off'], 'hoursAllow'],
            [['hours_off'], 'match', 'pattern'=>'/^[0-9]{1,12}(\.[0-9]{0,4})?$/'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'from_hour' => 'From Hour',
            'to_hour' => 'To Hour',
            'hours_off' => 'Hours',
            'title' => 'Title',
            'content' => 'Note',
            'deleted' => 'Deleted',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'manager_ok' => 'Manager OK',
            'hrm_ok' => 'HRM OK',
            'type' => 'Type of application',
            'reason' => 'Reason',
            'manager_id_ok' => 'Manager Id Ok',
            'hrm_id_ok' => 'Hrm Id Ok',
            'calculate_date_off'=> 'Calculate the number of days leave',
            'manager_readed' => 'Manager Readed',
            'hrm_readed' => 'Hrm Readed',
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * Kiem tra gio xin trong don co phep khong
     */
    public function hoursAllow($attribute,$params)
    {
        //Neu manager or hrm ko ok thi ko can kiem tra nua.
//        if($this->manager_ok != 1 || $this->hrm_ok != 1)
//            return true;

        $reason = ReasonApplication::findOne($this->reason);

        //thoi gian cho phep cua kieu nghi phep do tinh trong 1 lan nghi phep
        if(isset($reason->time_allow) && $reason->type == 1 && ($this->hours_off > $reason->time_allow)){
            $this->addError($attribute,"The maximum time to leave is ".$reason->time_allow. "h");
        }
        //thoi gian cho phep cua kieu nghi phep do tinh trong 1 nam nghi phep
        //nghi trong truong hop khong co giay to
        if(isset($reason->time_allow) && $reason->type == 12){
            $hours = Yii::$app->db->createCommand("SELECT SUM(hours_off) AS hours FROM `application` WHERE (`user_id`=".$this->user_id.") AND (`manager_ok`=1) AND (`hrm_ok`=1) AND (`reason`=3) AND year(from_date) = ".date('Y',strtotime($this->from_date)))->queryOne();
            if($hours['hours'] == ''){
                $hours['hours'] = 0;
            }
            if($reason->time_allow < ((int)$hours['hours'] + $this->hours_off))
                $this->addError($attribute,"The maximum time to leave is ".$reason->time_allow. "h. You leave ".$hours['hours']. "h." );
        }

        //thoi gian nghi phep hang nam.
        if($this->reason == 13){
            $hours = Yii::$app->db->createCommand("SELECT SUM(hours_off) AS hours FROM `application` WHERE (`user_id`=".$this->user_id.") AND (`manager_ok`=1) AND (`hrm_ok`=1) AND (`reason`=13) AND year(from_date) = ".date('Y',strtotime($this->from_date)))->queryOne();


            $userYear = UserDate::findOne(['user_id'=>$this->user_id,'year'=>date('Y',strtotime($this->from_date))]);
            if($hours['hours'] == ''){
                $hours['hours'] = 0;
            }
            if($userYear === null){
                $this->addError($attribute,"You don't set time leave in ".date('Y',strtotime($this->from_date)).". Please contact to human resource manager");
                return;
            }
            if(($hours['hours'] + $this->hours_off) > $userYear->entitlement){
                $this->addError($attribute,"The maximum time to leave is ".$userYear->entitlement. "h in ".$userYear->year." . You leave ".$hours['hours']. "h." );
            }
        }

        //Nghi bu tru vao thoi gian lam them.
        //11: nghi bu cho gio lam them
        //12: lam them gio
        //14: chuyen gio lam them thanh tien
        if($this->reason == 11 || $this->reason == 14){
            $timeover = Yii::$app->db->createCommand("SELECT SUM(hours_off) AS hours FROM `application` WHERE (`user_id`=".$this->user_id.") AND (`manager_ok`=1) AND (`hrm_ok`=1) AND (`reason`=12)")->queryOne();
            $timeLeave = Yii::$app->db->createCommand("SELECT SUM(hours_off) AS hours FROM `application` WHERE (`user_id`=".$this->user_id.") AND (`manager_ok`=1) AND (`hrm_ok`=1) AND (`reason`=11)")->queryOne();
            $timeMoney = Yii::$app->db->createCommand("SELECT SUM(hours_off) AS hours FROM `application` WHERE (`user_id`=".$this->user_id.") AND (`manager_ok`=1) AND (`hrm_ok`=1) AND (`reason`=14)")->queryOne();
            if($timeover['hours'] == ''){
                $timeover['hours'] = 0;
            }
            if($timeLeave['hours'] == ''){
                $timeLeave['hours'] = 0;
            }
            if($timeMoney['hours'] == ''){
                $timeMoney['hours'] = 0;
            }

            if($timeover['hours'] - $timeLeave['hours'] - $timeMoney['hours'] - $this->hours_off < 0){
                $this->addError($attribute,"The overtime remaining is ".($timeover['hours'] - $timeLeave['hours'] - $timeMoney['hours']). "h. " );
            }
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserInfo::className(), ['user_id' => 'user_id']);
    }

    public function getReasonApplication()
    {
        return $this->hasOne(ReasonApplication::className(), ['id'=>'reason']);
    }

//    public static function totalHours()
//    {
//        return 100;
//    }
}
