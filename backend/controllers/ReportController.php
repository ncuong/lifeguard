<?php
/**
 * Created by PhpStorm.
 * User: VIETBINH
 * Date: 2/26/15
 * Time: 3:40 PM
 */

namespace backend\controllers;
use backend\models\ApplicationSearch;
use backend\models\ReportStaff;
use backend\models\UserInfo;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use backend\models\UserDateSearch;
use backend\models\Application;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\User;

class ReportController extends Controller {
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

    public function  actionLeaveAndOvertime()
    {
        $searchModel = new UserDateSearch();
        $dataProvider = $searchModel->searchUser(Yii::$app->request->queryParams,Yii::$app->user->id);
        //$dataProvider = Application::find()->where(['user_id'=>Yii::$app->user->id]);


        $query = Application::find();
        $query->joinWith(['user','reasonApplication']);
        $query->where(array('application.user_id'=>Yii::$app->user->id,'manager_ok'=>1,'hrm_ok'=>1));
        $query->andWhere('type_id = 1 OR type_id = -1 OR type_id = -11');
        $query->orderBy(['from_date'=>SORT_DESC]);
        $dataProviderUserTimeOver = new ActiveDataProvider([
            'query' => $query,
        ]);

        $totalTimeOverWork = 0;
        $totalTimeLeaveOfTimeOver = 0;
        $totalTimeMoney = 0;

        foreach($dataProviderUserTimeOver->getModels() as $model){
            if($model->reasonApplication->type_id == 1){
                $totalTimeOverWork += $model->hours_off;
            }else if($model->reasonApplication->type_id == -1){
                $totalTimeLeaveOfTimeOver += $model->hours_off;
            }else if($model->reasonApplication->type_id == -11){
                $totalTimeMoney += $model->hours_off;
            }
        }

        return $this->render('leave-and-overtime',[
            'dataProvider'=>$dataProvider,
            'dataUserTimeOver'=>$dataProviderUserTimeOver,
            'totalTimeOverWork' => $totalTimeOverWork,
            'totalTimeLeaveOfTimeOver' => $totalTimeLeaveOfTimeOver,
            'totalTimeMoney'=>$totalTimeMoney,
            'totalRemainTime' => $totalTimeOverWork - $totalTimeLeaveOfTimeOver - $totalTimeMoney
        ]);
    }

