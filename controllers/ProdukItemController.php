<?php

namespace app\controllers;

use app\models\ProdukItemT;
use app\models\ProdukItem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProdukItemController implements the CRUD actions for ProdukItemT model.
 */
class ProdukItemController extends Controller
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
     * Lists all ProdukItemT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new ProdukItem();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProdukItemT model.
     * @param int $produk_item Produk Item
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($produk_item)
    {
        return $this->render('view', [
            'model' => $this->findModel($produk_item),
        ]);
    }

    /**
     * Creates a new ProdukItemT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new ProdukItemT();
        $model->produk_item_status = 'Aktif';

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProdukItemT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $produk_item Produk Item
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($produk_item)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($produk_item);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['update', 'produk_item' => $model->produk_item]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProdukItemT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $produk_item Produk Item
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($produk_item)
    {
        $this->findModel($produk_item)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProdukItemT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $produk_item Produk Item
     * @return ProdukItemT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($produk_item)
    {
        if (($model = ProdukItemT::findOne($produk_item)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
