<?php

namespace app\controllers;

use Yii;
use app\models\PurchaseReview;
use app\models\Customer;
use app\models\search\PurchasereviewSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * PurchasereviewController implements the CRUD actions for PurchaseReview model.
 */
class PurchasereviewController extends Controller
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
     * Lists all PurchaseReview models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurchasereviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PurchaseReview model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel2($id);
        $detail = PurchaseReview::find()->where(['perusahaan_id'=>$id])->one();
        return $this->render('view', [
            'model' => $model,
            'detail' => $detail
        ]);
    }

    /**
     * Creates a new PurchaseReview model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new PurchaseReview();
        $customer = $this->findModel2($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $customer->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'customer' => $customer,
        ]);
    }

    /**
     * Updates an existing PurchaseReview model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = PurchaseReview::find()->where(['perusahaan_id'=>$id])->one();
        $customer = $this->findModel2($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $customer->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'customer' => $customer,
        ]);
    }

    /**
     * Deletes an existing PurchaseReview model.
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
     * Finds the PurchaseReview model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurchaseReview the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurchaseReview::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModel2($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
