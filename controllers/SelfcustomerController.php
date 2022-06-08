<?php

namespace app\controllers;

use Yii;
use app\models\Customer;
use app\models\Dailyreport;
use app\models\search\SelfCustomerSearch;
use yii\web\Controller;
use app\models\City;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * SelfcustomerController implements the CRUD actions for Customer model.
 */
class SelfcustomerController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access'=> [
                'class'=>AccessControl::className(),
                'only'=>['create','index','update','view'],
                'rules'=>[
                    [
                        'allow'=>true,
                        'roles'=>['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SelfCustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $kota = ArrayHelper::map(City::find()->all(),'id',
                function($model){
                    return $model['kota'];
                });

        return $this->render('index', [
            'kota' => $kota,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        //view
        if($model->sales == Yii::$app->user->identity->profilname){
            //create
            $modelprogress = new Dailyreport();
            if ($modelprogress->load(Yii::$app->request->post()) && $modelprogress->save()) {

                if($_POST['Dailyreport']['keterangan']==='Penawaran'){
                    return $this->redirect(['offer/create', 'id' => $model->id]);
                }else{
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }

            return $this->render('view', [
                'model' => $this->findModel($id),
                'modelprogress' => $modelprogress
            ]);
        }else{
            return $this->redirect(['index']);
        }
        
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->sales == Yii::$app->user->identity->profilname){
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }else{
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionLongexpired($id)
    {
        $model = $this->findModel($id);
        $expired=date('Y-m-d', strtotime('+31 days', strtotime($model->expired)));

        Yii::$app->db->createCommand()->update('id_customer',
        ['expired' => $expired, 'long_expired' => 'yes'],
        ['id'=>$id])->execute();

        return $this->redirect(['view', 'id' => $model->id]);
    }
    public function actionActiveagain($id)
    {
        $model = $this->findModel($id);
        $now = date('Y-m-d');
        $expired=date('Y-m-d', strtotime('+31 days', strtotime($now)));

        Yii::$app->db->createCommand()->update('id_customer',
        ['expired' => $expired, 'long_expired' => NULL],
        ['id'=>$id])->execute();

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
