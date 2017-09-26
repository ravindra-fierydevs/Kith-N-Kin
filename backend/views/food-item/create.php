<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FoodItem */

$this->title = 'Create Food Item';
$this->params['breadcrumbs'][] = ['label' => 'Food Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
        'menu_categories' => $menu_categories,
    ]) ?>

</div>
