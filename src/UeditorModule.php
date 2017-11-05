<?php

namespace Ueditor;

use \yii\base\Module;

/**
 * @author EDDYCJY <313687982@qq.com>
 * @since  1.0
 * @link   https://github.com/EDDYCJY/yii2-ueditor
 */
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

