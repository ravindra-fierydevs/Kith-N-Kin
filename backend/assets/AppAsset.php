<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/bootstrap.min.css',
        'css/AdminLTE.css',
        'css/font-awesome.min.css',
        'css/ionicons.min.css',
        'css/jvectormap/jquery-jvectormap-1.2.2.css',
        'css/fullcalendar/fullcalendar.css',
        'css/daterangepicker/daterangepicker-bs3.css',
        'css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
    ];
    public $js = [
        //'http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js',
        //'js/jquery-ui-1.10.3.min.js',
        'js/bootstrap.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
        'js/plugins/sparkline/jquery.sparkline.min.js',
        'js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'js/plugins/fullcalendar/fullcalendar.min.js',
        'js/plugins/jqueryKnob/jquery.knob.js',
        'js/plugins/daterangepicker/daterangepicker.js',
        'js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        'js/plugins/iCheck/icheck.min.js',
        'js/AdminLTE/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
