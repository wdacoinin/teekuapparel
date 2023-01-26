<?php

namespace app\controllers;

use app\models\AkunLogT;
use app\models\BackendUser;
use Yii;
use app\models\PembelianT;
use app\models\Pembelian;
use app\models\PembelianBahan;
use app\models\PembelianBahanT;
use app\models\PembayaranPembelianID;
use app\models\DocPembT;
use app\models\SupplierT;
use app\models\VariableT;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\mpdf\Pdf;

/**
 * PembelianController implements the CRUD actions for PembelianT model.
 */
class PembelianController extends Controller
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
     * Lists all PembelianT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Pembelian();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PembelianT model.
     * @param int $pembelian Pembelian
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($pembelian)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($pembelian),
        ]);
    }

    /**
     * Creates a new PembelianT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new PembelianT();

       /*  $year = date('Y');
        $checkmax = PembelianT::find()->where(["DATE_FORMAT(penjualan_tgl,'%Y')" => $year])
        ->count();
        $faktur = 'PB' . date('ymd') . sprintf("%04s", $checkmax + 1);

        $model->faktur = $faktur; */

        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->load($this->request->post())) {
                $checklist = Pembelian::findOne(['faktur' => $model->faktur]);
                if($checklist !== null){
                    Yii::$app->session->setFlash('No.Faktur Sudah dipakai');
                }else{
                    $model->save();
                    //Yii::$app->session->setFlash('success', 'Traking Updated!');
                }

            }
            //return $this->redirect(Url::to(['tracking-order/index']));
            return $this->redirect(['update', 'pembelian' => $model->pembelian]);
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PembelianT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $pembelian Pembelian
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($pembelian)
    {
        $this->layout = 'kosong';

        $searchModel = new PembayaranPembelianID();
        $dataProvider = $searchModel->search($this->request->queryParams, $pembelian);

        $model = $this->findModel($pembelian);
        $modPembelianBahan = new PembelianBahan();
        $modPembelianBahan->pembelian = $pembelian;
        $PembelianBahan = PembelianBahanT::find()->where(['pembelian' => $pembelian]);
        $DocPemb = new DocPembT();
        
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->save();

            return $this->redirect(['update', 
                'pembelian' => $pembelian
            ]);
        }

        return $this->render('update', [
            'model' => $model,
            'modPembelianBahan' => $modPembelianBahan,
            'PembelianBahan' => $PembelianBahan,
            'DocPemb' => $DocPemb,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    

    /**
     * Tabel pembelian Produk.
     * @return mixed
     */
    public function actionBahan($pembelian)
    {
        /* $penjualanProduks = PenjualanProduk::find()->where(['pembelian' => $pembelian])->asArray()->all(); */
        $row = PembelianBahan::find()->where(['pembelian' => $pembelian])->count();

        $rows = (new \yii\db\Query())
        ->select([
            'pembelian_bahan.pembelian_bahan', 
            'bahan_baku.nama', 
            'pembelian_bahan.pembelian_jml', 
            'pembelian_bahan.pembelian_harga'
            ])
        ->from('pembelian_bahan')
        ->join('LEFT JOIN', 'bahan_baku', 'pembelian_bahan.bahan_baku = bahan_baku.bahan_baku')
        ->where(['pembelian' => $pembelian])
        ->all();
        //$model->penjualan_harga = $model->penjualan_harga;

        $data=[];
        $no = 0;
        foreach ($rows as $i => $row) {
            $no++;
            $data[$i] = array(
                'opt' => '<button class="btn btn-danger" id="hapusprod" value="" onClick="hapus(\''.Url::to(['hapusbahan', 'pembelian_bahan' => $row['pembelian_bahan']]).'\')"><i class="fas fa-trash"></i></button>',
                'nama' => $row['nama'],
                'pembelian_jml' => $row['pembelian_jml'],
                'pembelian_harga' => $row['pembelian_harga'],
                'subtotal' => $row['pembelian_jml']*$row['pembelian_harga'],
            );
        }
        
                    
        $data = array(
            'rows' => $data,
            'total' => $row,
        );

        return json_encode($data);
    }

    
    /** $pembelian_bahan
     * @return mixed 
     */
    public function actionHapusbahan($pembelian_bahan)
    {
        
        $modPembelianBahanT = PembelianBahanT::findOne($pembelian_bahan);
        if($modPembelianBahanT->delete()){

            //return $this->redirect(['update', 'pembelian' => $pembelian]);
            $data = array(
                'hasil' => 'success'
            );
            
            return json_encode($data);

        }else{

            $data = array(
                'hasil' => 'gagal'
            );
            
            return json_encode($data);
        }

    }

    /** $akun_log $pembelian
     * @return mixed 
     */
    public function actionDeletebayar($akun_log, $pembelian, $id_img)
    {
        
        $AkunLogT = AkunLogT::findOne($akun_log);
        //echo var_dump($upload_dir);

        if($AkunLogT->delete()){
            $this->actionDeletenota($id_img);
            return $this->redirect(['update', 'pembelian' => $pembelian]);
        }

    }

    /** $id_img, $pembelian
     * @return mixed 
     */
    public function actionDeletenota($id_img)
    {
        
        //$id_img = (int)\Yii::$app->request->post('key');

        //echo json_encode($id_img);
        
        $DocPemb = DocPembT::findOne($id_img);
        //echo var_dump($upload_dir);

        if($DocPemb->delete()){

            $exp = explode('/',$DocPemb->url,4);
            
            $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[3];
            
            unlink($upload_dir);
        }

    }

    /**
     * Deletes an existing PembelianT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $pembelian Pembelian
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($pembelian)
    {
        $this->findModel($pembelian)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PembelianT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $pembelian Pembelian
     * @return PembelianT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($pembelian)
    {
        if (($model = PembelianT::findOne($pembelian)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
    
    // Print $pembelian output
    public function actionPrint($pembelian) {
        
        $model = PembelianT::findOne($pembelian);
        $check = PembelianBahanT::find()->where(['pembelian' => $pembelian])->count();
        
        if($check > 0){
            $this->layout = 'headerPrint';
            $model = PembelianT::findOne($pembelian);
            $nama = VariableT::find()->where('nama="Nama"')->all();
            $alamat = VariableT::find()->where('nama="Alamat"')->all();
            $telp = VariableT::find()->where('nama="Telp"')->all();
            $Supplier = SupplierT::find()->where(['supplier' => $model->supplier])->all();
            $PenjualanProduk = PembelianBahanT::find()->where(['pembelian' => $pembelian]);
    
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                'format' => Pdf::FORMAT_A4,
                'destination' => Pdf::DEST_BROWSER,
                'filename' => $model->faktur,
                'content' => $this->renderPartial('print', [
                    'model' => $model,
                    'PenjualanProduk' => $PenjualanProduk,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'telp' => $telp,
                    'Supplier' => $Supplier,
                ]),
                'cssFile' => '../web/css/kv-mpdf-bootstrap.min.css',
                'cssInline' => '<link media="print" rel="stylesheet" href="../web/css/app.css">
                #viewerContainer{fontsize:11px!important;}',
                'options' => [
                    // any mpdf options you wish to set
                    //'title' => 'No.PO: ' . $model->faktur,
                ],
                'methods' => [
                    'SetTitle' => 'No.PO: ' . $model->faktur,
                    /* 'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy', */
                    /* 'SetHeader' => ['Dicetak dan di approve oleh: ' . Yii::$app->user->identity->nama . '||Tgl.cetak: ' . date("r")], */
                    /* 'SetFooter' => ['|Page {PAGENO}|'], */
                    'SetAuthor' => Yii::$app->user->identity->nama . 'PGRPN',
                    'SetCreator' => 'PGRPN',
                    'SetKeywords' => 'PGRPN, Export, PDF, MPDF, Output, Manifest',
                ]
            ]);
            return $pdf->render();
        }else{
            $this->layout = 'kosong';
            return $this->redirect(['update', 
                'pembelian' => $pembelian
            ]);

        }
    }
}
