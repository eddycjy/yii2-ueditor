<?php
namespace Ueditor\Widgets;

use yii\web\AssetBundle;

class UeditorAsset extends AssetBundle
{
	public $css = [];

	public $js = [
		'ueditor.config.js',
        'ueditor.all.min.js',
	];

	public $depends = [];

	public function init()
	{
		$this->sourcePath = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Assets';
	}

}