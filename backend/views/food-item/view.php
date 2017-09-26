<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\FoodItem;

/* @var $this yii\web\View */
/* @var $model common\models\FoodItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Food Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'attribute' => 'category_id',
                'value' => $model->category->name,
            ],
            [
                'attribute' => 'menu_category_id',
                'value' => $model->menuCategory->name,
            ],
            'name',
            'short_name',
            'item_code',
            [
                'attribute' => 'status',
                'value' => FoodItem::$statuses[$model->status],
            ],
            [
                'attribute' => 'created_by',
                'value' => $model->createdBy->username,
            ],
            [
                'attribute' => 'updated_by',
                'value' => $model->updatedBy->username,
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
