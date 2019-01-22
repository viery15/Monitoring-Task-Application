<?php
/**
 * Created by PhpStorm.
 * User: VIERY
 * Date: 1/22/2019
 * Time: 8:56 AM
 */
namespace app\assets;

use yii\web\AssetBundle;

class DataTablesAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/datatables.min.css',
    ];
    public $js = [
        'js/jquery.dataTables.min.js',
        '/js/dataTables.bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}