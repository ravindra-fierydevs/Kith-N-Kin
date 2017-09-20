<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tables';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Table', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'name_prefix',
            //'number',

            [
                'attribute' => 'name',
                'value' => function($data){
                    return $data->name;
                },
            ],
            'capacity',
            'created_at:date',
             'updated_at:date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
