<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $full_name
 * @property string $code
 * @property string $referrer
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $mobile
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_name'], 'required'],
            [['code','referrer','address','city','state','zip','mobile'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'full_name' => 'Full Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'position' => 'Position',
            'manager' => 'Manager',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserinfo()
    {
        return $this->hasOne(UserInfo::className(), ['user_id' => 'manager']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserDates()
    {
        return $this->hasMany(UserDate::className(), ['user_id' => 'user_id']);
    }
}
