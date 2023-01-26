<?php

namespace app\controllers;

use yii;
use app\models\VariableT;
use app\models\Variable;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VariableController implements the CRUD actions for VariableT model.
 */
class VariableController extends Controller
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
     * Lists all VariableT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Variable();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VariableT model.
     * @param int $variable Variable
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($variable)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($variable),
        ]);
    }

    /**
     * Creates a new VariableT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new VariableT(); 
        $searchModel = new Variable();
        $dataProvider = $searchModel->search($this->request->queryParams);


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
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
     * Updates an existing VariableT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $variable Variable
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($variable)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($variable);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'variable' => $model->variable]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing VariableT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $variable Variable
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($variable)
    {
        $this->findModel($variable)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VariableT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $variable Variable
     * @return VariableT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($variable)
    {
        if (($model = VariableT::findOne($variable)) !== null) {
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
