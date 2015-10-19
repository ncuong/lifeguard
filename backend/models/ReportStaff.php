<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_date".
 *
 * @property string $full_name
 * @property string $nghi_phep2
 * @property integer $year
 * @property integer $entitlement
 * @property integer $balance
 *
 * @property Application[] $applications
 * @property UserInfo $user
 */
class ReportStaff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $nghi_phep2;
    public $nghi_phep3;
    public $nghi_phep4;
    public $nghi_phep5;
    public $nghi_phep6;
    public $nghi_phep7;
    public $nghi_phep8;
    public $nghi_phep9;
    public $nghi_phep10;
    public $nghi_phep11;
    public $nghi_phep12;
    public $nghi_phep13;
    public $nghi_phep14;
    public $from_date;
    public $to_date;

    public static function tableName()
    {
        return 'user_info';
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['user_id' => 'user_id']);
    }
}
