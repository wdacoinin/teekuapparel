<?php

namespace app\controllers;

use yii;
use app\models\BebanListT;
use app\models\BebanList;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\UploadedFile;
use app\models\UploadForm;
use yii\helpers\FileHelper;

/**
 * BebanListController implements the CRUD actions for BebanListT model.
 */
class BebanListController extends Controller
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
     * Lists all BebanListT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new BebanList();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BebanListT model.
     * @param int $beban_list Beban List
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($beban_list)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($beban_list),
        ]);
    }

    /**
     * Creates a new BebanListT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new BebanListT();
        $UpForm = new UploadForm();

        $searchModel = new BebanList();
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            //========================================================================//
            //===========================IMAGE HANDLE=================================//
            $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

            if ($UpForm->file && $UpForm->validate() && $model->load($this->request->post())) {  
            
                //$bytes = random_bytes(3);
                $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                $upload_dir = Yii::getAlias('@webroot') . '/upload/doc_kaskecil/';

                if (!file_exists($upload_dir)) //Buat folder bername temp
                //mkdir($upload_dir);
                FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                //image
                $img = $UpForm->file;
                //get filesize
                $file_size = $UpForm->file->size;
                //set build directory
                $url_database = Yii::$app->request->baseUrl . '/upload/doc_kaskecil/' . $UpForm->file->name . "-" . $ran . '.' . $UpForm->file->extension;
                $nama_foto = $UpForm->file->name . "-" . $ran . '.' . $UpForm->file->extension;

                //save to directori 'upload/doc_pemb/'
                $UpForm->file->saveAs($upload_dir . $nama_foto);
                //set it to model
                //$model->pembelian = $pembelian;
                $model->nama_foto = $nama_foto;
                $model->type = $UpForm->file->extension;
                $model->url = $url_database;
                $model->size = $file_size;

                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Beban pengeluaran kas kecil di input!');
                    return $this->redirect('index.php?r=beban-list/index');
                }else{
                    Yii::$app->session->setFlash('danger', 'Beban pengeluaran kas Gagal input!');
                    return $this->redirect('index.php?r=beban-list/index');
                }
                
                

            }else{
                Yii::$app->session->setFlash('warning', 'File bukti kosong!');
                return $this->redirect('index.php?r=beban-list/index');
            }
            //========================================================================//
            //===========================IMAGE HANDLE=================================//
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'UpForm' => $UpForm,
        ]);
    }

    /**
     * Updates an existing BebanListT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $beban_list Beban List
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($beban_list)
    {
        $this->layout = 'kosong';

        $searchModel = new BebanList();
        $dataProvider = $searchModel->search($this->request->queryParams);
        //$model = $this->findModel($beban_list);

        /* if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'beban_list' => $model->beban_list]);
        }

        return $this->render('update', [
            'model' => $model,
        ]); */
        //$model = new BebanListT();
        $model = $this->findModel($beban_list);
        $UpForm = new UploadForm();
        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            //========================================================================//
            //===========================IMAGE HANDLE=================================//
            $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

            if ($UpForm->file && $UpForm->validate() && $model->load($this->request->post())) {  
                //$bytes = random_bytes(3);
                $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                $upload_dir = Yii::getAlias('@webroot') . '/upload/doc_kaskecil/';

                if (!file_exists($upload_dir)) //Buat folder bername temp
                //mkdir($upload_dir);
                FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                //image
                $img = $UpForm->file;
                //get filesize
                //$file_size = $UpForm->file->size;
                //set build directory
                $url_database = Yii::$app->request->baseUrl . '/upload/doc_kaskecil/' . $model->beban_list . "-" . $ran . '.' . $UpForm->file->extension;
                $nama_foto = $model->beban_list . "-" . $ran . '.' . $UpForm->file->extension;

                //save to directori 'upload/doc_pemb/'
                $UpForm->file->saveAs($upload_dir . $nama_foto);
                //set it to model
                //$model->pembelian = $pembelian;
                $model->nama_foto = $nama_foto;
                $model->type = $UpForm->file->extension;
                $model->url = $url_database;
                $model->size = $UpForm->file->size;


                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Beban pengeluaran kas kecil di input!');
                    return $this->redirect('index.php?r=beban-list/index');
                }else{
                    Yii::$app->session->setFlash('danger', 'Beban pengeluaran kas Gagal input!' . $model->size);
                    return $this->redirect('index.php?r=beban-list/index');
                }
            }else{
                
                Yii::$app->session->setFlash('success', 'Beban pengeluaran kas kecil update!');
                $model->save();
                return $this->redirect('index.php?r=beban-list/index');
            }
            //========================================================================//
            //===========================IMAGE HANDLE=================================//
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'UpForm' => $UpForm,
            ]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'UpForm' => $UpForm,
        ]);
    }

    /** $id_img, $penjualan
     * @return mixed 
     */
    public function actionDeletefile()
    {
        
        $file_key = (int)\Yii::$app->request->post('key');

        echo json_encode($file_key);
        
        $bebanlist = BebanListT::findOne($file_key);

        $exp = explode('/',$bebanlist->url,4);
            
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[3];

        $exp = explode('/',$bebanlist->url,4);
        
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[3];

        if(unlink($upload_dir)){
        
            $bebanlist->nama_foto = '';
            $bebanlist->type = '';
            //$model->size = $file_size;
            $bebanlist->url ='';

            $bebanlist->save();
            
            return $this->redirect('index.php?r=beban-list/index');
        }

    }

    /**
     * Deletes an existing BebanListT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $beban_list Beban List
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($beban_list)
    {

        $bebanlist = BebanListT::findOne($beban_list);

        $exp = explode('/',$bebanlist->url,4);
            
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[3];

        $exp = explode('/',$bebanlist->url,4);
        
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[3];

        unlink($upload_dir);

        $this->findModel($beban_list)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BebanListT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $beban_list Beban List
     * @return BebanListT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($beban_list)
    {
        if (($model = BebanListT::findOne($beban_list)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
