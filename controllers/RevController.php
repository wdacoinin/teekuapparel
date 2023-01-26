<?php

namespace app\controllers;

use app\models\RevT;
use app\models\Rev;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RevController implements the CRUD actions for RevT model.
 */
class RevController extends Controller
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
     * Lists all RevT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Rev();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RevT model.
     * @param int $rev Rev
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($rev)
    {
        return $this->render('view', [
            'model' => $this->findModel($rev),
        ]);
    }

    /**
     * Creates a new RevT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RevT();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'rev' => $model->rev]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RevT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $rev Rev
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($rev)
    {
        $model = $this->findModel($rev);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'rev' => $model->rev]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RevT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $rev Rev
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($rev)
    {
        $this->findModel($rev)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RevT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $rev Rev
     * @return RevT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($rev)
    {
        if (($model = RevT::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
