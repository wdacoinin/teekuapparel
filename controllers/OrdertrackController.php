<?php

namespace app\controllers;

use Yii;
use app\models\Ordertrackv;
use app\models\Ordertrack;
use app\models\PenjualanProdukT;
use app\models\PenjualanStepT;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * OrdertrackController implements the CRUD actions for Ordertrackv model.
 */
class OrdertrackController extends Controller
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
     * Lists all Ordertrackv models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Ordertrack();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Ordertrackv model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new Ordertrackv();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'penjualan' => $model->penjualan]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Ordertrackv model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $penjualan Penjualan
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($penjualan, $penjualan_step)
    {
        $this->layout = 'kosong';
        //$model = $this->findModel($penjualan);
        $selectedStep = PenjualanStepT::findOne($penjualan_step);

        $model = new PenjualanStepT();
        $model->penjualan = $penjualan;

        $modPP = PenjualanProdukT::find()->select('SUM(penjualan_jml) AS total')->where(['penjualan' => $penjualan])->asArray()->one();
        if($modPP != null){
            $qty = $modPP['total'];
        }else{
            $qty = 1;
        }
        $model->jml = $qty;

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->load($this->request->post())) {

                $model->user = Yii::$app->user->identity->id;
                $model->start = date('Y-m-d H:i:s');

                $selectedStep->end = date('Y-m-d H:i:s');
                if($selectedStep->save()){
                    $model->save();
                }
                return $this->redirect(['index']);

            }
            //return $this->redirect(Url::to(['tracking-order/index']));
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'selectedStep' => $selectedStep,
        ]);
    }

    /**
     * Deletes an existing Ordertrackv model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $penjualan Penjualan
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /* public function actionDelete($penjualan)
    {
        $this->findModel($penjualan)->delete();

        return $this->redirect(['index']);
    } */

    /**
     * Finds the Ordertrackv model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $penjualan Penjualan
     * @return Ordertrackv the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($penjualan)
    {
        if (($model = Ordertrackv::findOne($penjualan)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
