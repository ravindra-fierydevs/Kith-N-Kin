<?php

namespace backend\controllers;

use Yii;
use common\models\FoodItem;
use common\models\FoodItemPrice;
use common\models\FoodItemSearch;
use common\models\Category;
use common\models\MenuCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FoodItemController implements the CRUD actions for FoodItem model.
 */
class FoodItemController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all FoodItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FoodItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FoodItem model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FoodItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FoodItem();
        $categories = Category::find()->all();
        $menu_categories = MenuCategory::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save())
            {
                $fip = new FoodItemPrice();
                $fip->food_item_id = $model->id;
                $fip->half_price = $model->half_price;
                $fip->full_price = $model->full_price;
                $fip->save();
            }
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => $categories,
                'menu_categories' => $menu_categories,
            ]);
        }
    }

    /**
     * Updates an existing FoodItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categories = Category::find()->all();
        $menu_categories = MenuCategory::find()->all();
        $model->loadPrices();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save())
            {
                $fip = $model->foodPrice;
                $fip->half_price = $model->half_price;
                $fip->full_price = $model->full_price;
                $fip->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => $categories,
                'menu_categories' => $menu_categories,
            ]);
        }
    }

    /**
     * Deletes an existing FoodItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FoodItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FoodItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FoodItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
