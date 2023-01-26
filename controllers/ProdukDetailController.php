<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\ProdukDetailT;
use app\models\ProdukDetail;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProdukDetailController implements the CRUD actions for ProdukDetailT model.
 */
class ProdukDetailController extends Controller
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
     * Lists all ProdukDetailT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProdukDetail();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProdukDetailT model.
     * @param int $produk_detail Produk Detail
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($produk_detail)
    {
        return $this->render('view', [
            'model' => $this->findModel($produk_detail),
        ]);
    }

    /**
     * Creates a new ProdukDetailT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($penjualan_produk)
    {
        $this->layout = 'kosong';
        $model = new ProdukDetailT();
        $model->penjualan_produk = (int) $penjualan_produk;

        //validation
        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->load($this->request->post())) {
                $chec = ProdukDetailT::find()->where(['penjualan_produk' => $penjualan_produk, 'produk_item' => $model->produk_item])->count();
                if((int) $chec > 0){
                    Yii::$app->session->setFlash('Item sudah ada di produk');
                }else{

                    $model->penjualan_produk = (int) $model->penjualan_produk;
                    $model->produk_item = (int) $model->produk_item;

                    //var_dump($model->validate());die;
                    $model->save();
                    //Yii::$app->session->setFlash('success', 'Traking Updated!');
                }
            }

            return $this->redirect(['penjualan-produk/update', 'penjualan_produk' => $penjualan_produk]);

        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProdukDetailT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $produk_detail Produk Detail
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($produk_detail)
    {
        $model = $this->findModel($produk_detail);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'produk_detail' => $model->produk_detail]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProdukDetailT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $produk_detail Produk Detail
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($produk_detail)
    {
        $this->findModel($produk_detail)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProdukDetailT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $produk_detail Produk Detail
     * @return ProdukDetailT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($produk_detail)
    {
        if (($model = ProdukDetailT::findOne($produk_detail)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
