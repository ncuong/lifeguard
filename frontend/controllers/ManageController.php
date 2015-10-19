<?php
/**
 * Created by PhpStorm.
 * User: VIETBINH
 * Date: 10/6/15
 * Time: 8:59 AM
 */

namespace frontend\controllers;


use common\models\User;
use frontend\models\SignupForm;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use Yii;
use frontend\models\ReferrerSearch;
use yii\data\ActiveDataProvider;
use app\models\TbEmailSearch;
use app\models\TbEmail;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class ManageController extends Controller{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['referrer', 'register'],
                'rules' => [
                    [
                        'actions' => ['register'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['referrer'],
                        'allow' => true,
                        'roles' => ["@"],
                    ],
                ],
            ]
        ];
    }

    public function actionEmail()
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        $searchModel = new TbEmailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('email_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateEmail($ids = "")
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        $model = new TbEmail();
        $model->email_from = User::findIdentity(Yii::$app->user->id)->email;
        if($ids != null || $ids != ""){
            $users = User::find()->where('id in ('.$ids.') ')->all();
            $emails = ArrayHelper::getColumn($users,'email');
            $model->email_to = implode(",",$emails);
        }


        if ($model->load(Yii::$app->request->post())) {
            $mails_to = explode(",",$model->email_to);
            $emails_error = $this->sendEmail($model->email_from,$mails_to,$model->email_subject,$model->email_message);
            if(count($emails_error) == 0){
                Yii::$app->session->setFlash('success', 'The sending email is success.');
                $model->status = 1;
            }else{
                Yii::$app->session->setFlash('error', 'The sending email is error with'. implode(',',$emails_error));
                $model->status = 0;
            }
            $model->save();
            return $this->redirect(['email-view', 'id' => $model->id]);
        } else {
            return $this->render('email_create', [
                'model' => $model,
            ]);
        }
    }

    private function array_delete($array, $element) {
        return array_diff($array, [$element]);
    }
    /**
     * Ham đệ quy để tìm ra tất cả các con cháu của user đã được check
     * @param $userId
     */
    public function getChildrenString($userId) {
        $user = User::find()->where(['id'=>$userId])->one();
        $this->user_find_id[] = $userId;
        $this->user_find_email[] = $user->email;

        if($user != null){
            $users = User::find()->where(['referrer'=>$user->code])->all();
            if($users != null){
                foreach ($users as $u) {
                    if(in_array($user->id,$this->user_show_children))
                    {
                        continue;
                    }
                    $this->getChildrenString($u->id);
                }
            }
        }
    }


    var $user_selected = array();
    var $user_find_id = array();
    var $user_find_email = array();
    var $user_show_children = array();

    public function actionTreeCreateEmail($ids = "")
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        $model = new TbEmail();
        $model->email_from = User::findIdentity(Yii::$app->user->id)->email;
        if($ids != null || $ids != ""){

            $this->user_selected = explode(',',$ids);
            foreach(explode(',',$ids) as $id){
                if (strpos($id, '_O') !== false){
                    //id nay da show cac children
                    $id = substr($id, 0, -2);
                    $this->user_show_children[] = $id;
                }
                $this->getChildrenString($id);
            }
            $model->email_to = implode(",",$this->user_find_email);
        }


        if ($model->load(Yii::$app->request->post())) {
            $mails_to = explode(",",$model->email_to);
            $email_error = $this->sendEmail($model->email_from,$mails_to,$model->email_subject,$model->email_message);
            if(count($email_error) == 0){
                Yii::$app->session->setFlash('success', 'The sending email is success.');
                $model->status = 1;
            }else{
                Yii::$app->session->setFlash('error', 'The sending email is error width '. implode(',',$email_error));
                $model->status = 0;
            }
            $model->save();
            return $this->redirect(['email-view', 'id' => $model->id]);
        } else {
            return $this->render('email_create', [
                'model' => $model,
            ]);
        }
    }

    private function sendEmail($email_from, $emails_to, $email_subject,$email_content)
    {
        $email_content_old = $email_content;
        $emails_error = array();
        foreach($emails_to as $email_to){
            $email_content = $email_content_old;
            $user = User::find()->where(['email'=>$email_to])->one();
            if($user != null){
                $email_content = str_replace('{first_name}',$user->first_name,$email_content);
                $email_content = str_replace('{last_name}',$user->last_name,$email_content);
                $email_content = str_replace('{email}',$user->email,$email_content);
                $email_content = str_replace('{referrer}',$user->referrer,$email_content);
                $email_content = str_replace('{code}',$user->code,$email_content);
                $email_content = str_replace('{phone}',$user->mobile,$email_content);
                $email_content = str_replace('{state}',$user->state,$email_content);
                $email_content = str_replace('{city}',$user->city,$email_content);
                $email_content = str_replace('{zip}',$user->zip,$email_content);
            }

            $mail = \Yii::$app->mailer->compose()
                ->setTo($email_to)
                ->setFrom($email_from)
                ->setSubject($email_subject)
                ->setHtmlBody($email_content)
                ->send();

            if(!$mail){
                $emails_error[] = $user->email;
            }
        }
        return $emails_error;
    }

    public function actionUpdateEmail($id)
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        $model = $this->findEmailModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $mails_to = explode(",",$model->email_to);
            $emails_error = $this->sendEmail($model->email_from,$mails_to,$model->email_subject,$model->email_message);
            if(count($emails_error) == 0){
                Yii::$app->session->setFlash('success', 'The sending email is success.');
                $model->status = 1;
            }else{
                Yii::$app->session->setFlash('error', 'The sending email is error with '.implode(',',$emails_error));
                $model->status = 0;
            }
            if($model->save())
                return $this->redirect(['email-view', 'id' => $model->id]);
        }

        return $this->render('email_update', [
            'model' => $model,
        ]);

    }

    public function actionEmailView($id)
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        return $this->render('email_view', [
            'model' => $this->findEmailModel($id),
        ]);
    }

    public function actionDeleteEmail($id)
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        $this->findEmailModel($id)->delete();

        return $this->redirect(['email']);
    }

    protected function findEmailModel($id)
    {
        if (($model = TbEmail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findUserModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionReferrer()
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        $user = User::findIdentity(Yii::$app->user->id);
        $perPage = Yii::$app->request->Get("per-page");

        if(!isset($perPage))
            $perPage = 20;

        $searchModel = new ReferrerSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=$perPage;
        return $this->render('referrer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user'=>$user
        ]);
    }

    public function actionReportToExcel()
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        $user = User::findIdentity(Yii::$app->user->id);
        $searchModel = new ReferrerSearch();

        $dataProvider = $searchModel->reportOne(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        return $this->render('referrer-to-excel', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user'=>$user
        ]);
    }

    public function actionUpdateUser($id)
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        Yii::$app->view->title = "Update User";
        $model = $this->findUserModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('referrer');
        }
        return $this->render('user_update', [
            'model' => $model,
            'states'=>Common::$states,
        ]);
    }

    public function actionDeleteUser($id)
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        User::updateAll(['status'=>User::STATUS_DELETED],["id"=>$id]);
        $this->redirect('referrer');
    }

    public function actionDeleteUsers($ids)
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        User::updateAll(['status'=>User::STATUS_DELETED],"id in (".$ids.") ");
        $this->redirect('referrer');
    }
    public function actionActiveUsers($ids)
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        User::updateAll(['status'=>User::STATUS_ACTIVE],"id in (".$ids.") ");
        $this->redirect('referrer');
    }
    public function actionInactiveUsers($ids)
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        User::updateAll(['status'=>User::STATUS_WAITING],"id in (".$ids.") ");
        $this->redirect('referrer');
    }

    public function actionLockUsers($ids)
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        User::updateAll(['status'=>User::STATUS_LOCK],"id in (".$ids.") ");
        $this->redirect('referrer');
    }


    public function actionReportOne()
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        $user = User::findIdentity(Yii::$app->user->id);
        $perPage = Yii::$app->request->Get("per-page");
        if(!isset($perPage))
            $perPage = 20;
        $searchModel = new ReferrerSearch();
        $dataProvider = $searchModel->reportOne(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=$perPage;
        return $this->render('report-one', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user'=>$user
        ]);
    }

    public function actionTreeView()
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        $root = User::findOne(Yii::$app->user->id);

        $query = User::find();
        $query->where('status != '.User::STATUS_DELETED);
        $query->andwhere('id != '.Yii::$app->user->id);
        $query->andwhere(['referrer'=>$root->code]);

        $dataProvider1 = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => [
                'created_at' => SORT_DESC,
                'first_name' => SORT_ASC,
            ]
            ]
        ]);

        $arrIdLevel1 = ArrayHelper::getColumn($dataProvider1->models,'code');
        $strIdLevel1 = implode('" , "',$arrIdLevel1);
        $strIdLevel1 = ' "'.$strIdLevel1.'" ';
        $level2 = User::find()->where('referrer in ('.$strIdLevel1.') ')->all();

        return $this->render("tree-view-1",['root'=>$root,'dataProvider1'=>$dataProvider1,'level2'=>$level2]);

        //Code nay danh cho tree table
