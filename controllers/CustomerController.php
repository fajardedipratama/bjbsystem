<?php

namespace app\controllers;

use Yii;
use app\models\Customer;
use app\models\search\CustomerSearch;
use app\models\Karyawan;
use app\models\City;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(Yii::$app->user->identity->type == 'Marketing'){
            $sales = ArrayHelper::map(Karyawan::find()->where(['posisi'=>6,'status_aktif'=>'Aktif'])->all(),'id',
                function($model){
                    return $model['nama_pendek'];
                });
        }else{
            $sales = ArrayHelper::map(Karyawan::find()->all(),'id',
                function($model){
                    return $model['nama_pendek'];
                });
        }

        $kota = ArrayHelper::map(City::find()->all(),'id',
                function($model){
                    return $model['kota'];
                });

        return $this->render('index', [
            'sales' => $sales,
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
        if ($model->load(Yii::$app->request->post())) {
            $model->expired=Yii::$app->formatter->asDate($_POST['Customer']['expired'],'yyyy-MM-dd');
            $model->long_expired='yes';
            $model->save();
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();

        if ($model->load(Yii::$app->request->post())) {
            //expired
            if(!empty($_POST['Customer']['expired'])){
                $model->expired=Yii::$app->formatter->asDate($_POST['Customer']['expired'],'yyyy-MM-dd');
            }else{
                $model->expired=NULL;
            }
            //expired pusat
            if(!empty($_POST['Customer']['expired_pusat'])){
                $model->expired_pusat=Yii::$app->formatter->asDate($_POST['Customer']['expired_pusat'],'yyyy-MM-dd');
            }else{
                $model->expired_pusat=NULL;
            }
            //expired pending
            if(!empty($_POST['Customer']['expired_pending'])){
                $model->expired_pending=Yii::$app->formatter->asDate($_POST['Customer']['expired_pending'],'yyyy-MM-dd');
            }else{
                $model->expired_pending=NULL;
            }
            $model->save();
            return $this->redirect(['index']);
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

        if ($model->load(Yii::$app->request->post())) {
            //expired
            if(!empty($_POST['Customer']['expired'])){
                $model->expired=Yii::$app->formatter->asDate($_POST['Customer']['expired'],'yyyy-MM-dd');
            }else{
                $model->expired=NULL;
            }
            //expired pusat 
            if(!empty($_POST['Customer']['expired_pusat'])){
                $model->expired_pusat=Yii::$app->formatter->asDate($_POST['Customer']['expired_pusat'],'yyyy-MM-dd');
            }else{
                $model->expired_pusat=NULL;
            }
            //expired pending
            if(!empty($_POST['Customer']['expired_pending'])){
                $model->expired_pending=Yii::$app->formatter->asDate($_POST['Customer']['expired_pending'],'yyyy-MM-dd');
            }else{
                $model->expired_pending=NULL;
            }
            
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionShare($id)
    {
        $model = $this->findModel($id);
        $model->expired = NULL;
        $model->long_expired = NULL;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('share', [
            'model' => $model,
        ]);
    }
    public function actionMerge($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {

            Yii::$app->db->createCommand()->update('id_dailyreport',
            ['perusahaan' => $_POST['Customer']['target'] ],
            ['perusahaan'=>$model->id])->execute();

            Yii::$app->db->createCommand()->update('id_offer',
            ['perusahaan' => $_POST['Customer']['target'] ],
            ['perusahaan'=>$model->id])->execute();

            Yii::$app->db->createCommand()->update('id_customer',
            ['expired' => NULL,'sales'=>$model->sales,'long_expired'=>NULL],
            ['id'=>$_POST['Customer']['target']])->execute();

            return $this->redirect(['view', 'id' => $_POST['Customer']['target'] ]);
        }

        return $this->render('merge', [
            'model' => $model,
        ]);
    }

    public function actionBlokir($id)
    {
        $model = $this->findModel($id);

        Yii::$app->db->createCommand()->update('id_customer',
        ['expired' => NULL,'verified'=>'black'],
        ['id'=>$id])->execute();

        return $this->redirect(['view', 'id' => $id ]);

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
