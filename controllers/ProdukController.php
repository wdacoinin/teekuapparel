<?php

namespace app\controllers;

use yii;
use app\models\ProdukT;
use app\models\Produk;
use app\models\ProdukDetailOnProduk;
use app\models\ProdukDetailT;
use app\models\ProdukItemT;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProdukController implements the CRUD actions for ProdukT model.
 */
class ProdukController extends Controller
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
     * Lists all ProdukT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Produk();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProdukT model.
     * @param int $produk Produk
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($produk)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($produk),
        ]);
    }

    /**
     * Creates a new ProdukT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new ProdukT();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'produk' => $model->produk]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProdukT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $produk Produk
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($produk)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($produk);

        $searchModel = new ProdukDetailOnProduk();
        $dataProvider = $searchModel->search($this->request->queryParams, $produk);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'produk' => $model->produk]);
        }

        return $this->render('update', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing ProdukT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $produk Produk
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($produk)
    {
        $this->findModel($produk)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProdukT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $produk Produk
     * @return ProdukT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($produk)
    {
        if (($model = ProdukT::findOne($produk)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /*public function beforeAction($action){

        if (Yii::$app->user->isGuest){
            return $this->redirect(['site/login'])->send();  // login path
        }
    }*/
}