    public function actionVacationOfStaff($param = null, $from_date = "", $to_date = "")
    {
        $model = new ReportStaff();
        $query = ReportStaff::find();
        $query->With(['applications']);
        $query->select(['full_name','user_id']);
        $str_date = "";

        if($model->load(Yii::$app->request->post(),'ReportStaff')){
            $arrModel = Yii::$app->request->post('ReportStaff');
            $model->from_date = $arrModel['from_date'];
            $model->to_date = $arrModel['to_date'];
            if($model->from_date != '' && $model->to_date != ''){
                $query->addselect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND to_date <= "'.$model->to_date.'" AND reason = 2 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep2');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND to_date <= "'.$model->to_date.'" AND reason = 3 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep3');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND to_date <= "'.$model->to_date.'" AND reason = 4 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep4');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND to_date <= "'.$model->to_date.'" AND reason = 5 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep5');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND to_date <= "'.$model->to_date.'" AND reason = 6 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep6');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND to_date <= "'.$model->to_date.'" AND reason = 7 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep7');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND to_date <= "'.$model->to_date.'" AND reason = 8 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep8');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND to_date <= "'.$model->to_date.'" AND reason = 9 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep9');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND to_date <= "'.$model->to_date.'" AND reason = 10 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep10');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND to_date <= "'.$model->to_date.'" AND reason = 13 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep13');
            }
            else if($model->from_date != ''){
                $query->addselect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND reason = 2 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep2');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND reason = 3 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep3');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND reason = 4 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep4');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND reason = 5 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep5');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND reason = 6 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep6');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND reason = 7 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep7');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND reason = 8 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep8');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND reason = 9 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep9');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND reason = 10 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep10');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND reason = 13 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep13');

            }else if($model->to_date != ''){

                $query->addselect('(SELECT SUM(application.`hours_off`) FROM application WHERE to_date <= "'.$model->to_date.'" AND  reason = 2 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep2');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE to_date <= "'.$model->to_date.'" AND reason = 3 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep3');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE to_date <= "'.$model->to_date.'" AND reason = 4 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep4');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE to_date <= "'.$model->to_date.'" AND reason = 5 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep5');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE to_date <= "'.$model->to_date.'" AND reason = 6 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep6');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE to_date <= "'.$model->to_date.'" AND reason = 7 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep7');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE to_date <= "'.$model->to_date.'" AND reason = 8 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep8');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE to_date <= "'.$model->to_date.'" AND reason = 9 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep9');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE to_date <= "'.$model->to_date.'" AND reason = 10 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep10');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE to_date <= "'.$model->to_date.'" AND reason = 13 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep13');

            }
        }else{
            $query->addselect('(SELECT SUM(application.`hours_off`) FROM application WHERE reason = 2 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep2');
            $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE reason = 3 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep3');
            $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE reason = 4 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep4');
            $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE reason = 5 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep5');
            $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE reason = 6 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep6');
            $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE reason = 7 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep7');
            $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE reason = 8 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep8');
            $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE reason = 9 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep9');
            $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE reason = 10 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep10');
            $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE reason = 13 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep13');
        }

        $query->having('nghi_phep2 != ""');
        $query->orHaving('nghi_phep3 != ""');
        $query->orHaving('nghi_phep4 != ""');
        $query->orHaving('nghi_phep5 != ""');
        $query->orHaving('nghi_phep6 != ""');
        $query->orHaving('nghi_phep7 != ""');
        $query->orHaving('nghi_phep8 != ""');
        $query->orHaving('nghi_phep9 != ""');
        $query->orHaving('nghi_phep10 != ""');
        $query->orHaving('nghi_phep13 != ""');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'totalCount' => false,
        ]);

        if($param != null){
            $this->layout = "layout-print";
            if($from_date != "" && $to_date != "")
                $str_date = '(From '.$from_date.' To '.$to_date.')';
            else if($from_date != "")
                $str_date = '(From '.$from_date.')';
            else if($to_date != "")
                $str_date = '(To '.$to_date.')';
            return $this->render('vacation-of-staff-print',
                [
                    'dataProvider'=>$dataProvider,
                    'model'=>$model,
                    'str_date'=>$str_date
                ]);
        }
        return $this->render('vacation-of-staff',
            [
                'dataProvider'=>$dataProvider,
                'model'=>$model
            ]);

    }
    public function actionOvertimeOfStaff($param = null, $from_date = "", $to_date = "")
    {
        $model = new ReportStaff();
        $query = ReportStaff::find();
        $query->With(['applications']);
        $query->select(['full_name','user_id']);
        $str_date = "";

        if($model->load(Yii::$app->request->post(),'ReportStaff')){
            $arrModel = Yii::$app->request->post('ReportStaff');
            $model->from_date = $arrModel['from_date'];
            $model->to_date = $arrModel['to_date'];
            if($model->from_date != '' && $model->to_date != ''){
                $query->addselect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND to_date <= "'.$model->to_date.'" AND reason = 11 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep11');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND to_date <= "'.$model->to_date.'" AND reason = 12 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep12');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND to_date <= "'.$model->to_date.'" AND reason = 14 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep14');

            }
            else if($model->from_date != ''){
                $query->addselect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND reason = 11 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep11');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND reason = 12 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep12');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE from_date >= "'.$model->from_date.'" AND reason = 14 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep14');

            }else if($model->to_date != ''){

                $query->addselect('(SELECT SUM(application.`hours_off`) FROM application WHERE to_date <= "'.$model->to_date.'" AND reason = 11 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep2');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE to_date <= "'.$model->to_date.'" AND reason = 12 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep3');
                $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE to_date <= "'.$model->to_date.'" AND reason = 14 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep4');

            }else{
                return $this->refresh();
            }
        }else{
            $query->addselect('(SELECT SUM(application.`hours_off`) FROM application WHERE reason = 11 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep11');
            $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE reason = 12 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep12');
            $query->addSelect('(SELECT SUM(application.`hours_off`) FROM application WHERE reason = 14 AND manager_ok = 1 AND hrm_ok = 1 AND application.`user_id` = user_info.`user_id`)AS nghi_phep14');
        }

        $query->having('nghi_phep11 != ""');
        $query->orHaving('nghi_phep12 != ""');
        $query->orHaving('nghi_phep14 != ""');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'totalCount' => false,
        ]);
        if($param != null){
            $this->layout = "layout-print";
            if($from_date != "" && $to_date != "")
                $str_date = '(From '.$from_date.' To '.$to_date.')';
            else if($from_date != "")
                $str_date = '(From '.$from_date.')';
            else if($to_date != "")
                $str_date = '(To '.$to_date.')';
            return $this->render('overtime-of-staff-print',
                [
                    'dataProvider'=>$dataProvider,
                    'model'=>$model,
                    'str_date'=>$str_date
                ]);
        }
        return $this->render('overtime-of-staff',
            [
                'dataProvider'=>$dataProvider,
                'model'=>$model
            ]);


    }

    public function actionVacationOfStaffDetail()
    {
        $user_id = Yii::$app->request->post('user_id');
        $reason_id = Yii::$app->request->post('reason_id');
        $from_date = Yii::$app->request->post('from_date');
        $to_date = Yii::$app->request->post('to_date');

        $query = Application::find();
        $query->where(['user_id'=>$user_id,'reason'=>$reason_id,'manager_ok'=>1,'hrm_ok'=>1]);
        if($from_date != '')
            $query->andWhere('from_date >= "'.$from_date.'" ');
        if($to_date != '')
            $query->andWhere('to_date <= "'.$to_date.'" ');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->renderAjax('vacation-of-staff-detail',
            [
                'dataProvider'=>$dataProvider
            ]);
    }

    public function actionOvertimeOfStaffDetail()
    {
        $user_id = Yii::$app->request->post('user_id');
        $reason_id = Yii::$app->request->post('reason_id');
        $from_date = Yii::$app->request->post('from_date');
        $to_date = Yii::$app->request->post('to_date');
        $view = Yii::$app->request->post('view');

        $query = Application::find();
        $query->where(['user_id'=>$user_id,'reason'=>$reason_id,'manager_ok'=>1,'hrm_ok'=>1]);
        if($from_date != '')
            $query->andWhere('from_date >= "'.$from_date.'" ');
        if($to_date != '')
            $query->andWhere('to_date <= "'.$to_date.'" ');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if($view == 2)
            return $this->renderAjax('vacation-of-staff-detail2',
                [
                    'dataProvider'=>$dataProvider
                ]);
        else if($view == 1)
            return $this->renderAjax('vacation-of-staff-detail',
                [
                    'dataProvider'=>$dataProvider
                ]);
    }
} 