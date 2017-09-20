<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Table */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="table-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name_prefix')->textInput(['maxlength' => true, 'value' => 'TABLE']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'number')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'capacity')->textInput() ?>
        </div>
    </div>    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
