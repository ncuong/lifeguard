<?php
namespace frontend\controllers;

use app\models\TbEmail;
use common\models\User;
use frontend\models\ChangePasswordForm;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'register'],
                'rules' => [
                    [
                        'actions' => ['register'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','referrer','profile','change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        Yii::$app->view->title = "Lifeguard";
        if(Yii::$app->user->can("admin")){
            $this->layout = "admin";

            //$list= Yii::app()->db->createCommand('select * from post where category=:category')->bindValue('category',$category)->queryAll();
            $list_user = Yii::$app->db->createCommand("SELECT DATE_FORMAT(FROM_UNIXTIME(created_at), '%Y-%m') as 'created_at_date', COUNT('created_at_date') as 'count_date' FROM `user` GROUP BY `created_at_date` ORDER BY `created_at_date`")->queryAll();
            $list_user_status = Yii::$app->db->createCommand("SELECT status, COUNT(status) as count_user FROM `user` WHERE 1 GROUP BY status")->queryAll();

            $count_user = User::find()->count();
            $count_email= TbEmail::find()->count();

            $array_user_status = array();
            foreach($list_user_status as $user){
                $label = "";
                switch($user['status'])
                {
                    case User::STATUS_LOCK:
                        $label = "Locked";
                        break;
                    case User::STATUS_ACTIVE:
                        $label = "Active";
                        break;
                    case User::STATUS_WAITING:
                        $label = "Inactive";
                        break;
                    case User::STATUS_DELETED:
                        $label = "Deleted";
                        break;
                    default:
                        $label = "Other";
                }
                $array_user_status[] = array("value"=>$user["count_user"],"label"=>$label);
            }

            return $this->render("admin-index",['list_user'=>$list_user, "array_user_status"=>$array_user_status,"count_user"=>$count_user,"count_email"=>$count_email]);
        }
        else{
            if(!Yii::$app->user->isGuest){
                $this->layout = "user";
            }
            return $this->render('index');
        }
    }

    public function actionLogin()
    {
        Yii::$app->view->title = "Lifeguard - Login";
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->view->title = "Lifeguard - Logout";
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
//        $model = new ContactForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
//                if ($model->sendEmail("vietbinh.dn@gmail.com")) {
//                    Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
//                } else {
//                    Yii::$app->session->setFlash('error', 'There was an error sending email.');
//                }
//
//                return $this->refresh();
//            } else {
//                return $this->render('contact', [
//                    'model' => $model,
//                ]);
//            }
//        }

//        $a = Yii::$app->mailer->compose()
//            ->setFrom('vietbinh.dn@gmail.com')
//            ->setTo('vietbinh.dn@gmail.com')
//            ->setSubject('Message subject')
//            ->setTextBody('Plain text content')
//            ->setHtmlBody('<b>HTML content</b>')
//            ->send();
        $to      = 'vietbinh.dn@gmail.com';
        $subject = 'the subject';
        $message = 'hello';
        $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

//        $a = $this->sendMail("vietbinh.dn@gmail.com","vietbinh.dn@gmail.com","takakak","kakakak","kakaka");
//        if($a){
//            echo "thang cong";
//            exit;
//        }else{
//            echo "That bai";
//            exit;
//        }
    }

//    private function sendMail($to, $from, $_name, $_subject, $_body)
//    {
//        $name = '=?UTF-8?B?' . base64_encode($_name) . '?=';
//        $subject = '=?UTF-8?B?' . base64_encode($_subject) . '?=';
//        $headers = "From: $name <{$from}>\r\n" .
//            "Reply-To: {$from}\r\n" .
//            "MIME-Version: 1.0\r\n" .
//            "Content-Type: text/html; charset=UTF-8";
//
//        if (mail($to, $subject, $_body, $headers)) {
//            return true;
//        } else{
//            return false;
//        }
//            echo print_r(error_get_last());
//    }

//    public function actionAbout()
//    {
//        return $this->render('about');
//    }

    function random_string($length = 0)
    {
        $random = md5(uniqid(rand(), true));
        if ($length > 0)
        {
            return substr($random, 0, $length);
        }
        else return $random;
    }

    public function actionRegister($referrer_code = "")
    {
        Yii::$app->view->title = "Lifeguard - Register";
        if($referrer_code != ""){
            $isDisableReferrer = true;
        }else
            $isDisableReferrer = false;

        $model = new SignupForm();
        $model->referrer = $referrer_code;

        if ($model->load(Yii::$app->request->post())) {
            $model->code = $this->random_string(5);
            $model->username = $model->email;
            $model->status = User::STATUS_WAITING;

            if ($user = $model->signup()) {
                //Gui mail active account.
                if($model->sendEmailActiveAccount($user))
                    Yii::$app->session->setFlash('success', 'Thank you for joining us! We have sent you an email to validate your account, please click on the link in your email to login.');
                else
                    Yii::$app->session->setFlash('error', 'Cannot send a email confirm your registration.');
            }else{
                Yii::$app->session->setFlash('error', 'The register is error.');
            }
        }
        $states = Common::$states;
        return $this->render('register', [
            'model' => $model,
            'states'=>$states,
            'isDisableReferrer'=>$isDisableReferrer
        ]);
    }

    public function actionConfirmRegistration($key)
    {
        $user = User::findOne(['auth_key'=>$key]);
        if($user !== null){
            $user->status = User::STATUS_ACTIVE;
            $user->save();
            if (Yii::$app->user->login($user,0)) {
                Yii::$app->session->setFlash('success',"You have successfully activated your account!");
                if($user->referrer != "" && User::findOne(["code"=>$user->referrer]) === null){
                    Yii::$app->session->setFlash('warning', 'The Referrer code is wrong.');
                    return $this->redirect("profile");
                }else
                    return $this->goHome();
            }
        }else{
            Yii::$app->session->setFlash('error', 'Link confirm your registration is wrong.');
            return $this->goHome();
        }


    }

    public function actionRequestPasswordReset()
    {
        Yii::$app->view->title = "Lifeguard - Request Password Reset";
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        Yii::$app->view->title = "Lifeguard - Reset Password";
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionReferrer()
    {
        Yii::$app->view->title = "Lifeguard - Referrer";
        $user = User::findIdentity(Yii::$app->user->id);
        $referrer = null;

        //Nguoi gioi thieu toi
        if($user->referrer != ""){
            $referrer = User::findOne(["code" => $user->referrer]);
        }
        //Nhung nguoi toi gioi thieu

        $query = User::find();
        $query->where(["referrer"=>$user->code]);
        $query->orderBy(['first_name'=>SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('referrer',['referrer'=>$referrer,'iRefer'=>$dataProvider, 'user'=>$user]);
    }

    public function actionProfile()
    {
        if(Yii::$app->user->can("admin")){
            $this->layout = "admin";
        }
        Yii::$app->view->title = "Lifeguard - Profile";
        $model = User::findIdentity(Yii::$app->user->id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($model->referrer != "" && User::findOne(["code"=>$model->referrer]) === null){
                Yii::$app->session->setFlash('warning', 'The Referrer code is wrong.');
            }
            Yii::$app->getSession()->setFlash('success', 'Your profile was saved.');
        }
        return $this->render('profile', [
            'model' => $model
        ]);
    }

    public function actionChangePassword()
    {
        if(Yii::$app->user->can("admin")){
            $this->layout = "admin";
        }

        Yii::$app->view->title = "Lifeguard - Change Password";
        $model = new ChangePasswordForm();
        $currentUser = User::findByUsername(Yii::$app->user->identity->username);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            try {
                $currentUser->setPassword($_POST['ChangePasswordForm']['newPassword']);
                if ($currentUser->save()) {
                    Yii::$app->getSession()->setFlash('success', 'Password changed');
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Password not changed');
                }
            } catch (Exception $e) {
                Yii::$app->getSession()->setFlash('error', "{$e->getMessage()}");
                return $this->render('change-password', ['model' => $model]);
            }
        }
        return $this->render('change-password', ['model' => $model]);

    }
}