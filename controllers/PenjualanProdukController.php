<?php

namespace app\controllers;

use yii;
use app\models\PenjualanProdukT;
use app\models\PenjualanProduk;
use app\models\PenjualanProdukDetails;
use app\models\Produk;
use app\models\ProdukDetailOnProduk;
use app\models\ProdukDetailT;
use app\models\ProdukT;
use Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * PenjualanProdukController implements the CRUD actions for PenjualanProdukT model.
 */
class PenjualanProdukController extends Controller
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
     * Lists all PenjualanProdukT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PenjualanProduk();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PenjualanProdukT model.
     * @param int $penjualan_produk Penjualan Produk
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($penjualan_produk)
    {
        return $this->render('view', [
            'model' => $this->findModel($penjualan_produk),
        ]);
    }

    /**
     * Creates a new PenjualanProdukT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($penjualan)
    {
        $model = new ProdukDetailT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            //get harga pokok produk
            if(ProdukT::findOne($model->produk) !== null){
                $modProduk = ProdukT::findOne($model->produk);

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $modPP = new PenjualanProdukT();

                    $modPP->penjualan = $penjualan;
                    $modPP->produk = (int) $model->produk;
                    $modPP->sku = (int) $model->sku;
                    $modPP->penjualan_hpp = $modProduk->harga_pokok;
                    $modPP->penjualan_harga = $modProduk->harga_jual;
                    $modPP->penjualan_jml = (int) $model->qty;
                    $modPP->nick = $model->nick;

                    if($modPP->save()){
                        //var_dump($model);die;
                        if($model->size != ''){
                            
                            $models = new ProdukDetailT();
                            $models->penjualan_produk = (int) $modPP->penjualan_produk;
                            $models->produk_item = (int) $model->size;
                            $models->save();
                        }

                        if($model->neck != ''){
                            $modeln = new ProdukDetailT();
                            $modeln->penjualan_produk = (int) $modPP->penjualan_produk;
                            $modeln->produk_item = (int) $model->neck;
                            $modeln->save();
                        }

                        if($model->lengan != ''){
                            $modell = new ProdukDetailT();
                            $modell->penjualan_produk = (int) $modPP->penjualan_produk;
                            $modell->produk_item = (int) $model->lengan;
                            $modell->save();
                        }

                        if($model->vareasi != ''){
                            $modelv = new ProdukDetailT();
                            $modelv->penjualan_produk = (int) $modPP->penjualan_produk;
                            $modelv->produk_item = (int) $model->vareasi;
                            $modelv->save();
                        }
                        
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Data berhasil disimpan!');
                        //return $this->redirect(['penjualan-produk/update', 'penjualan_produk' => $modPP->penjualan_produk]);
                    }else{
                        Yii::$app->session->setFlash('warning', 'Gagal simpan');
                        $transaction->rollback();
                    }
                    return $this->redirect(['penjualan/update', 'penjualan' => $penjualan]);
                } catch (Exception $ex) {
                    Yii::$app->session->setFlash('warning', 'Error gagal simpan '.$ex);
                    $transaction->rollback();
                    return $this->redirect(['penjualan/update', 'penjualan' => $penjualan]);
                }

            }else{
                Yii::$app->session->setFlash('error', 'Produk idak dipilih/kosong');
                return $this->redirect(['penjualan/update', 'penjualan' => $penjualan]);
            }
        } else {
            
            return $this->renderAjax('create', [
                'model' => $model
            ]);
        }

    }

    /**
     * Updates an existing PenjualanProdukT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $penjualan_produk Penjualan Produk
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdatenick($penjualan_produk)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($penjualan_produk);

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Data berhasil disimpan!');
                return $this->redirect(['penjualan-produk/update', 'penjualan_produk' => $penjualan_produk]);
            }
            else {
                Yii::$app->session->setFlash('error', 'Data tidak berhasil di input');
                return $this->redirect(['penjualan-produk/update', 'penjualan_produk' => $penjualan_produk]);
            }
        } else {
            
            return $this->renderAjax('updatenick', [
                'model' => $model,
            ]);
        }
    }

    
    public function actionUpdate($penjualan_produk)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($penjualan_produk);
        $faktur = $model->penjualan0->faktur;

        $searchModel = new ProdukDetailOnProduk();
        $dataProvider = $searchModel->search($this->request->queryParams, $penjualan_produk);

        $searchModel1 = new PenjualanProdukDetails();
        $dataProvider1 = $searchModel1->search($this->request->queryParams, $penjualan_produk);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['penjualan-produk/update', 'penjualan_produk' => $penjualan_produk]);
        }

        return $this->render('update', [
            'model' => $model,
            'faktur' => $faktur,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel1' => $searchModel1,
            'dataProvider1' => $dataProvider1,
        ]);
    }

    /**
     * Deletes an existing PenjualanProdukT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $penjualan_produk Penjualan Produk
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeletedetail($produk_detail, $penjualan_produk)
    {
        $model = ProdukDetailT::findOne($produk_detail);
        $model->delete();

        return $this->redirect(['penjualan-produk/update', 'penjualan_produk' => $penjualan_produk]);
    }

    /**
     * Deletes an existing PenjualanProdukT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $penjualan_produk Penjualan Produk
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($penjualan_produk)
    {
        $this->findModel($penjualan_produk)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PenjualanProdukT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $penjualan_produk Penjualan Produk
     * @return PenjualanProdukT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($penjualan_produk)
    {
        if (($model = PenjualanProdukT::findOne($penjualan_produk)) !== null) {
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
