<?php


namespace app\assets;


use yii\web\AssetBundle;

class AuthAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap4/bootstrap.min.css',
        'css/vanillatoasts.css',
        'css/FA/all.min.css',
        'css/authForm.css',
    ];
    public $js = [
        'js/jquery-3.3.1.min.js',
        'css/bootstrap4/popper.js',
        'css/bootstrap4/bootstrap.min.js',
        'css/bootstrap4/bootstrap.bundle.min.js',
        'js/vanillatoasts.js',
        'css/FA/all.min.js',
        'js/AdmLogin.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}