//        $user = User::findIdentity(Yii::$app->user->id);
//        $perPage = Yii::$app->request->Get("per-page");
//
//        if(!isset($perPage))
//            $perPage = 20;
//        echo $perPage ;
//
//        $searchModel = new ReferrerSearch();
//
//        $dataProvider = $searchModel->searchTreeView(Yii::$app->request->queryParams);
//        $dataProvider->pagination->pageSize=$perPage;
//        return $this->render('tree-view', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//            'user'=>$user
//        ]);

    }

    public function getChildrenUser($code)
    {
        $query = User::find();
        $query->where('status != '.User::STATUS_DELETED);
        $query->andwhere('id != '.Yii::$app->user->id);
        $query->andwhere(['referrer'=>$code]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
        if($dataProvider->getCount()>0){
            return $this->render("children-user-1",['dataProvider'=>$dataProvider,'code'=>$code,'parent_checked'=>0]);
        }
        return "NULL";

// Code nay danh cho tree table
//        $query = User::find();
//        $query->where('status != '.User::STATUS_DELETED);
//        $query->andwhere('id != '.Yii::$app->user->id);
//        $query->andwhere(['referrer'=>$code]);
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'sort' => false,
//        ]);
//        if($dataProvider->getCount()>0){
//                return $this->render("children-user",['dataProvider'=>$dataProvider,'code'=>$code]);
//        }
//        return "";
    }

    public function actionGetUsers()
    {
        if(!Yii::$app->user->can("admin")){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->layout = "admin";

        if (Yii::$app->request->isAjax) {
            $code = Yii::$app->request->post('code');
            $parent_checked = Yii::$app->request->post('parent_checked');
            $query = User::find();
            $query->where('status != '.User::STATUS_DELETED);
            $query->andwhere('id != '.Yii::$app->user->id);
            $query->andwhere(['referrer'=>$code]);

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => false,
            ]);
            if($dataProvider->getCount()>0){
                return $this->renderAjax("children-user-1",['dataProvider'=>$dataProvider,'code'=>$code,'parent_checked'=>$parent_checked]);
            }
        }
        return "NULL";
    }
} 