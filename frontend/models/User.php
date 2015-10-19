<?php

namespace frontend\models;

use Yii;
use common\models\User as commonUser;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $code
 * @property string $referrer
 * @property string $first_name
 * @property string $last_name
 * @property integer $sex
 * @property integer $graduate_high_school
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $mobile
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property UserTbEmail[] $userTbEmails
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['sex', 'graduate_high_school', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['code', 'first_name', 'last_name', 'mobile'], 'string', 'max' => 100],
            [['referrer'], 'string', 'max' => 10],
            [['city', 'state'], 'string', 'max' => 1000],
            [['zip'], 'string', 'max' => 500],
            [['auth_key'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'code' => 'Code',
            'referrer' => 'Referrer',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'sex' => 'Sex',
            'graduate_high_school' => 'Graduate High School',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'mobile' => 'Mobile',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTbEmails()
    {
        return $this->hasMany(UserTbEmail::className(), ['user_id' => 'id']);
    }

    public function getUserReferrer($code)
    {

        $query = commonUser::find();
        $query->where('status != '. commonUser::STATUS_DELETED);
        $query->andwhere('id != '.Yii::$app->user->id);
        $query->andwhere(['referrer'=>$code]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
        if($dataProvider->getCount()>0){
            return ['dataProvider'=>$dataProvider,'code'=>$code,'parent_checked'=>0];
        }
        return "NULL";
    }
}
