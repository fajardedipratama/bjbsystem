<?php

namespace app\controllers;

use Yii;
use app\models\Dailyreport;
use app\models\search\DailyreportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Karyawan;
use app\models\Customer;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
/**
 * DailyreportController implements the CRUD actions for Dailyreport model.
 */
class DailyreportController extends Controller
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
     * Lists all Dailyreport models.
     * @return mixed
     */
    public function actionIndex($waktu)
    {
        $searchModel = new DailyreportSearch();

        $model = new Dailyreport();
        if ($model->load(Yii::$app->request->post()) ) {
            $waktu = Yii::$app->formatter->asDate($model->waktu,'yyyy-MM-dd');
            return $this->redirect(['index','waktu'=>$waktu]);
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $sales = ArrayHelper::map(Karyawan::find()->where(['posisi'=>6,'status_aktif'=>'Aktif'])->all(),'id',
                function($model){
                    return $model['nama_pendek'];
                });
        $customer = ArrayHelper::map(Customer::find()->all(),'id',
                function($model){
                    return $model['perusahaan'];
                });

        return $this->render('index', [
            'sales' => $sales,
            'customer' => $customer,
            'searchModel' => $searchModel,
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearch()
    {
        $searchModel = new DailyreportSearch();

        if ($searchModel->load(Yii::$app->request->post()) ) {
            return $this->redirect(['/dailyreport','waktu'=>date('Y-m-d')]);
        }

        return $this->render('index',['searchModel' => $searchModel]);
    }

    /**
     * Displays a single Dailyreport model.
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

    /**
     * Creates a new Dailyreport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dailyreport();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Dailyreport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'waktu'=>date('Y-m-d') ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Dailyreport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'waktu'=>date('Y-m-d')]);
    }

    public function actionDelete2($id)
    {
        $model=$this->findModel($id);
        $model->delete();

        return $this->redirect(['customer/view', 'id'=>$model->perusahaan]);
    }

    /*
    EXPORT WITH OPENTBS
    */
    public function actionExportExcel2($waktu)
    {
        $query = Dailyreport::find()->where(['like', 'waktu', $_GET['waktu'] . '%', false]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=> false,
            'sort'=>['defaultOrder'=>['sales'=>SORT_ASC]]
        ]);
        
        // Initalize the TBS instance
        $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
        // Change with Your template kaka
        $template = Yii::getAlias('@hscstudio/export').'/templates/opentbs/dailyreport.xlsx';
        $OpenTBS->LoadTemplate($template); // Also merge some [onload] automatic fields (depends of the type of document).
        //$OpenTBS->VarRef['modelName']= "Mahasiswa";               
        $data = [];
        foreach($dataProvider->getModels() as $daily){
            $data[] = [
                'sales'=>$daily->karyawan->nama_pendek,
                'waktu'=>$daily->waktu,
                'perusahaan'=>$daily->customer->perusahaan,
                'telfon'=>$daily->customer->telfon,
                'keterangan'=>$daily->keterangan,
                'catatan'=>$daily->catatan,
                'con_used'=>$daily->con_used,
            ];
        }
        
        $OpenTBS->MergeBlock('data', $data);
        // Output the result as a file on the server. You can change output file
        $filename = 'Daily Report '.date('d-m-y',strtotime($_GET['waktu'])).'.xlsx';
        $OpenTBS->Show(OPENTBS_DOWNLOAD, $filename); // Also merges all [onshow] automatic fields.          
        exit;
    } 

    /**
     * Finds the Dailyreport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dailyreport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dailyreport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
