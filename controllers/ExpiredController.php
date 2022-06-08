<?php

namespace app\controllers;

use Yii;
use app\models\Customer;
use app\models\search\ExpiredSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Karyawan;
use app\models\City;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * ExpiredController implements the CRUD actions for Customer model.
 */
class ExpiredController extends Controller
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
        $searchModel = new ExpiredSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $sales = ArrayHelper::map(Karyawan::find()->all(),'id',
                function($model){
                    return $model['nama_pendek'];
                });
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
    public function actionMove()
    {
        $model = new Customer();

        if ($model->load(Yii::$app->request->post())){
            $model->dari_tgl = Yii::$app->formatter->asDate($_POST['Customer']['dari_tgl'],'yyyy-MM-dd');
            $model->ke_tgl = Yii::$app->formatter->asDate($_POST['Customer']['ke_tgl'],'yyyy-MM-dd');

            if(empty($model->target)){
                Yii::$app->db->createCommand()->update('id_customer',
                ['expired' => $model->ke_tgl],
                ['expired' => $model->dari_tgl])->execute();
            }else{
                 Yii::$app->db->createCommand()->update('id_customer',
                ['expired' => $model->ke_tgl],
                ['expired' => $model->dari_tgl,'sales'=>$model->target])->execute();
            }
            return $this->redirect(['index']);
        }

        return $this->render('move', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new Customer();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

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
