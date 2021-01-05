<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap3/bootstrap3.css',
        'css/FA/all.min.css',
        'css/vanillatoasts.css',
        'fonts/Capture-it.css',
        'plugins/fontawesome-free-5.0.1/css/fontawesome-all.css',
        'plugins/OwlCarousel2-2.2.1/owl.carousel.css',
        'plugins/OwlCarousel2-2.2.1/owl.theme.default.css',
        'plugins/OwlCarousel2-2.2.1/animate.css',
        'plugins/slick-1.8.0/slick.css',
        'plugins/slick-1.8.0/slick-theme.css',
        'plugins/lightBox/css/jquery.lightbox.css',
        'css/custom.css',
    ];
    public $js = [
        'js/jquery-3.3.1.min.js',
        'js/jquery.timers.js',
        'js/vcard.parser.js',
        'css/bootstrap4/popper.js',
        'css/bootstrap4/bootstrap.min.js',
        'css/bootstrap4/bootstrap.bundle.min.js',
        'css/FA/all.min.js',
        'js/vanillatoasts.js',
        'plugins/greensock/TweenMax.min.js',
        'plugins/greensock/TimelineMax.min.js',
        'plugins/scrollmagic/ScrollMagic.min.js',
        'plugins/greensock/animation.gsap.min.js',
        'plugins/greensock/ScrollToPlugin.min.js',
        'plugins/easing/easing.js',
        'plugins/OwlCarousel2-2.2.1/owl.carousel.js',
        'plugins/slick-1.8.0/slick.js',
        'js/dateFormat.js',
        'js/custom_scripts.js',
        'plugins/lightBox/js/jquery.lightbox.min.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
