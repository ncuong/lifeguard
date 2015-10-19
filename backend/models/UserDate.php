<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_date".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $year
 * @property integer $entitlement
 * @property integer $balance
 *
 * @property Application[] $applications
 * @property UserInfo $user
 */
class UserDate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_date';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'year', 'entitlement'], 'required'],
            [['user_id', 'year', 'entitlement'], 'integer']
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
            'year' => 'Year',
            'entitlement' => 'Entitlement',
            'balance' => 'Balance',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['user_date_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserInfo::className(), ['user_id' => 'user_id']);
    }
}
