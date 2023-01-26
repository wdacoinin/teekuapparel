<?php

namespace app\controllers;

use yii;
use app\models\Akun;
use app\models\AkunLogT;
use app\models\AkunLog;
use app\models\Pembelian;
use app\models\PembelianBahan;
use app\models\DocPembT;
use app\models\DocPemb;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\BaseUrl;
use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * AkunLogController implements the CRUD actions for AkunLogT model.
 */
class AkunLogPembelianController extends Controller
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
     * Lists all AkunLogT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AkunLog();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AkunLogT model.
     * @param int $akun_log Akun Log
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($akun_log)
    {
        return $this->render('view', [
            'model' => $this->findModel($akun_log),
        ]);
    }

    /**
     * Creates a new AkunLogT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($pembelian)
    {
        $this->layout = 'kosong';
        //tabel akun_log
        $model = new AkunLogT();
        $model->idref = $pembelian;
        //tabel akun
        $modAkun = ArrayHelper::map(Akun::find()->select(['akun', 'CONCAT(akun_nama, "-", akun_ref, " an:", an) AS akun_ref'])->orderBy('akun_nama')->asArray()->all(), 'akun', 'akun_ref');
        //tabel pembelian
        $modPembelian = Pembelian::findOne(['pembelian' => $pembelian]);
        $modInorout = ['Cicil' => 'Cicil', 'Pembelian' => 'Pembelian'];
        //tabel doc_pemb for upload
        $modDocPemb = new DocPembT();
        $UpForm = new UploadForm();

        $kurang = 0;
        $total_pembelian = 0;
        $total_bayar = 0;
        //
        $model->jml = $kurang;
        //get pembelian
        if (PembelianBahan::findOne(['pembelian' => $pembelian]) !== null){

            //total pembelian
            $modPembelianBahan = (new \yii\db\Query())
            ->select('SUM(pembelian_jml*pembelian_harga) AS total')
            ->from('pembelian_bahan')
            ->where(['pembelian' => $pembelian])
            ->groupBy('pembelian')->one();
            $total_pembelian = $modPembelianBahan['total'];

            if (AkunLog::findOne(['idref' => $pembelian, 'inorout' => ['Cicil', 'Pembelian']]) !== null){
            //total terbayar
            $modBayar = (new \yii\db\Query())
            ->select('SUM(jml) AS total')
            ->from('akun_log')
            ->where(['idref' => $pembelian, 'inorout' => ['Cicil', 'Pembelian']])
            ->groupBy('idref')->one();
            $total_bayar = $modBayar['total'];
            }

            $kurang = ($total_pembelian - $modPembelian->pembelian_diskon) - $total_bayar;
            $model->jml = $kurang;

        }

        //validation
        if ($model->load(Yii::$app->request->post()) && $UpForm->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            //========================================================================//
            //===========================IMAGE HANDLE=================================//
            $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

            if ($UpForm->file && $UpForm->validate()) {  
            //$bytes = random_bytes(3);
            $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
            $upload_dir = Yii::getAlias('@webroot') . '/upload/doc_pemb/';

            if (!file_exists($upload_dir)) //Buat folder bername temp
            //mkdir($upload_dir);
            FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

            //image
            $img = $UpForm->file;
            //get filesize
            $file_size = $UpForm->file->size;
            //set build directory
            $url_database = Yii::$app->request->baseUrl . '/upload/doc_pemb/' . $modPembelian->faktur . "-" . $ran . '.' . $UpForm->file->extension;
            $nama_foto = $modPembelian->faktur . "-" . $ran . '.' . $UpForm->file->extension;

            //save to directori 'upload/doc_pemb/'
            $UpForm->file->saveAs($upload_dir . $nama_foto);
            //set it to model
            $modDocPemb->pembelian = $pembelian;
            $modDocPemb->Nama_Foto = $nama_foto;
            $modDocPemb->type = $UpForm->file->extension;
            $modDocPemb->size = $file_size;
            $modDocPemb->url = $url_database;
            }
            //========================================================================//
            //===========================IMAGE HANDLE=================================//



            if($kurang < $model->jml){
                Yii::$app->session->setFlash('danger', 'Bayar Lebih besar dari kekurangan total pembelian!');
            }else{
                if($modDocPemb->save()) {
                    $lastID = Yii::$app->db->getLastInsertID();
                    $model->id_img = $lastID;

                    if($model->save()) {

                        //check set lunas atau belum
                        if (AkunLog::findOne(['idref' => $pembelian, 'inorout' => ['Cicil', 'Pembelian']]) !== null){
                        //total terbayar
                        $modBayar = (new \yii\db\Query())
                        ->select('SUM(jml) AS total')
                        ->from('akun_log')
                        ->where(['idref' => $pembelian, 'inorout' => ['Cicil', 'Pembelian']])
                        ->groupBy('idref')->one();
                        $total_bayar = $modBayar['total'];
                        }

                        $kurang = ($total_pembelian - $modPembelian->pembelian_diskon) - $total_bayar;
                        $model->jml = $kurang;

                        if($kurang > 0){
                            $modPembelian->pembelian_status = 'Piutang';
                        }else{
                            $modPembelian->pembelian_status = 'Lunas';
                        }
                        $modPembelian->akun = $model->akun;

                        $modPembelian->save();
                        Yii::$app->session->setFlash('success', 'Pembayaran berhasil disimpan!');
                    }
                    
                }
                else {
                    Yii::$app->session->setFlash('danger', 'Data tidak berhasil di input');
                }
            }

            
            return $this->redirect(['pembelian/update', 'pembelian' => $pembelian]);
        } else {
            
            return $this->renderAjax('create', [
                'model' => $model,
                'modInorout' => $modInorout,
                'modAkun' => $modAkun,
                'UpForm' => $UpForm,
            ]);
        }

    }

    /**
     * Updates an existing AkunLogT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $akun_log Akun Log
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($akun_log)
    {
        $model = $this->findModel($akun_log);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'akun_log' => $model->akun_log]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AkunLogT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $akun_log Akun Log
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($akun_log)
    {
        $this->findModel($akun_log)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AkunLogT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $akun_log Akun Log
     * @return AkunLogT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($akun_log)
    {
        if (($model = AkunLogT::findOne($akun_log)) !== null) {
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
