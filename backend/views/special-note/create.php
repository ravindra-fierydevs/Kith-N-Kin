<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SpecialNote */

$this->title = 'Create Special Note';
$this->params['breadcrumbs'][] = ['label' => 'Special Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="special-note-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
