<?php

namespace Ueditor\Support;

use Ueditor\Library\Uploader;

class Upload
{
	private $base64 = 'upload';

	private $pathFormat;

	private $maxSize;

	private $allowFiles;

	private $fieldName;

	private $oriName = '';

	public function setBase64($base64)
	{
		$this->base64 = $base64;
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

	public function setFieldName($name)
	{
		$this->fileName = $name;
	}

	public function setOriName($name)
	{
		$this->oriName = $name;
	}

	public function getBase64()
	{
		return $this->base64;
	}

	public function getPathFormat()
	{
		return $this->pathFormat;
	}

	public function getMaxSize()
	{
		return $this->maxSize;
	}

	public function getAllowFiles()
	{
		return $this->allowFiles;
	}

	public function getFieldName()
	{
		return $this->fileName;
	}

	public function getOriName()
	{
		return $this->oriName;
	}

	public function run()
	{
		$config = [
			'pathFormat' => $this->getPathFormat(),
			'maxSize'    => $this->getMaxSize(),
			'allowFiles' => $this->getAllowFiles(),
			'oriName'    => $this->getOriName(),
		];

		$up = new Uploader($this->getFieldName(), $config, $this->getBase64());

		return $up->getFileInfo();
	}

}