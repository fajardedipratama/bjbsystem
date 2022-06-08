<?php

namespace app\controllers;

use Yii;
use app\models\PurchaseOrder;
use app\models\PurchaseOrderPaid;
use app\models\PurchaseOrderFile;
use app\models\City;
use app\models\search\PurchaseorderSearch;
use app\models\search\PurchasereviewSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\models\Customer;
use app\models\Karyawan;
use yii\data\ActiveDataProvider;
/**
 * PurchaseorderController implements the CRUD actions for PurchaseOrder model.
 */
class PurchaseorderController extends Controller
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
     * Lists all PurchaseOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurchaseorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $sales = ArrayHelper::map(Karyawan::find()->all(),'id',
                function($model){
                    return $model['nama_pendek'];
                });
        $kota = ArrayHelper::map(City::find()->all(),'id',
                function($model){
                    return $model['kota'];
                });

        if(Yii::$app->user->identity->type == 'Marketing'){
            $customer = ArrayHelper::map(PurchaseOrder::find()->where(['sales'=>Yii::$app->user->identity->profilname])->all(),'perusahaan',
                function($model){
                $query=Customer::find()->where(['id'=>$model['perusahaan']])->all();
                  foreach ($query as $key){
                    return $key['perusahaan'];
                  }
                });
        }else{
            $customer = ArrayHelper::map(PurchaseOrder::find()->all(),'perusahaan',
                function($model){
                $query=Customer::find()->where(['id'=>$model['perusahaan']])->all();
                  foreach ($query as $key){
                    return $key['perusahaan'];
                  }
                });
        }

        return $this->render('index', [
            'sales' => $sales,
            'kota' => $kota,
            'customer' => $customer,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReview()
    {
        $searchModel = new PurchasereviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $sales = ArrayHelper::map(Karyawan::find()->all(),'id',
                function($model){
                    return $model['nama_pendek'];
                });
        $kota = ArrayHelper::map(City::find()->all(),'id',
                function($model){
                    return $model['kota'];
                });

        if(Yii::$app->user->identity->type == 'Marketing'){
            $customer = ArrayHelper::map(PurchaseOrder::find()->where(['sales'=>Yii::$app->user->identity->profilname])->all(),'perusahaan',
                function($model){
                $query=Customer::find()->where(['id'=>$model['perusahaan']])->all();
                  foreach ($query as $key){
                    return $key['perusahaan'];
                  }
                });
        }else{
            $customer = ArrayHelper::map(PurchaseOrder::find()->all(),'perusahaan',
                function($model){
                $query=Customer::find()->where(['id'=>$model['perusahaan']])->all();
                  foreach ($query as $key){
                    return $key['perusahaan'];
                  }
                });
        }

        return $this->render('review', [
            'sales' => $sales,
            'kota' => $kota,
            'customer' => $customer,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHasilpo($range)
    {
        $model = new PurchaseOrder();
        if ($model->load(Yii::$app->request->post())) {
            $set_awal = Yii::$app->formatter->asDate($model->set_awal,'yyyy-MM-dd');
            $set_akhir = Yii::$app->formatter->asDate($model->set_akhir,'yyyy-MM-dd');
            
            return $this->redirect(['hasilpo','range'=>$set_awal.'x'.$set_akhir]);
        }
        return $this->render('hasilpo',['model'=>$model]);
    }

    /**
     * Displays a single PurchaseOrder model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        //paid
        $modelpaid = new PurchaseOrderPaid();
        if ($modelpaid->load(Yii::$app->request->post()) ) {
            //process
            $modelpaid->paid_date=Yii::$app->formatter->asDate($modelpaid->paid_date,'yyyy-MM-dd');
            $modelpaid->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        //files
        $modelfile = new PurchaseOrderFile();
        if ($modelfile->load(Yii::$app->request->post()) ) {
            //process
            $modelfile->purchase_order_id = $id;
            $modelfile->tgl_kirim=Yii::$app->formatter->asDate($modelfile->tgl_kirim,'yyyy-MM-dd');
            $modelfile->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if(isset($_POST['tolak'])){
            Yii::$app->db->createCommand()->update('id_purchase_order',
            ['alasan_tolak' => $_POST['PurchaseOrder']['alasan_tolak'],'status'=>'Ditolak'],
            ['id'=>$model->id])->execute();
            return $this->redirect(['view','id' => $model->id]);
        }

        if(isset($_POST['po_send'])){

            //set jatuh tempo
            if($model->termin == 'Cash On Delivery' || $model->termin == 'Cash Before Delivery'){
                $jatuh_tempo = $model->tgl_kirim;
            }elseif($model->termin == 'Tempo 7 Hari'){
                $jatuh_tempo = date('Y-m-d', strtotime('+7 days', strtotime($model->tgl_kirim)));
            }elseif($model->termin == 'Tempo 14 Hari'){
                $jatuh_tempo = date('Y-m-d', strtotime('+14 days', strtotime($model->tgl_kirim)));
            }elseif($model->termin == 'Tempo 21 Hari'){
                $jatuh_tempo = date('Y-m-d', strtotime('+21 days', strtotime($model->tgl_kirim)));
            }elseif($model->termin == 'Tempo 30 Hari'){
                $jatuh_tempo = date('Y-m-d', strtotime('+30 days', strtotime($model->tgl_kirim)));
            }

            Yii::$app->db->createCommand()->update('id_purchase_order',
            ['status'=>'Terkirim','jatuh_tempo'=>$jatuh_tempo,'driver_id'=>$_POST['PurchaseOrder']['driver_id']],
            ['id'=>$model->id])->execute();

            $expired_pusat = date('Y-m-d', strtotime('+60 days', strtotime($model->tgl_kirim)));
            Yii::$app->db->createCommand()->update('id_customer',
            ['expired'=>'2070-01-01','expired_pusat'=>$expired_pusat],
            ['id'=>$model->perusahaan])->execute();

            return $this->redirect(['view','id' => $model->id]);
        }

        return $this->render('view', [
            'model' => $model,
            'modelpaid' => $modelpaid,
            'modelfile' => $modelfile,
        ]);
    }
    public function actionAccpo($id)
    {
        $model = $this->findModel($id);

        Yii::$app->db->createCommand()->update('id_purchase_order',
        ['status'=>'Disetujui'],
        ['id'=>$model->id])->execute();

        return $this->redirect(['view','id' => $model->id]);
    }
    public function actionDontsendpo($id)
    {
        $model = $this->findModel($id);

        Yii::$app->db->createCommand()->update('id_purchase_order',
        ['status'=>'Batal Kirim'],
        ['id'=>$model->id])->execute();

        return $this->redirect(['view','id' => $model->id]);
    }
    public function actionPaidpo($id)
    {
        $model = $this->findModel($id);

        $last_paid = PurchaseOrderPaid::find()->where(['purchase_order_id'=>$model->id])->orderBy(['paid_date'=>SORT_DESC])->one();

        $range = strtotime($last_paid['paid_date']) - strtotime($model->tgl_kirim); 
        $range_paid = $range/60/60/24;

        Yii::$app->db->createCommand()->update('id_purchase_order',
        ['status'=>'Terbayar-Selesai','tgl_lunas'=>$last_paid['paid_date'],'range_paid'=>$range_paid],
        ['id'=>$model->id])->execute();

        return $this->redirect(['view','id' => $model->id]);
    }
    public function actionCalculaterange($id){
        $model = $this->findModel($id);

        $range = strtotime($model->tgl_lunas) - strtotime($model->tgl_kirim); 
        $range_paid = $range/60/60/24;

        Yii::$app->db->createCommand()->update('id_purchase_order',
        ['range_paid'=>$range_paid],
        ['id'=>$model->id])->execute();

        return $this->redirect(['view','id' => $model->id]);
    }
    public function actionPrint($id)
    {
        return $this->renderPartial('print', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Creates a new PurchaseOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PurchaseOrder();

        if ($model->load(Yii::$app->request->post())) {
            //process
            $model->tgl_po=Yii::$app->formatter->asDate($_POST['PurchaseOrder']['tgl_po'],'yyyy-MM-dd');
            $model->tgl_kirim=Yii::$app->formatter->asDate($_POST['PurchaseOrder']['tgl_kirim'],'yyyy-MM-dd');
            $model->status='Pending';

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PurchaseOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            //process
            $model->tgl_po=Yii::$app->formatter->asDate($_POST['PurchaseOrder']['tgl_po'],'yyyy-MM-dd');
            $model->tgl_kirim=Yii::$app->formatter->asDate($_POST['PurchaseOrder']['tgl_kirim'],'yyyy-MM-dd');
            if($model->jatuh_tempo != NULL){
                $model->jatuh_tempo=Yii::$app->formatter->asDate($_POST['PurchaseOrder']['jatuh_tempo'],'yyyy-MM-dd');
            }
            if($model->tgl_lunas != NULL){
                $model->tgl_lunas=Yii::$app->formatter->asDate($_POST['PurchaseOrder']['tgl_lunas'],'yyyy-MM-dd');
            }
            
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PurchaseOrder model.
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
     * Finds the PurchaseOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurchaseOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurchaseOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /*
    EXPORT WITH OPENTBS
    */
    public function actionExportExcel2($range)
    {
        $data = explode("x", $_GET['range']);
        $set_awal = $data[0];
        $set_akhir = $data[1];
        $query = PurchaseOrder::find()->where(['between','tgl_kirim',$set_awal,$set_akhir]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=> false,
        ]);
        
        // Initalize the TBS instance
        $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
        // Change with Your template kaka
        $template = Yii::getAlias('@hscstudio/export').'/templates/opentbs/purchaseorder.xlsx';
        $OpenTBS->LoadTemplate($template); // Also merge some [onload] automatic fields (depends of the type of document).
        //$OpenTBS->VarRef['modelName']= "Mahasiswa";               
        $data = [];
        foreach($dataProvider->getModels() as $po){
            $data[] = [
                'tgl_po'=>$po->tgl_po,
                'tgl_kirim'=>$po->tgl_kirim,
                'perusahaan'=>$po->customer->perusahaan,
                'sales'=>$po->karyawan->nama_pendek,
                'volume'=>$po->volume,
                'termin'=>$po->termin,
                'status'=>$po->status,
                'tgl_lunas'=>$po->tgl_lunas,
            ];
        }
        
        $OpenTBS->MergeBlock('data', $data);
        // Output the result as a file on the server. You can change output file
        $filename = 'Purchase Order '.$_GET['range'].'.xlsx';
        $OpenTBS->Show(OPENTBS_DOWNLOAD, $filename); // Also merges all [onshow] automatic fields.          
        exit;
    }
}
