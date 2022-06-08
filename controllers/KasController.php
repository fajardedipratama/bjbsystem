<?php

namespace app\controllers;

use Yii;
use app\models\Kas;
use app\models\KasDetail;
use app\models\search\KasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * KasController implements the CRUD actions for Kas model.
 */
class KasController extends Controller
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
     * Lists all Kas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kas model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $newModel = new KasDetail();

        if(isset($_POST['simpan'])){
         if ($newModel->load(Yii::$app->request->post())) {
            $newModel->kas_id = $id;
            $newModel->tgl_kas = date('Y-m-d');
            if($newModel->jenis === 'Masuk'){
                $newModel->saldo_akhir = $model->saldo+$newModel->nominal;
            }else{
                $newModel->saldo_akhir = $model->saldo-$newModel->nominal;
            }
            $newModel->save();

            Yii::$app->db->createCommand()->update('id_kas',
            ['saldo' =>  $newModel->saldo_akhir ],
            ['id'=>$model->id])->execute();

            return $this->redirect(['view', 'id' => $id]);
         }
        }

        if(isset($_POST['print'])){
            $newModel->tgl_kas = Yii::$app->formatter->asDate($_POST['KasDetail']['tgl_kas'],'yyyy-MM-dd');
            return $this->redirect(['/kasdetail/print', 'tgl' => $newModel->tgl_kas]);
        }

        return $this->render('view', [
            'model' => $model,
            'newModel' => $newModel,
        ]);
    }

    /**
     * Creates a new Kas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Kas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Kas model.
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
     * Finds the Kas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
