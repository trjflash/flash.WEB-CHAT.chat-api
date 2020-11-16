<?php


namespace app\assets;


use yii\web\AssetBundle;

class DashboardAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap4/bootstrap.min.css',
        'css/vanillatoasts.css',
        'css/FA/all.min.css',
        'fonts/MaterialIcons.css',
        'css/shards-dashboards.1.1.0.min.css',
        'css/extras.1.1.0.min.css',
        'css/admin.css',

    ];
    public $js = [
        'css/bootstrap4/popper.js',
        'css/bootstrap4/bootstrap.min.js',
        'css/bootstrap4/bootstrap.bundle.min.js',
        'js/adm/ckeditor/ckeditor.js',
        'js/vanillatoasts.js',
        'js/buttons.js',
        'js/Chart.js',
        'js/jquerry.sharrre.min.js',
        'js/Shards.min.js',
        'js/shards-dashboards.1.1.0.min.js',
        'js/extras.1.1.0.min.js',
        'js/adm/shards_app/app-blog-overview.1.1.0.min.js',
        'js/adm/admScript.js',
        'css/FA/all.min.js',


    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}