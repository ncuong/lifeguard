<?php

namespace backend\controllers;

use backend\models\ReasonApplication;
use backend\models\UserDate;
use backend\models\ApplicationSearch;
use backend\models\Application;
use backend\models\UserInfo;
use common\models\AuthAssignment;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ApplicationController implements the CRUD actions for Application model.
 */
class ApplicationController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Application models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApplicationSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Application model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single Application model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewAjax()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            return $this->renderAjax('view-ajax', [
                'model' => $this->findModel($id),

            ]);
        } else
            throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCheckApplication($id)
    {

        //$model = $this->findModel($id);

        $query = Application::find();
        $query->joinWith(['user','reasonApplication']);
        $query->where(['application.id'=>$id]);
        $model = $query->one();

        if($model === null){
            throw new NotFoundHttpException('The letter has been deleted.');
        }

        if ($model->load(Yii::$app->request->post())) {
            // Gui mail bao cho manager biet co dua xin nghi.
            $link = Html::a('Click me!', Yii::$app->urlManager->createAbsoluteUrl(['application/view', 'id' => $model->id]));
            $user_manager = UserInfo::findOne(['user_id' => $model->user->manager]);

            if(Yii::$app->user->can('manager')){
                if ($model->manager_ok == 0) {
                    $title = "Manager Refuse: ";
                }
                if ($model->manager_ok == 1) {
                    $model->manager_id_ok = Yii::$app->user->id;
                    $model->hrm_ok = 1;
                    $title = "Manager Accept: ";
                }
            }

            if(Yii::$app->user->can('hrm')){
                if ($model->hrm_ok == 0) {
                    $title = "HRM Refuse: ";
                }
                if ($model->hrm_ok == 1) {
                    $model->hrm_id_ok = Yii::$app->user->id;

                    $title = "HRM Accept: ";
                }
            }
            $body = $this->renderPartial('email_result',['model'=>$model,'link'=>$link,'user_manager'=>$user_manager]);

            if($model->manager_ok == 1 && Yii::$app->user->can('manager')){
                //Gửi mail báo cho quản lý nhân sự
                $link2 = Html::a('Click me!', Yii::$app->urlManager->createAbsoluteUrl(['application/check-application', 'id' => $model->id]));
                $body = $this->renderPartial('email_result',['model'=>$model,'link'=>$link2,'user_manager'=>$user_manager]);
                $hrm_id = AuthAssignment::findOne(['item_name'=>'hrm'])->user_id;
                $user_hrm = UserInfo::findOne(['user_id'=>$hrm_id]);
                $this->sendMail($user_hrm->email, $user_manager->email, $user_manager->full_name, $title . $model->reasonApplication->name, $body);
            }


            if($model->manager_ok == 0 || $model->hrm_ok == 0){
                $model->save(false);
                if($this->sendMail($model->user->email, $user_manager->email, $user_manager->full_name, $title . $model->reasonApplication->name, $body))
                    Yii::$app->session->setFlash('success', 'Your message has been sent to the staff !');
                else
                    Yii::$app->session->setFlash('error', 'Unable to send a letter to the staff. Please call the staff. Staff\'s phone: .' . $user_manager->phone);
                return $this->redirect(['application/application-of-room', 'id' => Yii::$app->user->id]);
            }else if($model->save() && $user_manager !== null && ($model->manager_ok != -1 || $model->hrm_ok != -1)){
                if($this->sendMail($model->user->email, $user_manager->email, $user_manager->full_name, $title . $model->reasonApplication->name, $body))
                    Yii::$app->session->setFlash('success', 'Your message has been sent to the staff !');
                else
                    Yii::$app->session->setFlash('error', 'Unable to send a letter to the staff. Please call the staff. Staff\'s phone: .' . $user_manager->phone);
                return $this->redirect(['application/application-of-room', 'id' => Yii::$app->user->id]);
            }
        } else {
            //Thiet lap truong da doc don cua nhan vien
            if (Yii::$app->user->can('hrm')) {
                $model->hrm_readed = 1;
            }
            if (Yii::$app->user->can('manager')) {
                $model->manager_readed = 1;
            }
            if (!$model->save(true, ['hrm_readed', 'manager_readed'])) {
                throw new NotFoundHttpException('The Error in saving status readed of manager and hrm.');
            }
        }
        return $this->render('check-application', [
            'model' => $model,
        ]);

    }

    /**
     * Creates a new Application model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Application();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            //Thiet lap id da dong y don cua nhan vien
            if ($model->hrm_ok == 1) {
                $model->hrm_id_ok = Yii::$app->user->id;
            }
            if ($model->manager_ok == 1) {
                $model->manager_id_ok = Yii::$app->user->id;
            }
            //Thiet lap truong da doc don cua nhan vien
            if (Yii::$app->user->can('hrm')) {
                $model->hrm_readed = 1;
            }
            if (Yii::$app->user->can('manager')) {
                $model->manager_readed = 1;
            }
            $model->date_create = date('Y-m-d H:i:s');
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else
                "error page application create";
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing Application model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $reason = array();

        if ($model->type == 0) {
            //Don xin nghi phep (co tru phep va khong tru phep)
            $reason = ReasonApplication::find()->where(['type_id' => -2])->orWhere(['type_id' => 0])->all();
        }
        if ($model->type == -1) {
            //Don xin nghi bu
            $reason = ReasonApplication::find()->where(['type_id' => -1])->all();

        }
        if ($model->type == 1) {
            //Don xin lam bu
            $reason = ReasonApplication::find()->where(['type_id' => 1])->all();

        }
        if ($model->type == -11) {
            //Don xin chuyen gio overtime thanh tien
            $reason = ReasonApplication::find()->where(['type_id' => -11])->orderBy(['name' => SORT_ASC])->all();
        }

        //Dinh dang lai thoi gian
        $model->from_hour = substr($model->from_hour,0,-3);
        $model->to_hour = substr($model->to_hour,0,-3);
        $model->from_date = Yii::$app->formatter->asDate(strtotime($model->from_date));
        $model->to_date = Yii::$app->formatter->asDate(strtotime($model->to_date));

        if ($model->load(Yii::$app->request->post())) {
            //Sua lai ngay thang de luu
            $model->from_date = date('Y-m-d', strtotime(str_replace('/','-',$model->from_date)));
            $model->to_date = date('Y-m-d', strtotime(str_replace('/','-',$model->to_date)));
            //Luu co so du lieu
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'reason' => $reason
        ]);

    }

    /**
     * Deletes an existing Application model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('success', 'You deleted successful!');
        } else {
            Yii::$app->session->setFlash('error', 'Error delete leave application');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Application model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Application the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Application::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionApplicationOfRoom($id)
    {
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->searchApplicationOfRoom(Yii::$app->request->queryParams, $id);
        return $this->render('applications-of-room', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionApplicationOfType($id, $user_id = 0)
    {

        $model = new Application();
        $model->type = $id;
        $reason = array();

        if ($id == 0) {
            //Don xin nghi phep (co tru phep va khong tru phep)
            $reason = ReasonApplication::find()->where(['type_id' => -2])->orWhere(['type_id' => 0])->orderBy(['name' => SORT_ASC])->all();
        }else if ($id == -1) {
            //Don xin nghi bu
            $reason = ReasonApplication::find()->where(['type_id' => -1])->orderBy(['name' => SORT_ASC])->all();
        }else if ($id == 1) {
            //Don xin lam bu
            $reason = ReasonApplication::find()->where(['type_id' => 1])->orderBy(['name' => SORT_ASC])->all();
        }else if ($id == -11) {
            //Don xin chuyen gio overtime thanh tien
            $reason = ReasonApplication::find()->where(['type_id' => -11])->orderBy(['name' => SORT_ASC])->all();
        }else{
            throw new NotFoundHttpException("This type of application does not exist");
        }

        if ($model->load(Yii::$app->request->post())) {

            //neu la don xin chuyen thoi gian lam them qua tien thi gan manager = 1;
            $r = ReasonApplication::findOne($model->reason);
            if($r->type_id == -11){
                $model->manager_ok = 1;
                $model->manager_readed = 1;
            }
            $model->user_id = Yii::$app->user->id;
            //Thiet lap trong truong hop hrm lam don xin nghi
            if (Yii::$app->user->can('hrm')) {
                $model->hrm_readed = 1;
                $model->hrm_ok = 1;
            }
            //Thiet lap trong truong hop hrm lam don chuyen gio them thanh tien cho nhan vien
            if ($id == -11) {
                $model->to_date = $model->from_date;
                $model->user_id = $user_id;
            }
            $from_date_temp = $model->from_date;
            $model->from_date = date('Y-m-d', strtotime(str_replace('/','-',$model->from_date)));
            $to_date_tem = $model->to_date;
            $model->to_date = date('Y-m-d', strtotime(str_replace('/','-',$model->to_date)));

            $model->date_create = date('Y-m-d H:i:s');
            //Kiem tra gio co hop phep ko? va luu lai
            if ($model->validate(['hours_off']) && $model->save()) {

                //Truong hop la nhan vien xin nghi, lam bu, nghi bu
                //Gui thu cho manager cua no
                if (Yii::$app->user->can('staff') && $id != -11) {
                    // Gui mail bao cho manager biet co dua xin nghi.
                    $link = Html::a('Click me!', Yii::$app->urlManager->createAbsoluteUrl(['application/check-application', 'id' => $model->id]));
                    $reason = ReasonApplication::findOne(['id' => $model->reason]);
                    $user_info = UserInfo::findOne(['user_id' => $model->user_id]);
                    $user_manager = UserInfo::findOne(['user_id' => $user_info->manager]);

                    $body = $this->renderPartial('email_request',['model'=>$model,'reason'=>$reason,'link'=>$link,'user_info'=>$user_info,'user_manager'=>$user_manager]);

                    if ($user_manager !== null && $this->sendMail($user_manager->email, $user_info->email, $user_info->full_name, $reason->name, $body)) {
                        //if($user_manager !== null && $this->sendMail("voicondn@gmail.com","vietbinh.dn@gmail.com",$user_info->full_name,$reason->name,$str)){
                        Yii::$app->session->setFlash('success', 'Your message has been sent to the manager !');
                    } else {
                        Yii::$app->session->setFlash('error', 'Unable to send a letter to the manager. Please call the manager. Manager\'s phone: .' . $user_manager->phone);
                    }
                }

                //Truong hop la don xin chuyen thoi gian thanh tien.
                if ($id == -11) {

                }

                //Truong hop manager xin nghi viec.
                if (Yii::$app->user->can('manager') && $id != -11) {

                }

                return $this->redirect(['view', 'id' => $model->id]);
            }

            $model->from_date = $from_date_temp;
            $model->to_date = $to_date_tem;

        }

        if ($id == -11) {
            return $this->render('application-time-to-money', [
                'model' => $model,
                'reason' => $reason,
            ]);
        }

        return $this->render('application-of-type', [
            'model' => $model,
            'reason' => $reason,

        ]);

    }

    public function actionLeaveUser()
    {
        if (!Yii::$app->request->isAjax)
            throw new NotFoundHttpException('The requested page does not exist.');
        $year = Yii::$app->request->post('year');
        $searchModel = new ApplicationSearch();

        $query = Application::find();
        //$query->joinWith(['user','reasonApplication']);
        $query->where(array('application.user_id' => Yii::$app->user->id));
        $query->andWhere('year(from_date) = ' . $year);
        $query->andWhere(['reason' => 13]); // reason leave is annual leave
        $query->andWhere(['manager_ok' => 1, 'hrm_ok' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $total = 0;
        foreach ($dataProvider->getModels() as $model) {
            $total += $model->hours_off;
        }

        return $this->renderAjax('leaves-ajax', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'total' => $total
        ]);
    }

    private function sendMail($to, $from, $_name, $_subject, $_body)
    {
        $name = '=?UTF-8?B?' . base64_encode($_name) . '?=';
        $subject = '=?UTF-8?B?' . base64_encode($_subject) . '?=';
        $headers = "From: $name <{$from}>\r\n" .
            "Reply-To: {$from}\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/html; charset=UTF-8";

        if (mail($to, $subject, $_body, $headers)) {
            return true;
        } else
            return false;
    }

    public function actionQuyen()
    {
        if (Yii::$app->user->can("admin"))
            echo "day la admin <br>";
        if (Yii::$app->user->can("manager"))
            echo "day la manager <br>";
        if (Yii::$app->user->can("hrm"))
            echo "day la hrm <br>";
        if (Yii::$app->user->can("staff"))
            echo "day la staff <br>";
        return "Choa ";
    }
}

?>
