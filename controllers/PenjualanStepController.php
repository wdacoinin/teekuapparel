<?php

namespace app\controllers;

use app\models\PenjualanStepT;
use app\models\PenjualanStep;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PenjualanStepController implements the CRUD actions for PenjualanStepT model.
 */
class PenjualanStepController extends Controller
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
     * Lists all PenjualanStepT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PenjualanStep();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PenjualanStepT model.
     * @param int $penjualan_step Penjualan Step
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($penjualan_step)
    {
        return $this->render('view', [
            'model' => $this->findModel($penjualan_step),
        ]);
    }

    /**
     * Creates a new PenjualanStepT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PenjualanStepT();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'penjualan_step' => $model->penjualan_step]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PenjualanStepT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $penjualan_step Penjualan Step
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($penjualan_step)
    {
        $model = $this->findModel($penjualan_step);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'penjualan_step' => $model->penjualan_step]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PenjualanStepT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $penjualan_step Penjualan Step
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($penjualan_step)
    {
        $this->findModel($penjualan_step)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PenjualanStepT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $penjualan_step Penjualan Step
     * @return PenjualanStepT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($penjualan_step)
    {
        if (($model = PenjualanStepT::findOne($penjualan_step)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
