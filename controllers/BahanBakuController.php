<?php

namespace app\controllers;

use yii;
use app\models\BahanBakuT;
use app\models\BahanBaku;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * BahanBakuController implements the CRUD actions for BahanBakuT model.
 */
class BahanBakuController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all BahanBakuT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new BahanBaku();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BahanBakuT model.
     * @param int $bahan_baku Bahan Baku
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($bahan_baku)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($bahan_baku),
        ]);
    }

    /**
     * Creates a new BahanBakuT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new BahanBakuT();
        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Data berhasil disimpan!');
            }
            else {
                Yii::$app->session->setFlash('error', 'Data tidak berhasil di input');
            }
            return $this->redirect(['index']);
        } else {
            
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BahanBakuT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $bahan_baku Bahan Baku
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($bahan_baku)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($bahan_baku);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'bahan_baku' => $model->bahan_baku]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BahanBakuT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $bahan_baku Bahan Baku
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($bahan_baku)
    {
        $this->findModel($bahan_baku)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BahanBakuT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $bahan_baku Bahan Baku
     * @return BahanBakuT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($bahan_baku)
    {
        if (($model = BahanBakuT::findOne($bahan_baku)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
