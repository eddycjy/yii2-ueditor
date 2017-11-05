<?php

namespace Ueditor\Support;

use Ueditor\Library\Uploader;

/**
 * @author EDDYCJY <313687982@qq.com>
 * @since  1.0
 * @link   https://github.com/EDDYCJY/yii2-ueditor
 */
class Crawler
{
	private $fieldName;

	private $pathFormat;

	private $maxSize;

	private $allowFiles;

	private $oriName = 'remote.png';

	public function setFieldName($name)
	{
		$this->fieldName = $name;
	}

	public function setPathFormat($format)
	{
		$this->pathFormat = $format;
	}

	public function setMaxSize($size)
	{
		$this->maxSize = $size;
	}

	public function setAllowFiles($files)
	{
		$this->allowFiles = $files;
	}

	public function getFieldName()
	{
		return $this->fieldName;
	}

	public function getPathFormat()
	{
		return $this->pathFormat;
	}


	public function getAllowFiles()
	{
		return $this->allowFiles;
	}

	public function getOriName()
	{
		return $this->oriName;
	}

	public function getSource()
	{
		$fieldName = $this->getFieldName();
		if (isset($_POST[$fieldName])) {
		    $source = $_POST[$fieldName];
		} else {
		    $source = $_GET[$fieldName];
		}

		return $source;
	}

	public function run()
	{
		/* 上传配置 */
		$config = [
		    "pathFormat" => $this->getPathFormat(),
		    "maxSize" => $this->getMaxSize(),
		    "allowFiles" => $this->getAllowFiles(),
		    "oriName" => $this->getOriName()
		];
		$fieldName = $this->getFieldName();

		/* 抓取远程图片 */
		$list = [];
		foreach ($this->getSource() as $imgUrl) {
		    $item = new Uploader($imgUrl, $config, "remote");
		    $info = $item->getFileInfo();
		    array_push($list, array(
		        "state" => $info["state"],
		        "url" => $info["url"],
		        "size" => $info["size"],
		        "title" => htmlspecialchars($info["title"]),
		        "original" => htmlspecialchars($info["original"]),
		        "source" => htmlspecialchars($imgUrl)
		    ));
		}

		/* 返回抓取数据 */
		return [
		    'state' => count($list) ? 'SUCCESS':'ERROR',
		    'list'  => $list
		];
	}

}