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
        'css/bootstrap4/bootstrap.min.css',
        'css/bootstrap4/bootstrap-grid.min.css',
        'css/bootstrap4/bootstrap-reboot.min.css',
        'css/FA/all.min.css',
        'fonts/Capture-it.css',
        'css/regular_styles.css',
        'css/regular_responsive.css',
        'plugins/fontawesome-free-5.0.1/css/fontawesome-all.css',
        'plugins/OwlCarousel2-2.2.1/owl.carousel.css',
        'plugins/OwlCarousel2-2.2.1/owl.theme.default.css',
        'plugins/OwlCarousel2-2.2.1/animate.css',
        'plugins/slick-1.8.0/slick.css',
        'plugins/slick-1.8.0/slick-theme.css',
        'css/custom.css',
    ];
    public $js = [
        'js/jquery-3.3.1.min.js',
        'css/bootstrap4/popper.js',
        'css/bootstrap4/bootstrap.min.js',
        'css/bootstrap4/bootstrap.bundle.min.js',
        'css/FA/all.min.js',
        'plugins/greensock/TweenMax.min.js',
        'plugins/greensock/TimelineMax.min.js',
        'plugins/scrollmagic/ScrollMagic.min.js',
        'plugins/greensock/animation.gsap.min.js',
        'plugins/greensock/ScrollToPlugin.min.js',
        'plugins/easing/easing.js',
        'plugins/OwlCarousel2-2.2.1/owl.carousel.js',
        'plugins/slick-1.8.0/slick.js',
        'js/regular_custom.js',
        'js/custom_scripts.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
