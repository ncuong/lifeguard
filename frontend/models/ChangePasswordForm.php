<?php
namespace frontend\models;

use common\models\LoginForm;
use common\models\User;
use yii\base\ErrorException;
use yii\base\Model;


use Yii;

/**
 * Signup form
 */
class ChangePasswordForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $confirmNewRepeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['currentPassword','findPasswords'],
            [['newPassword', 'currentPassword'], 'required'],
            ['newPassword', 'string', 'min' => 6],

            ['confirmNewRepeat', 'required'],
            ['confirmNewRepeat', 'compare', 'compareAttribute' => 'newPassword']
        ];
    }

    public function attributeLabels()
    {
        return [
            'currentPassword' => 'Current Password',
            'newPassword' => 'New Password',
            'confirmNewRepeat' => 'Confirm Password',

        ];
    }

    public function findPasswords($attribute, $params)
    {
        $user = User::findIdentity(Yii::$app->user->id);
        if (!$user->validatePassword($this->currentPassword))
            $this->addError($attribute, 'Old password is incorrect');
    }
}
