<?php

namespace app\controllers;

use app\models\Akun;
use yii;
use app\models\AkunSaldoT;
use app\models\AkunSaldo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * AkunSaldoController implements the CRUD actions for AkunSaldoT model.
 */
class AkunSaldoController extends Controller
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
     * Lists all AkunSaldoT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new AkunSaldo();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AkunSaldoT model.
     * @param int $akun_saldo Akun Saldo
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($akun_saldo)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($akun_saldo),
        ]);
    }

    /**
     * Creates a new AkunSaldoT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new AkunSaldoT();
        //tabel akun
        $modAkun = ArrayHelper::map(Akun::find()->select(['akun', 'CONCAT(akun_nama, "-", akun_ref, " an:", an) AS akun_ref'])->orderBy('akun_nama')->asArray()->all(), 'akun', 'akun_ref');
        
        $modInorout = ['Masuk Kas Besar' => 'Masuk Kas Besar', 'Keluar Kas Besar' => 'Keluar Kas Besar'];

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if($model->save()){
                Yii::$app->session->setFlash('success', 'Saldo updated!');
                return $this->redirect('index.php?r=akun-saldo/index');
            }else{
                Yii::$app->session->setFlash('danger', 'Saldo updated Gagal!' . $model->size);
                return $this->redirect('index.php?r=akun-saldo/index');
            }
           
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'modInorout' => $modInorout,
                'modAkun' => $modAkun
            ]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'modInorout' => $modInorout,
            'modAkun' => $modAkun
        ]);
    }

    /**
     * Updates an existing AkunSaldoT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $akun_saldo Akun Saldo
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($akun_saldo)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($akun_saldo);
        //tabel akun
        $modAkun = ArrayHelper::map(Akun::find()->select(['akun', 'CONCAT(akun_nama, "-", akun_ref, " an:", an) AS akun_ref'])->orderBy('akun_nama')->asArray()->all(), 'akun', 'akun_ref');
        
        $modInorout = ['Masuk Kas Besar' => 'Masuk Kas Besar', 'Keluar Kas Besar' => 'Keluar Kas Besar'];

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if($model->save()){
                Yii::$app->session->setFlash('success', 'Saldo updated!');
                return $this->redirect('index.php?r=akun-saldo/index');
            }else{
                Yii::$app->session->setFlash('danger', 'Saldo updated Gagal!' . $model->size);
                return $this->redirect('index.php?r=akun-saldo/index');
            }
           
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'modInorout' => $modInorout,
                'modAkun' => $modAkun
            ]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'modInorout' => $modInorout,
            'modAkun' => $modAkun
        ]);
    }

    /**
     * Deletes an existing AkunSaldoT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $akun_saldo Akun Saldo
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($akun_saldo)
    {
        $this->findModel($akun_saldo)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AkunSaldoT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $akun_saldo Akun Saldo
     * @return AkunSaldoT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($akun_saldo)
    {
        if (($model = AkunSaldoT::findOne($akun_saldo)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
