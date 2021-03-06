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
class AppAsset
    extends AssetBundle
{
    
    public $basePath = '@webroot';
    
    public $baseUrl = '@web';
    
    public $css = [
        'css/icons.min.css',
        'css/plugins.css',
        'css/style.css',
    ];
    
    public $js = [
        'js/ajax-mail.js',
        'js/main.js',
        'js/checkout.js',
        'js/cart.js',
        'js/plugins.js',
        'js/product_colors.js',
        'js/popper.min.js',
        'js/modernizr-2.8.3.min.js',
        'js/bootstrap.min.js',
        'js/jquery.maskedinput.min.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'app\assets\IconsAsset',
    ];
    
}
