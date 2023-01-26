<?php

namespace app\controllers;

use app\models\BahanBakuSoT;
use app\models\BahanBakuSo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BahanBakuSoController implements the CRUD actions for BahanBakuSoT model.
 */
class BahanBakuSoController extends Controller
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
     * Lists all BahanBakuSoT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BahanBakuSo();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BahanBakuSoT model.
     * @param int $bahan_baku_so Bahan Baku So
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($bahan_baku_so)
    {
        return $this->render('view', [
            'model' => $this->findModel($bahan_baku_so),
        ]);
    }

    /**
     * Creates a new BahanBakuSoT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BahanBakuSoT();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'bahan_baku_so' => $model->bahan_baku_so]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BahanBakuSoT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $bahan_baku_so Bahan Baku So
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($bahan_baku_so)
    {
        $model = $this->findModel($bahan_baku_so);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'bahan_baku_so' => $model->bahan_baku_so]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BahanBakuSoT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $bahan_baku_so Bahan Baku So
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($bahan_baku_so)
    {
        $this->findModel($bahan_baku_so)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BahanBakuSoT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $bahan_baku_so Bahan Baku So
     * @return BahanBakuSoT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($bahan_baku_so)
    {
        if (($model = BahanBakuSoT::findOne($bahan_baku_so)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
