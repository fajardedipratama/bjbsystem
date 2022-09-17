<?php

namespace app\controllers;

use Yii;
use app\models\Pelamar;
use app\models\PelamarJadwal;
use app\models\Karyawan;
use app\models\search\PelamarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PelamarController implements the CRUD actions for Pelamar model.
 */
class PelamarController extends Controller
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
     * Lists all Pelamar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PelamarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pelamar model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $formjadwal = new Pelamarjadwal();
        if ($formjadwal->load(Yii::$app->request->post())) {

            $formjadwal->tanggal=Yii::$app->formatter->asDate($formjadwal->tanggal,'yyyy-MM-dd');
            $formjadwal->id_pelamar=$id;
            $formjadwal->save();
            $model->status = $formjadwal->jenis;
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('view', [
            'model' => $model,
            'formjadwal' => $formjadwal,
        ]);
    }

    /**
     * Creates a new Pelamar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pelamar();

        if ($model->load(Yii::$app->request->post())) {

            $model->tanggal_lahir=Yii::$app->formatter->asDate($model->tanggal_lahir,'yyyy-MM-dd');
            $model->status='Belum diproses';
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionAccept($id)
    {
        $data = $this->findModel($id);
        $model = new Karyawan();

        $nip_max = Karyawan::find()->max('badge');
        $model->badge = $nip_max+1;
        $model->nama = $data->nama;
        $model->nama_pendek = $data->nama;
        $model->gender = $data->gender;
        $model->tempat_lahir = $data->tempat_lahir;
        $model->tanggal_lahir = $data->tanggal_lahir;
        $model->no_hp = $data->no_hp;
        $model->alamat_rumah = $data->alamat;
        $model->tanggal_masuk = date('Y-m-d');
        $model->posisi = $data->posisi;
        $model->departemen = $data->departemen;
        $model->status_aktif = "Aktif";
        $model->save();

        $data->status = 'Diterima';
        $data->save();

        return $this->redirect(['karyawan/view', 'id' => $model->id]);
    }

    public function actionDecline($id)
    {
        $model = $this->findModel($id);

        $model->status = 'Ditolak';
        $model->save();

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Updates an existing Pelamar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->tanggal_lahir=Yii::$app->formatter->asDate($model->tanggal_lahir,'yyyy-MM-dd');
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionUlasan($id,$interview)
    {
        $model = $this->findModel($id);
        $model2 = $this->findModel2($interview);

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $model2->kehadiran = "hadir";
            $model2->save();
            return $this->redirect(['pelamarjadwal/index']);
        }

        return $this->render('ulasan', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pelamar model.
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
     * Finds the Pelamar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pelamar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pelamar::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModel2($id)
    {
        if (($model = PelamarJadwal::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
