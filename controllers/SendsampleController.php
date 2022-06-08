<?php

namespace app\controllers;

use Yii;
use app\models\SendSample;
use app\models\Karyawan;
use app\models\Customer;
use app\models\search\SendsampleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * SendsampleController implements the CRUD actions for SendSample model.
 */
class SendsampleController extends Controller
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
     * Lists all SendSample models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SendsampleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $sales = ArrayHelper::map(Karyawan::find()->all(),'id',
                function($model){
                    return $model['nama_pendek'];
                });

        if(Yii::$app->user->identity->type == 'Marketing'){
            $customer = ArrayHelper::map(SendSample::find()->where(['sales'=>Yii::$app->user->identity->profilname])->all(),'perusahaan',
                function($model){
                $query=Customer::find()->where(['id'=>$model['perusahaan']])->all();
                  foreach ($query as $key){
                    return $key['perusahaan'];
                  }
                });
        }else{
            $customer = ArrayHelper::map(SendSample::find()->all(),'perusahaan',
                function($model){
                $query=Customer::find()->where(['id'=>$model['perusahaan']])->all();
                  foreach ($query as $key){
                    return $key['perusahaan'];
                  }
                });
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sales' => $sales,
            'customer' => $customer,
        ]);
    }

    /**
     * Displays a single SendSample model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionPrint($id)
    {
        return $this->renderPartial('print', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionPrintall()
    {
        return $this->renderPartial('printall');
    }

    /**
     * Creates a new SendSample model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SendSample();

        if ($model->load(Yii::$app->request->post())) {

          if($model->tgl_kirim != NULL){
            $model->tgl_kirim=Yii::$app->formatter->asDate($_POST['SendSample']['tgl_kirim'],'yyyy-MM-dd');
          }
            $model->created_time=date('Y-m-d H:i:s');
            $model->status='Pending';
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SendSample model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

          if($model->tgl_kirim != NULL){
            $model->tgl_kirim=Yii::$app->formatter->asDate($_POST['SendSample']['tgl_kirim'],'yyyy-MM-dd');
          }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAccsend($id)
    {
        $model = $this->findModel($id);

        Yii::$app->db->createCommand()->update('id_send_sample',
        ['status'=>'Disetujui','acc_by'=>Yii::$app->user->identity->profilname],
        ['id'=>$model->id])->execute();

        return $this->redirect(['view','id' => $model->id]);
    }
    public function actionDontsend($id)
    {
        $model = $this->findModel($id);

        Yii::$app->db->createCommand()->update('id_send_sample',
        ['status'=>'Ditolak','acc_by'=>Yii::$app->user->identity->profilname],
        ['id'=>$model->id])->execute();

        return $this->redirect(['view','id' => $model->id]);
    }
    public function actionSendsuccess($id)
    {
        $model = $this->findModel($id);

        Yii::$app->db->createCommand()->update('id_send_sample',
        ['status'=>'Terkirim','tgl_kirim'=>date('Y-m-d')],
        ['id'=>$model->id])->execute();

        return $this->redirect(['view','id' => $model->id]);
    }
    public function actionSendfailed($id)
    {
        $model = $this->findModel($id);

        Yii::$app->db->createCommand()->update('id_send_sample',
        ['status'=>'Batal Kirim'],
        ['id'=>$model->id])->execute();

        return $this->redirect(['view','id' => $model->id]);
    }

    /**
     * Deletes an existing SendSample model.
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
     * Finds the SendSample model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SendSample the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SendSample::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
