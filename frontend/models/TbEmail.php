<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tb_email".
 *
 * @property integer $id
 * @property string $email_to
 * @property string $email_from
 * @property string $email_subject
 * @property string $email_message
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 *
 * @property UserTbEmail[] $userTbEmails
 */
class TbEmail extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_email';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_message'], 'string'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['email_to', 'email_from'], 'string', 'max' => 3000],
            [['email_subject'], 'string', 'max' => 10000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email_to' => 'Email To',
            'email_from' => 'Email From',
            'email_subject' => 'Email Subject',
            'email_message' => 'Email Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTbEmails()
    {
        return $this->hasMany(UserTbEmail::className(), ['tb_email_id' => 'id']);
    }
}
