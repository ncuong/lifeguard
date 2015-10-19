<?php
/**
 * Created by PhpStorm.
 * User: VIETBINH
 * Date: 9/29/15
 * Time: 3:19 PM
 */
namespace frontend\widgets;
use yii\web\AssetBundle;
/**
 * The asset bundle for the [[MaskedInput]] widget.
 *
 * Includes client assets of [jQuery input mask plugin](https://github.com/RobinHerbots/jquery.inputmask).
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 2.0
 */
class MaskedInputAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery.inputmask/dist';
    public $js = [
        'jquery.inputmask.bundle.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}