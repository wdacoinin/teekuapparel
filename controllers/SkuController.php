<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\SkuT;
use app\models\Sku;
use app\models\Skuorders;
use app\models\Skuordersadm;
use app\models\Skus;
use app\models\Skuv;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * SkuController implements the CRUD actions for SkuT model.
 */
class SkuController extends Controller
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
     * Lists all SkuT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Sku();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all SkuT models.
     * @return mixed
     */
    public function actionUserview()
    {
        $this->layout = 'kosong';
        $user = Yii::$app->user->identity->id;
        $searchModel = new Skus();
        $dataProvider = $searchModel->search($this->request->queryParams, $user);

        return $this->render('userview', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all SkuT models.
     * @return mixed
     */
    public function actionSkuordersadm()
    {
        $this->layout = 'kosong';
        $user = Yii::$app->user->identity->id;
        $searchModel = new Skuordersadm();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('skuorders', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all SkuT models.
     * @return mixed
     */
    public function actionSkuorders()
    {
        $this->layout = 'kosong';
        $user = Yii::$app->user->identity->id;
        $searchModel = new Skuorders();
        $dataProvider = $searchModel->search($this->request->queryParams, $user);

        return $this->render('skuorders', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SkuT model.
     * @param int $sku Sku
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($sku)
    {
        return $this->render('view', [
            'model' => $this->findModel($sku),
        ]);
    }

    /**
     * Creates a new SkuT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new SkuT();
        $model->sku_date_dreate = date('Y-m-d');
        $UpForm = new UploadForm();
        /* $checkmax = SkuT::find()->count();
        $ran = substr(str_shuffle('ABCDEFGHJKMNPQRSTUVWXYZ'),0,3);
        $sku = 'SKU-' . $ran . sprintf("%04s", $checkmax + 1);
        $model->sku_kode = $sku; */
        

        //validation
        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->load($this->request->post())) {
                $chec = SkuT::find()->where(['sku_kode' => $model->sku_kode])->count();
                if((int) $chec > 0){
                    Yii::$app->session->setFlash('SKU Kode sudah ada');
                }else{
                        
                    if ($UpForm->load($this->request->post())) {
                                
                        //========================================================================//
                        //===========================IMAGE HANDLE=================================//
                        $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

                        if ($UpForm->file && $UpForm->validate()) {  
                        //$bytes = random_bytes(3);
                        $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                        $upload_dir = Yii::getAlias('@webroot') . '/uploads/sku/' . $model->sku_kode . '/';

                        if (!file_exists($upload_dir)) //Buat folder
                        //mkdir($upload_dir);
                        FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                        //image
                        $img = $UpForm->file;
                        //get filesize
                        $file_size = $UpForm->file->size;
                        //set build directory
                        $url_database = Yii::$app->request->baseUrl . '/uploads/sku/' . $model->sku_kode . '/' . $UpForm->file->name . '.' . $UpForm->file->extension;
                        $nama_foto = $UpForm->file->name . '.' . $UpForm->file->extension;

                        //save to directori 'uploads/doc_penj/'
                        $UpForm->file->saveAs($upload_dir . $nama_foto);
                        //set it to model
                        $model->nama_foto = $UpForm->file->name;
                        $model->type = $UpForm->file->extension;
                        $model->size = $file_size;
                        $model->url = $url_database;
                        }
                        //var_dump($DocPemb->attributes);die;
                        //========================================================================//
                        //===========================IMAGE HANDLE=================================//
                    }
                    $model->save();
                }
            }

            return $this->redirect(['index']);

        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'UpForm' => $UpForm,
        ]);
    }

    /**
     * Updates an existing SkuT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $sku Sku
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($sku)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($sku);
        $UpForm = new UploadForm();

        //validation
        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->load($this->request->post())) {
                    
                if ($UpForm->load($this->request->post())) {
                            
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
                    $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

                    if ($UpForm->file && $UpForm->validate()) {  
                    //$bytes = random_bytes(3);
                    $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                    $upload_dir = Yii::getAlias('@webroot') . '/uploads/sku/' . $model->sku_kode . '/';

                    if (!file_exists($upload_dir)) //Buat folder
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    //set build directory
                    $url_database = Yii::$app->request->baseUrl . '/uploads/sku/' . $model->sku_kode . '/' . $UpForm->file->name . '.' . $UpForm->file->extension;
                    $nama_foto = $UpForm->file->name . '.' . $UpForm->file->extension;

                    //save to directori 'uploads/doc_penj/'
                    $UpForm->file->saveAs($upload_dir . $nama_foto);
                    //set it to model
                    $model->nama_foto = $UpForm->file->name;
                    $model->type = $UpForm->file->extension;
                    $model->size = $file_size;
                    $model->url = $url_database;
                    }
                    //var_dump($DocPemb->attributes);die;
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
                }
                $model->save();
            }

            return $this->redirect(['index']);

        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'UpForm' => $UpForm,
        ]);
    }

    /**
     * Deletes an existing SkuT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $sku Sku
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($sku)
    {
        $this->findModel($sku)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SkuT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $sku Sku
     * @return SkuT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($sku)
    {
        if (($model = SkuT::findOne($sku)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
