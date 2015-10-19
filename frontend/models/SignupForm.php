<?php
namespace frontend\models;

use common\models\User;
use yii\base\ErrorException;
use yii\base\Model;


use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    //Add field for project lifeguard 9/2015
    public $code;
    public $referrer;
    public $first_name;
    public $last_name;
    public $sex;
    public $graduate_high_school;
    public $city;
    public $state;
    public $zip;
    public $mobile;
    public $status;


    public static function tableName()
    {
        return "user";
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['code','referrer', 'first_name', 'last_name', 'sex', 'graduate_high_school', 'city', 'state', 'zip', 'mobile'], 'safe'],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            [['email', 'first_name', 'last_name'], 'filter', 'filter' => 'trim'],
            [['email', 'first_name', 'last_name'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6,'tooShort'=>'Password is too short'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'referrer' => 'Referrer Code',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'sex'=>'Sex',
            'graduate_high_school'=>'Graduate From High School',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'mobile' => 'Mobile',
            'password' => 'Password',
            'email' => 'Email',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();

//            Add field for project lifeguard 9/2015
            $user->code = $this->code;
            $user->referrer = $this->referrer;
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->sex = $this->sex;
            $user->graduate_high_school = $this->graduate_high_school;
            $user->city = $this->city;
            $user->state = $this->state;
            $user->zip = $this->zip;
            $user->mobile = $this->mobile;
            $user->status = $this->status;

            if (!$user->save()) {

                 throw new ErrorException("Error save information user");
            }
            return $user;
        }

        return null;
    }

    public function sendEmailActiveAccount($user)
    {
        return \Yii::$app->mailer->compose(['html' => 'emailActiveAccount-html'],['user'=>$user])
            ->setTo($user->email)
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setSubject("Please confirm your registration")
            ->send();
    }
}
