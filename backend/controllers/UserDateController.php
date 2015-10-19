<?php

namespace backend\controllers;

use backend\models\UserInfo;
use Composer\DependencyResolver\Request;
use Yii;
use backend\models\UserDate;
use backend\models\UserDateSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserDateController implements the CRUD actions for UserDate model.
 */
class UserDateController extends Controller
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
     * Lists all UserDate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserDateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' =>$searchModel
        ]);
    }

    /**
     * Displays a single UserDate model.
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
     * Creates a new UserDate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserDate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserDate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserDate model.
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
     * Finds the UserDate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserDate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserDate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionListDateOff()
    {
        $idStaff = Yii::$app->request->post('idOfStaff');
        $query = UserDate::find();
        $query = UserDate::find();
        $query->select('user_info.*,id, year, entitlement, entitlement - (SELECT SUM(hours_off) AS hours FROM `application` WHERE manager_ok = 1 AND hrm_ok = 1 AND application.user_id = user_info.user_id AND reason = 13 AND YEAR(from_date) = user_date.`year`) AS balance');
        $query->joinWith(['user']);
        $query->where(['user_date.user_id'=>$idStaff]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $user = UserInfo::findOne(['user_id'=>$idStaff]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        return $this->renderAjax('list-date-off', [
            'dataProvider' => $dataProvider,
            'user'=>$user
        ]);
    }

    public function actionCreateForStaff($id)
    {
        $model = new UserDate();
        $model->user_id = $id;
        $model->year = date('Y');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['userinfo/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
}
