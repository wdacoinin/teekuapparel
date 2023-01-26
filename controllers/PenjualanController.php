<?php

namespace app\controllers;

use Yii;
use app\models\AkunLogT;
use app\models\BackendUser;
use app\models\PenjualanT;
use app\models\Penjualan;
use app\models\VariableT;
use app\models\PenjualanSrc;
use app\models\PenjualanProdukT;
use app\models\PenjualanProdukStep;
use app\models\PembayaranPenjualanID;
use app\models\DocPenjualanProdukT;
use app\models\DocPenjT;
use app\models\DocPenjualanProduk;
use app\models\KonsumenT;
use app\models\PenjualanProduk;
use app\models\PenjualanProdukDetailv;
use app\models\PenjualanStepT;
use app\models\ProdukDetailT;
use app\models\RevT;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\UploadedFile;
use app\models\UploadForm;
use Exception;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use ZipArchive;

/**
 * PenjualanController implements the CRUD actions for PenjualanT model.
 */
class PenjualanController extends Controller
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
     * Lists all PenjualanT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Penjualan();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PenjualanT model.
     * @param int $penjualan Penjualan
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($penjualan)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($penjualan),
        ]);
    }

    /**
     * Creates a new PenjualanT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new PenjualanT();
        $model->penjualan_status = 'Piutang';
        $model->penjualan_ongkir = 0;
        $model->fee = 0;
        $model->penjualan_diskon = 0;

        /* $year = date('Y');
        $checkmax = PenjualanT::find()->where(["DATE_FORMAT(penjualan_tgl,'%Y')" => $year])
        ->count();
        $faktur = 'P' . date('ymd') . sprintf("%04s", $checkmax + 1);

        $model->faktur = $faktur; */

        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->load($this->request->post())) {
                $checklist = Penjualan::findOne(['faktur' => $model->faktur]);
                if($checklist !== null){
                    Yii::$app->session->setFlash('No.Faktur Sudah dipakai');
                    return $this->redirect(['index']);
                }else{

                    $modKonsumen = new KonsumenT();
                    $modKonsumen->konsumen_nama = $model->konsumen_nama;
                    $modKonsumen->alamat = $model->alamat;
                    $modKonsumen->limits = 0;

                    if($model->konsumen == ''){
                        if($modKonsumen->save()){
                            $model->konsumen = (int) $modKonsumen->konsumen;
                            $model->save();
                            return $this->redirect(['update', 'penjualan' => $model->penjualan]);
                        }else{
                            Yii::$app->session->setFlash('warning', 'Gagal simpan Konsumen');
                            return $this->redirect(['index']);
                        }
                    }else{
                        $model->save();
                        return $this->redirect(['update', 'penjualan' => $model->penjualan]);
                    }

                    //$model->followup_team = json_encode($model->followup_team);
                    //Yii::$app->session->setFlash('success', 'Traking Updated!');
                }

            }
            //return $this->redirect(Url::to(['tracking-order/index']));
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PenjualanT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $penjualan Penjualan
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($penjualan)
    {
        $this->layout = 'kosong';

        $searchModel = new PembayaranPenjualanID();
        $dataProvider = $searchModel->search($this->request->queryParams, $penjualan);

        $model = $this->findModel($penjualan);
        $modPenjualanProduk = new PenjualanProduk();
        $modPenjualanProduk->penjualan = $penjualan;
        $PenjualanProduk = PenjualanProdukT::find()->where(['penjualan' => $penjualan]);
        $DocPenjualanProduk = new DocPenjualanProdukT();
        $DocPenjualanProdukD = new DocPenjualanProdukT();
        
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->followup_team = json_encode($model->followup_team);
            $model->save();

            return $this->redirect(['update', 
                'penjualan' => $penjualan
            ]);
        }

        return $this->render('update', [
            'model' => $model,
            'modPenjualanProduk' => $modPenjualanProduk,
            'PenjualanProduk' => $PenjualanProduk,
            'DocPenjualanProduk' => $DocPenjualanProduk,
            'DocPenjualanProdukD' => $DocPenjualanProdukD,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing PenjualanT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $penjualan_produk penjualan_produk
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDisplayFile($penjualan)
    {
        $this->layout = 'kosong';
        $Penjualan = PenjualanT::findOne($penjualan);
        $PenjualanProduk = PenjualanProdukT::find()->where(['penjualan' => $Penjualan->penjualan]);
        $DocPenjualanProduk = new DocPenjualanProdukT();

        return $this->renderAjax('_displayFile', [
            'DocPenjualanProduk' => $DocPenjualanProduk,
            'PenjualanProduk' => $PenjualanProduk
        ]);
    }

    /**
     * Updates an existing PenjualanT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $penjualan_produk penjualan_produk
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpload($penjualan)
    {
        $this->layout = 'kosong';
        $Penjualan = PenjualanT::findOne($penjualan);
        $DocPenjualanProduk =new DocPenjualanProdukT();
        $UpForm = new UploadForm();

        //validation
        if ($DocPenjualanProduk->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($DocPenjualanProduk);
            }

            if ($UpForm->load($this->request->post())) {
                    
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
                    $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

                    if ($UpForm->file && $UpForm->validate()) {  
                    //$bytes = random_bytes(3);
                    $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                    $upload_dir = Yii::getAlias('@webroot') . '/upload/doc_penj/' . $Penjualan->faktur . '/';

                    if (!file_exists($upload_dir)) //Buat folder
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    //set build directory
                    $url_database = Yii::$app->request->baseUrl . '/upload/doc_penj/' . $Penjualan->faktur . '/' . $UpForm->file->name. $ran . '.' . $UpForm->file->extension;
                    $nama_foto = $UpForm->file->name. $ran . '.' . $UpForm->file->extension;

                    //save to directori 'upload/doc_penj/'
                    $UpForm->file->saveAs($upload_dir . $nama_foto);
                    //set it to model
                    //$DocPenjualanProduk->penjualan_produk = $PenjualanProduk->penjualan_produk;
                    $DocPenjualanProduk->Nama_Foto = $nama_foto;
                    $DocPenjualanProduk->type = $UpForm->file->extension;
                    $DocPenjualanProduk->size = $file_size;
                    $DocPenjualanProduk->url = $url_database;
                    }
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//

                    $DocPenjualanProduk->penjualan = $penjualan;
                    $DocPenjualanProduk->user = Yii::$app->user->identity->id;
                    if($DocPenjualanProduk->save()) {
                        /* if(Yii::$app->user->identity->divisi == 2 && Yii::$app->user->identity->divisi == 5){
                            $Penjualan->desainer = Yii::$app->user->identity->id;
                            $Penjualan->save();
                        } */
                        Yii::$app->session->setFlash('success', 'File berhasil disimpan!');
                    } else {
                        Yii::$app->session->setFlash('danger', 'File tidak berhasil di input');
                    }
            }
            //return $this->redirect(Url::to(['tracking-order/index']));
            return $this->redirect(['update', 'penjualan' => $Penjualan->penjualan]);
        } else {
            return $this->renderAjax('upload', [
                'Penjualan' => $Penjualan,
                'DocPenjualanProduk' => $DocPenjualanProduk,
                'UpForm' => $UpForm,
            ]);
        }
    }

    public function actionUploaddesain($penjualan)
    {
        $this->layout = 'kosong';
        $Penjualan = PenjualanT::findOne($penjualan);
        $DocPenjualanProduk =new DocPenjualanProdukT();
        $UpForm = new UploadForm();

        //validation
        if ($DocPenjualanProduk->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($DocPenjualanProduk);
            }

            if ($UpForm->load($this->request->post())) {
                    
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
                    $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

                    if ($UpForm->file && $UpForm->validate()) {  
                    //$bytes = random_bytes(3);
                    $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                    $upload_dir = Yii::getAlias('@webroot') . '/upload/doc_penj/' . $Penjualan->faktur . '/';

                    if (!file_exists($upload_dir)) //Buat folder
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    //set build directory
                    $url_database = Yii::$app->request->baseUrl . '/upload/doc_penj/' . $Penjualan->faktur . '/' . $UpForm->file->name . $ran . '.' . $UpForm->file->extension;
                    $nama_foto = $UpForm->file->name . $ran . '.' . $UpForm->file->extension;

                    //save to directori 'upload/doc_penj/'
                    $UpForm->file->saveAs($upload_dir . $nama_foto);
                    //set it to model
                    //$DocPenjualanProduk->penjualan_produk = $PenjualanProduk->penjualan_produk;
                    $DocPenjualanProduk->Nama_Foto = $nama_foto;
                    $DocPenjualanProduk->type = $UpForm->file->extension;
                    $DocPenjualanProduk->size = $file_size;
                    $DocPenjualanProduk->url = $url_database;
                    }
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//


                    $cekStep = PenjualanStepT::find()->where(['penjualan' => $penjualan, 'divisi' => 5])->asArray()->count();
                    //var_dump($cekStep);die;
                    $DocPenjualanProduk->penjualan = $penjualan;
                    $DocPenjualanProduk->user = Yii::$app->user->identity->id;
                    if($DocPenjualanProduk->save()) {
                        if(Yii::$app->user->identity->divisi == 2 || Yii::$app->user->identity->divisi == 5){
                            $Penjualan->desainer = Yii::$app->user->identity->id;
                            $Penjualan->save();

                            if((int) $cekStep == 0){
                                $modStep = new PenjualanStepT();
                                $modStep->penjualan = $penjualan;
                                $modPP = PenjualanProdukT::find()->select('SUM(penjualan_jml) AS total')->where(['penjualan' => $penjualan])->asArray()->one();
                                if($modPP != null){
                                    $qty = $modPP['total'];
                                }else{
                                    $qty = 1;
                                }
                                $modStep->jml = $qty;
                                $modStep->divisi = 5;
                                $modStep->start = date('Y-m-d H:i:s');
                                $modStep->user = Yii::$app->user->identity->id;
                                //var_dump($modStep->validate());die;
                                $modStep->save();
                            }
                            
                        }
                        Yii::$app->session->setFlash('success', 'File berhasil disimpan!');
                    } else {
                        Yii::$app->session->setFlash('danger', 'File tidak berhasil di input');
                    }
            }
            //return $this->redirect(Url::to(['tracking-order/index']));
            return $this->redirect(['update', 'penjualan' => $Penjualan->penjualan]);
        } else {
            return $this->renderAjax('upload', [
                'Penjualan' => $Penjualan,
                'DocPenjualanProduk' => $DocPenjualanProduk,
                'UpForm' => $UpForm,
            ]);
        }
    }


    /**
     * Tabel Penjualan Produk.
     * @return mixed
     */
    public function actionProduk($penjualan)
    {
        /* $penjualanProduks = PenjualanProduk::find()->where(['penjualan' => $penjualan])->asArray()->all(); */
        $row = PenjualanProduk::find()->where(['penjualan' => $penjualan])->count();

        /* $rows = (new \yii\db\Query())
        ->select([
            'penjualan_produk.penjualan_produk', 
            'produk.nama', 
            'penjualan_produk.penjualan_jml', 
            'penjualan_produk.penjualan_harga'
            ])
        ->from('penjualan_produk')
        ->join('LEFT JOIN', 'produk', 'produk.produk = penjualan_produk.produk')
        ->where(['penjualan' => $penjualan])
        ->all(); */
        //$model->penjualan_harga = $model->penjualan_harga;
        $rows = PenjualanProdukDetailv::find()->where(['penjualan' => $penjualan])->asArray()->all();
        $modP = PenjualanT::findOne($penjualan);

        $data=[];
        $no = 0;
        foreach ($rows as $i => $row) {
            $no++;
            if($modP->acc_desain == 0){
                $edit = '<button class="btn btn-danger" id="hapusprod" value="" onClick="hapus(\''.Url::to(['hapusproduk', 'penjualan_produk' => $row['penjualan_produk']]).'\')"><i class="fas fa-trash"></i></button> 
                <button class="btn btn-primary" value="" onClick="edit(\''.Url::to(['penjualan-produk/update', 'penjualan_produk' => $row['penjualan_produk']]).'\')"><i class="fas fa-edit"></i></button>';
            }else{
                $edit = null;
            }
            $data[$i] = array(
                'opt' => $edit,
                'penjualan_produk' => $row['penjualan_produk'],
                'url' => '<img src="'.$row['url'].'" width="100" />',
                'sku_kode' => $row['sku_kode'],
                'nama' => $row['nama'],
                'item' => $row['item'],
                'nick' => nl2br($row['nick']),
                'penjualan_jml' => $row['penjualan_jml'],
                //'penjualan_harga' => number_format($row['penjualan_harga'],0,",","."),
                //'penjualan_harga' => $row['penjualan_harga'],
                'subtotal' => $row['total_detail']+$row['subtotal'],
                //'create_time' => $format->formatDateTimeForuser(explode(' ', $row['create_time'])[0]),
            );
        }
        
                    
        $data = array(
            'rows' => $data,
            'total' => $row,
        );

        return json_encode($data);
    }

    public function actionAddmore($penjualan_produk, $penjualan)
    {
        $this->layout = 'kosong';
        //last size
        $modelsize = ProdukDetailT::find()->select('produk_detail.produk_item')
        ->join("LEFT JOIN", "produk_item", "produk_item.produk_item = produk_detail.produk_item")
        ->where(['penjualan_produk' => $penjualan_produk, 'produk_item.produk_item_kat' => 1])
        ->orderBy('penjualan_produk ASC')->limit(1)->asArray()->one();
        //last neck
        $modelneck = ProdukDetailT::find()->select('produk_detail.produk_item')
        ->join("LEFT JOIN", "produk_item", "produk_item.produk_item = produk_detail.produk_item")
        ->where(['penjualan_produk' => $penjualan_produk, 'produk_item.produk_item_kat' => 2])
        ->orderBy('penjualan_produk ASC')->limit(1)->asArray()->one();
        //last lengan
        $modellengan = ProdukDetailT::find()->select('produk_detail.produk_item')
        ->join("LEFT JOIN", "produk_item", "produk_item.produk_item = produk_detail.produk_item")
        ->where(['penjualan_produk' => $penjualan_produk, 'produk_item.produk_item_kat' => 3])
        ->orderBy('penjualan_produk ASC')->limit(1)->asArray()->one();
        //last vareasi
        $modelvareasi = ProdukDetailT::find()->select('produk_detail.produk_item')
        ->join("LEFT JOIN", "produk_item", "produk_item.produk_item = produk_detail.produk_item")
        ->where(['penjualan_produk' => $penjualan_produk, 'produk_item.produk_item_kat' => 4])
        ->orderBy('penjualan_produk ASC')->limit(1)->asArray()->one();

        $model = new ProdukDetailT();
        if($modelsize != null){
            $model->size = $modelsize['produk_item'];
        }
        if($modelneck != null){
            $model->neck = $modelneck['produk_item'];
        }
        if($modellengan != null){
            $model->lengan = $modellengan['produk_item'];
        }
        if($modelvareasi != null){
            $model->lengan = $modelvareasi['produk_item'];
        }

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            


                if ($model->load($this->request->post())) {

                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        $modelPP = PenjualanProdukT::findOne($penjualan_produk);
                        $modAmore = new PenjualanProdukT();
                        $modAmore->penjualan = (int) $penjualan;
                        $modAmore->produk = (int) $modelPP->produk;
                        $modAmore->penjualan_hpp = (int) $modelPP->penjualan_hpp;
                        $modAmore->penjualan_harga = (int) $modelPP->penjualan_harga;
                        $modAmore->sku = (int) $modelPP->sku;
                        $modAmore->penjualan_jml = (int) $model->qty;
                        $modAmore->nick = $model->nick;

                        if($modAmore->save()){
                            //var_dump($model);die;
                            if($model->size != ''){
                                
                                $models = new ProdukDetailT();
                                $models->penjualan_produk = (int) $modAmore->penjualan_produk;
                                $models->produk_item = (int) $model->size;
                                $models->save();
                            }

                            if($model->neck != ''){
                                $modeln = new ProdukDetailT();
                                $modeln->penjualan_produk = (int) $modAmore->penjualan_produk;
                                $modeln->produk_item = (int) $model->neck;
                                $modeln->save();
                            }

                            if($model->lengan != ''){
                                $modell = new ProdukDetailT();
                                $modell->penjualan_produk = (int) $modAmore->penjualan_produk;
                                $modell->produk_item = (int) $model->lengan;
                                $modell->save();
                            }

                            if($model->vareasi != ''){
                                $modelv = new ProdukDetailT();
                                $modelv->penjualan_produk = (int) $modAmore->penjualan_produk;
                                $modelv->produk_item = (int) $model->vareasi;
                                $modelv->save();
                            }
                            
                            $transaction->commit();
                        }else{
                            Yii::$app->session->setFlash('warning', 'Gagal simpan');
                            $transaction->rollback();
                        }
                    } catch (Exception $ex) {
                        Yii::$app->session->setFlash('warning', 'Error gagal simpan '.$ex);
                        $transaction->rollback();
                    }

                    return $this->redirect(['update', 'penjualan' => $penjualan]);
                }
            //return $this->redirect(Url::to(['tracking-order/index']));
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('addmore', [
            'model' => $model,
        ]);

    }

    /** $penjualan_produk
     * @return mixed 
     */
    public function actionHapusproduk($penjualan_produk)
    {
        
        $modPenjualanProdukT = PenjualanProdukT::findOne($penjualan_produk);
        
        //$row = DocPenjualanProduk::find()->where(['penjualan_produk' => $penjualan_produk])->count();
        $step = PenjualanProdukStep::find()->where(['penjualan_produk' => $penjualan_produk])->count();
        //echo var_dump($upload_dir);

        /* if($row > 0 || $step){
            $data = array(
                'hasil' => 'adafile'
            );
            
            return json_encode($data); */

        if($step > 0){

                $data = array(
                    'hasil' => 'step'
                );
                
                return json_encode($data);
        }else{
            if($modPenjualanProdukT->delete()){

                //return $this->redirect(['update', 'penjualan' => $penjualan]);
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

    }

    /** $id_img, $penjualan
     * @return mixed 
     */
    public function actionDeletefile()
    {
        $file_key = (int)\Yii::$app->request->post('key');

        echo json_encode($file_key);
        
        $DocPenjualanProduk = DocPenjualanProdukT::findOne($file_key);

        $exp = explode('/',$DocPenjualanProduk->url,3);
        
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[2];
            
        if(unlink($upload_dir)){
            $DocPenjualanProduk->delete();
        }

    }

    /** $id_img, $penjualan
     * @return mixed 
     */
    public function actionDeletefiledesain()
    {
        $file_key = (int)\Yii::$app->request->post('key');

        echo json_encode($file_key);
        
        $DocPenjualanProduk = DocPenjualanProdukT::findOne($file_key);

        $exp = explode('/',$DocPenjualanProduk->url,3);
        
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[2];
            
        if(unlink($upload_dir)){
            $DocPenjualanProduk->delete();
        }

    }


    /** $akun_log $penjualan
     * @return mixed 
     */
    public function actionDeletebayar($akun_log, $penjualan, $id_img)
    {
        
        $AkunLogT = AkunLogT::findOne($akun_log);
        //echo var_dump($upload_dir);

        if($AkunLogT->delete()){
            $this->actionDeletenota($id_img);
            return $this->redirect(['update', 'penjualan' => $penjualan]);
        }

    }

    /** $id_img, $penjualan
     * @return mixed 
     */
    public function actionDeletenota($id_img)
    {
        
        //$id_img = (int)\Yii::$app->request->post('key');

        //echo json_encode($id_img);
        
        $DocPenjualan = DocPenjT::findOne($id_img);
        //echo var_dump($upload_dir);

        if($DocPenjualan->delete()){

            $exp = explode('/',$DocPenjualan->url,3);
            
            $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[2];
            
            unlink($upload_dir);
        }

    }

    /**
     * Deletes an existing PenjualanT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $penjualan Penjualan
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($penjualan)
    {
        //$this->findModel($penjualan)->delete();

        $model = PenjualanT::findOne($penjualan);
        $model->penjualan_status = 'Batal Order';
        if($model->save()){
            Yii::$app->session->setFlash('success', 'Order dibatalkan.');
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('warning', 'Batal order gagal!');
            return $this->redirect(['index']);

        }
    }

    public function actionDownload($penjualan)
    {
        $zip = new ZipArchive();
        //$zip_name = "../../uploads/file_design/".$_POST['order_number']."/".$_POST['order_number'].".zip"; // Zip name
        $model = PenjualanT::findOne($penjualan);
        $fd = Yii::getAlias('@webroot') . '/upload/file_design/';

        if (!file_exists($fd)) //Buat folder
        //mkdir($upload_dir);
        FileHelper::createDirectory($fd, $mode = 0775, $recursive = true);

        $zip_name = Yii::getAlias('@webroot') . '/upload/file_design/' . $model->faktur . '.zip';
        $link_dl = Yii::$app->request->baseUrl . '/upload/file_design/' . $model->faktur . '.zip';
        if(file_exists($zip_name)){
            unlink($zip_name);
        }
        $zip->open($zip_name,  ZipArchive::CREATE);
        $img = DocPenjualanProdukT::find()->where(['penjualan' => $penjualan])->asArray()->all();
            //$files = array();
            foreach($img as $row){
            

                $exp = explode('/',$row['url'],3);
            
                $path = Yii::getAlias('@webroot') . '/' . $exp[2];

                //$path = $row['url'];
                if(file_exists($path)){
                $zip->addFromString(basename($path),  file_get_contents($path));  
                }
            }
        /* $urls = '/tekkuapparel/web/upload/file_design/' . $model->faktur . '.zip';
        
        $exps = explode('/',$urls,4);
            
        $url = Yii::getAlias('@webroot') . '/' . $exps[3]; */
        $zip_name = Yii::getAlias('@webroot') . '/upload/file_design/' . $model->faktur . '.zip';
        //readfile($zip_name);
        $json['linkdl'] = $link_dl;
        echo json_encode($json);
        $zip->close();
    }

    public function actionAcc($penjualan)
    {
        $model = PenjualanT::findOne($penjualan);
        $model->acc_desain = 1;
        $model->acc_date = date('Y-m-d');

        if($model->save()){
            $data = array(
                'hasil' => 'success'
            );
        }else{
            $data = array(
                'hasil' => 'gagal'
            );
        }
        echo json_encode($data);
    }

    public function actionRev($penjualan)
    {
        $model = new RevT();
        $model->penjualan = $penjualan;
        $model->user = Yii::$app->user->identity->id;
        $model->note = $_POST['textrev'];

        if($model->save()){
            $data = array(
                'hasil' => 'success'
            );
        }else{
            $data = array(
                'hasil' => 'gagal'
            );
        }
        echo json_encode($data);
    }

    public function actionRevdone($penjualan)
    {
        $rev = $_POST['rev'];
        $model = RevT::findOne($rev);
        $model->rev_st = 1;

        if($model->save()){
            $data = array(
                'hasil' => 'success'
            );
        }else{
            $data = array(
                'hasil' => 'gagal'
            );
        }
        echo json_encode($data);
    }

    /**
     * Finds the PenjualanT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $penjualan Penjualan
     * @return PenjualanT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($penjualan)
    {
        if (($model = PenjualanT::findOne($penjualan)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    // Manifest $penjualan output
    public function actionManifest($penjualan) {

        $this->layout = 'headerPrint';
        
        $model = PenjualanT::findOne($penjualan);
        $PenjualanProduk = PenjualanProdukT::find()->where(['penjualan' => $penjualan]);
        /* return $this->render('manifest', [
            'model' => $model,
            'PenjualanProduk' => $PenjualanProduk,
        ]); */

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'format' => Pdf::FORMAT_A4,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => $model->faktur,
            'content' => $this->renderPartial('manifest', [
                'model' => $model,
                'PenjualanProduk' => $PenjualanProduk,
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
                'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                /* 'SetHeader' => ['Dicetak dan di approve oleh: ' . Yii::$app->user->identity->nama . '||Tgl.cetak: ' . date("r")], */
                'SetFooter' => ['|Page {PAGENO}|'],
                'SetAuthor' => Yii::$app->user->identity->nama . 'PGRPN',
                'SetCreator' => 'PGRPN',
                'SetKeywords' => 'PGRPN, Export, PDF, MPDF, Output, Manifest',
            ]
        ]);
        return $pdf->render();
    }
    
    // Print $penjualan output
    public function actionPrint($penjualan) {
        
        $model = PenjualanT::findOne($penjualan);
        $check = PenjualanProdukT::find()->where(['penjualan' => $penjualan])->count();
        
        if($check > 0){
            $model->hprint = (int) $model->hprint + 1;
            $model->save();

            $this->layout = 'headerPrint';
            $model = PenjualanT::findOne($penjualan);
            $nama = VariableT::find()->where('nama="Nama"')->all();
            $alamat = VariableT::find()->where('nama="Alamat"')->all();
            $telp = VariableT::find()->where('nama="Telp"')->all();
            $Konsumen = KonsumenT::find()->where(['konsumen' => $model->konsumen])->all();
            $Sales = BackendUser::find()->where(['id' => $model->sales])->all();
            $PenjualanProduk = PenjualanProdukT::find()->where(['penjualan' => $penjualan]);
    
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
                    'Konsumen' => $Konsumen,
                    'Sales' => $Sales
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
                'penjualan' => $penjualan
            ]);

        }
    }

    /*public function beforeAction($action){

        if (Yii::$app->user->isGuest){
            return $this->redirect(['site/login'])->send();  // login path
        }
    }*/
}
