<?php
/**
 * Created by PhpStorm.
 * User: VIERY
 * Date: 1/22/2019
 * Time: 8:56 AM
 */
namespace app\assets;

use yii\web\AssetBundle;

class HighChartsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'js/highcharts.js',
        'js/exporting.js',
        'js/export-data.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}