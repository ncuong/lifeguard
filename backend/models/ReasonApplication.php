<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "reason_application".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type_id
 * @property integer $time_allow
 * @property integer $type
 */
class ReasonApplication extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reason_application';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type_id'], 'required'],
            [['type_id', 'time_allow', 'type'], 'integer'],
            [['name'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type_id' => 'Type ID',
            'time_allow' => 'Time Allow',
            'type' => 'Type',
        ];
    }

    public function getApplications()
    {
        return $this->hasMany(UserDate::className(), ['id' => 'reason']);
    }
}
