<?php

namespace Ueditor\Support;

use Ueditor\Helpers;

class ListFile
{
	private $allowFiles;

	private $listSize;

	private $path;

	private $size;

	private $start;

	private $end;

	public function setAllowFiles($files)
	{
		$this->allowFiles = $files;
	}

	public function setListSize($size)
	{
		$this->listSize = $size;
	}

	public function setPath($path)
	{
		$this->path = $path;
	}

	public function setSize()
	{
		$this->size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : $this->getListSize();
	}

	public function setStart()
	{
		$this->start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : 0;
	}

	public function setEnd()
	{
		$this->end = $this->start + $this->size;
	}

	public function getAllowFiles()
	{
		return substr(str_replace(".", "|", join("", $this->allowFiles)), 1);
	}

	public function getListSize()
	{
		return $this->listSize;
	}

	public function getPath()
	{
		return $_SERVER['DOCUMENT_ROOT'] . (substr($this->path, 0, 1) == "/" ? "":"/") . $this->path;
	}

	public function getSize()
	{
		return $this->size;
	}

	public function getStart()
	{
		return $this->start;
	}

	public function getEnd()
	{
		return $this->end;
	}

	public function run()
	{
		$files = Helpers::getFiles($this->getPath(), $this->getAllowFiles());
		if (! count($files)) {
			return [
		        "state" => "no match file",
		        "list"  => [],
		        "start" => $this->getStart(),
		        "total" => count($files)
		    ];
		}

		$result = [
		    "state" => "SUCCESS",
		    "list"  => $this->getRangeFiles($files),
		    "start" => $this->getStart(),
		    "total" => count($files)
		]; 

		return $result;
	}

	/**
	 * 获取指定范围的列表
	 */
	private function getRangeFiles($files)
	{
		$len = count($files);
		for ($i = min($this->getEnd(), $len) - 1, $list = []; $i < $len && $i >= 0 && $i >= $this->getStart(); $i--){
		    $list[] = $files[$i];
		}

		return $list;
	}

}