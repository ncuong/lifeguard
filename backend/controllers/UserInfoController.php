<?php

namespace backend\controllers;

use Yii;
use backend\models\UserInfo;
use backend\models\UserInfoSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\SignupForm;

/**
 * UserInfoController implements the CRUD actions for UserInfo model.
 */
class UserInfoController extends Controller
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
     * Lists all UserInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserInfo model.
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
     * Creates a new UserInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserInfo();
        $modelSignUp = new SignupForm();
        $arrSingup = Yii::$app->request->post("SignupForm");
        $modelSignUp->username = $arrSingup["username"];
        $modelSignUp->password = $arrSingup["password"];
        $modelSignUp->email = $arrSingup["email"];


        $arrUserInfo = Yii::$app->request->post("UserInfo");
        $model->load(Yii::$app->request->post());

        $user = $modelSignUp->signup();

            if($user !== null){
                $model = $this->findModel($user->id);
                $model->first_name = $arrUserInfo["first_name"];
                $model->last_name = $arrUserInfo["last_name"];
                $model->full_name = $arrUserInfo["full_name"];
                $model->phone = $arrUserInfo["phone"];
                $model->position = $arrUserInfo["position"];
                $model->manager = $arrUserInfo["manager"];
                if($model->save())
                    return $this->redirect(['view', 'id' => $model->user_id]);
            }

        return $this->render('create', [
            'model' => $model,
            'modelSignUp' => $modelSignUp
        ]);


    }

    /**
     * Updates an existing UserInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelSignUp = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelSignUp' => $modelSignUp
            ]);
        }
    }

    /**
     * Deletes an existing UserInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Show thong tin user
     */

    public function  actionShowInformationUser($id)
    {
        if(UserInfo::findOne($id) !== null){
            $this->redirect(['view', 'id' => $id]);
        }else{
            $this->redirect(['create']);
        }
    }
}
