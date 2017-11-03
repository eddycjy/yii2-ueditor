<?php

namespace Ueditor;

use \yii\base\Module;

class UeditorModule extends Module
{
	public $controllerNamespace = 'Ueditor\Controllers';

	public $imageUrlPrefix;

	public $imagePathFormat;

	public $scrawlUrlPrefix;

	public $scrawlPathFormat;

	public $snapscreenUrlPrefix;

	public $snapscreenPathFormat;

	public $catcherUrlPrefix;

	public $catcherPathFormat;

	public $videoUrlPrefix;

	public $videoPathFormat;

	public $fileUrlPrefix;

	public $filePathFormat;

	public $imageManagerUrlPrefix;

	public $imageManagerListPath;

	public $fileManagerUrlPrefix;

	public $fileManagerListPath;

	public function init()
	{
		parent::init();
	}
}

