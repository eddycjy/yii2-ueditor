<?php

namespace Ueditor;

use Ueditor\Container;

class Helpers
{
	public static function getFiles($path, $allowFiles, &$files = [])
	{
		if (!is_dir($path)) {
			return null;
		}

	    if(substr($path, strlen($path) - 1) != '/') {
	    	$path .= '/';
	    }
	    
	    $handle = opendir($path);
	    while (false !== ($file = readdir($handle))) {
	        if ($file != '.' && $file != '..') {
	            $path2 = $path . $file;
	            if (is_dir($path2)) {
	                self::getFiles($path2, $allowFiles, $files);
	            } else {
	                if (preg_match("/\.(".$allowFiles.")$/i", $file)) {
	                    $files[] = array(
	                        'url'=> substr($path2, strlen($_SERVER['DOCUMENT_ROOT'])),
	                        'mtime'=> filemtime($path2)
	                    );
	                }
	            }
	        }
	    }

	    return $files;
	}

	public static function getConfigs()
	{
		$name = 'ueditor_configs';
		if(! Container::exist($name)) {
			$configs = require_once dirname(__FILE__) . '/Config/Config.php';
			Container::bind($name, function () use ($configs) {
				return $configs;
			});

		} else {
			$configs = Container::make($name);
		}

		return $configs;
	}

}