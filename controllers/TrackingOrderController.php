<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use app\models\Produk;
use app\models\DivisiT;
use app\models\PenjualanProduk;
use app\models\PenjualanProdukStepT;
use app\models\PenjualanProdukStep;
use app\models\TrackingOrderv;
use app\models\TrackingOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;

class TrackingOrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new TrackingOrder();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListmobile()
    {
        $this->layout = 'headerMobile';
        $searchModel = new TrackingOrder();
        $dataProvider = $searchModel->searchm($this->request->queryParams, $_GET['id'], $_GET['divisi']);

        return $this->render('listmobile', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFlatlist()
    {   $id = $_POST['id'];
        $divisi = $_POST['divisi'];
        $this->layout = 'headerMobile';
        
        $count = TrackingOrderv::find()->where(['user' => $id, 'divisi' => $divisi])->count();
        $data = TrackingOrderv::find()->where(['user' => $id, 'divisi' => $divisi])->asArray()->all();

        $datas = array(
            'hasil' => 'success',
            'data' => $data,
            'count' => $count
        );
        echo json_encode($datas);
    }

    /**
     * Creates a new PenjualanProdukStepT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionKeluar()
    {
        $this->layout = 'kosong';
        $model = PenjualanProdukStepT::findOne(['penjualan_produk_step' => $_POST['penjualan_produk_step']]);
        $model->end = date('Y-m-d H:i:s');

        //validation
        if ($model->save()) {
            $data = array(
                'hasil' => 'success'
            );
            echo json_encode($data);
        } else {
            $data = array(
                'hasil' => 'gagal'
            );
            echo json_encode($data);
        }
    }

    public function actionGetdivisi()
    {   
        $id = $_POST['id'];
        $this->layout = 'headerMobile';
        //$data = DivisiT::find()->where(['divisi' => $divisi])->asArray()->all();
        $data = (new \yii\db\Query())
        ->select([
            'user.id',
            'user.nama AS nama',
            'divisi.nama AS nama_divisi'
            ])
        ->from('user')
        ->join('LEFT JOIN', 'divisi', 'user.divisi = divisi.divisi')
        ->where(['id' => $id])
        ->all();

        $datas = array(
            'hasil' => 'success',
            'data' => $data
        );
        echo json_encode($datas);
    }

    /**
     * Displays a single PenjualanProdukStepT model.
     * @param int $penjualan_produk_step Penjualan Produk Step
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($penjualan_produk_step)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($penjualan_produk_step),
        ]);
    }

    /**
     * Creates a new PenjualanProdukStepT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new PenjualanProdukStepT();
        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->load($this->request->post())) {
                $checklist = PenjualanProdukStep::findOne(['penjualan_produk' => $model->penjualan_produk, 'divisi' => Yii::$app->user->identity->divisi]);
                if($checklist !== null){
                    Yii::$app->session->setFlash('success', 'Traking Sudah ada di list!');
                }else{
                    $model->save();
                    Yii::$app->session->setFlash('success', 'Traking Updated!');
                }

            }
            return $this->redirect(Url::to(['tracking-order/index']));
        } else {
            
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    

    /**
     * Creates a new PenjualanProdukStepT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionViewmobile()
    {
        $this->layout = 'headerMobile';
        $model = new PenjualanProdukStepT();
        
        //validation
        if (isset($_GET['id']) &&  $_GET['id'] !== '' && $_GET['divisi'] !== '' && $_GET['penjualan_produk'] !== '') {
            $id = $_GET['id'];
            $divisi = $_GET['divisi'];
            $penjualan_produk = $_GET['penjualan_produk'];
            //return ActiveForm::validate($model);
            $model->user = $_GET['id'];
            $model->divisi = $_GET['divisi'];
            $model->penjualan_produk = $_GET['penjualan_produk'];

            
            //validation
            if ($model->load(Yii::$app->request->post())) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }

                if ($model->load($this->request->post()) && $model->start !== '' && $model->jml > 0){
                    
                        $check = PenjualanProdukStepT::find()->where(['penjualan_produk' => $model->penjualan_produk, 'divisi' => $model->divisi])->count();

                        if($check > 0){
                            $model = null;
                            Yii::$app->session->setFlash('warning', 'Tracking Sudah ada di list!');
                            return $this->render('viewmobile', [
                                'model' => $model,
                            ]);
                        }else{

                            if($model->save()){
                                $model = null;
                                Yii::$app->session->setFlash('success', 'Tracking berhasil masuk.');
                                /* return $this->render(['viewmobile', 'save' => true], [
                                    'model' => $model,
                                ]); */
                                $this->redirect(Url::to(['tracking-order/viewmobile', 'save' => true]));
                            }else{
                                Yii::$app->session->setFlash('danger', 'Error!');
                                $model = null;
                                return $this->render('viewmobile', [
                                    'model' => $model,
                                ]);
                            }
                            
                        }

                }
            }
            
            //Yii::$app->session->setFlash('danger', 'Error!');
            //$model = null;
            return $this->render('viewmobile', [
                'model' => $model,
            ]);
        } else {
            $model = null;
            Yii::$app->session->setFlash('success', 'Produksi masuk divisi.');
            return $this->render('viewmobile', [
                'model' => $model,
            ]);
        }

        
    }

    /**
     * Updates an existing PenjualanProdukStepT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $penjualan_produk_step Penjualan Produk Step
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($penjualan_produk_step)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($penjualan_produk_step);

        /* if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'penjualan_produk_step' => $model->penjualan_produk_step]);
        }

        return $this->render('update', [
            'model' => $model,
        ]); */

        
        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->load($this->request->post())) {
                    $model->save();
                    Yii::$app->session->setFlash('success', 'Traking Updated!');
            }
            return $this->redirect(Url::to(['tracking-order/index']));
        } else {
            
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PenjualanProdukStepT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $penjualan_produk_step Penjualan Produk Step
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($penjualan_produk_step)
    {
        $this->findModel($penjualan_produk_step)->delete();

        return $this->redirect(['index']);
    }

     /**
     * Deletes an existing PenjualanProdukStepT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $penjualan_produk Penjualan Produk Step
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCheckqty($penjualan_produk)
    {
        
        $row = PenjualanProduk::findOne($penjualan_produk);

        /* $data = array(
            'penjualan_jml' => $row->penjualan_jml
        ); */

        return json_encode($row->penjualan_jml);
    }

    /**
     * Finds the PenjualanProdukStepT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $penjualan_produk_step Penjualan Produk Step
     * @return PenjualanProdukStepT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($penjualan_produk_step)
    {
        if (($model = PenjualanProdukStepT::findOne($penjualan_produk_step)) !== null) {
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
