<?php

namespace app\controllers;

use app\models\BebanT;
use app\models\Beban;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BebanController implements the CRUD actions for BebanT model.
 */
class BebanController extends Controller
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
     * Lists all BebanT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Beban();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BebanT model.
     * @param int $beban Beban
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($beban)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($beban),
        ]);
    }

    /**
     * Creates a new BebanT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new BebanT();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $searchModel = new Beban();
                $dataProvider = $searchModel->search($this->request->queryParams);
                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BebanT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $beban Beban
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($beban)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($beban);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'beban' => $model->beban]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BebanT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $beban Beban
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($beban)
    {
        $this->findModel($beban)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BebanT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $beban Beban
     * @return BebanT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($beban)
    {
        if (($model = BebanT::findOne($beban)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
