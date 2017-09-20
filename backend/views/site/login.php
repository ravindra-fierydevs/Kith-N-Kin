<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <div class="body bg-gray">
                    <div class="form-group">
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control']) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control']) ?>
                    </div>          
                    <div class="form-group">
                        <?= $form->field($model, 'rememberMe')->checkbox() ?> Remember me
                    </div>
                </div>
                <div class="footer">                                                         
                    <?= Html::submitButton('Login', ['class' => 'btn bg-olive btn-block', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

            <div class="margin text-center">
                <span>Sign in using social networks</span>
                <br/>
                <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
                <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
                <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

            </div>
        </div>
</div>
