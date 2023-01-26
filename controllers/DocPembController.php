<?php

namespace app\controllers;

use app\models\DocPembT;
use app\models\DocPemb;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DocPembController implements the CRUD actions for DocPembT model.
 */
class DocPembController extends Controller
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
     * Lists all DocPembT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocPemb();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DocPembT model.
     * @param int $id_img Id Img
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_img)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_img),
        ]);
    }

    /**
     * Creates a new DocPembT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DocPembT();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_img' => $model->id_img]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DocPembT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_img Id Img
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_img)
    {
        $model = $this->findModel($id_img);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_img' => $model->id_img]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DocPembT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_img Id Img
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_img)
    {
        $this->findModel($id_img)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DocPembT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_img Id Img
     * @return DocPembT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_img)
    {
        if (($model = DocPembT::findOne($id_img)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
