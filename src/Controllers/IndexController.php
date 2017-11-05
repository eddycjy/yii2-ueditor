<?php

namespace Ueditor\Controllers;

use Yii;
use \yii\web\Controller;
use \yii\web\Response;
use Ueditor\Helpers;
use Ueditor\Support\Upload;
use Ueditor\Support\ListFile;
use Ueditor\Support\Crawler;

/**
 * @author EDDYCJY <313687982@qq.com>
 * @since  1.0
 * @link   https://github.com/EDDYCJY/yii2-ueditor
 */
class IndexController extends Controller
{
	public $enableCsrfValidation = false;

    public $isCallback;

    public $uploader;

    public $lister;

    public $crawler;

    public $config;

    public $params = [
        'imageUrlPrefix',
        'imagePathFormat',
        'scrawlUrlPrefix',
        'scrawlPathFormat',
        'snapscreenUrlPrefix',
        'snapscreenPathFormat',
        'catcherUrlPrefix',
        'catcherPathFormat',
        'videoUrlPrefix',
        'videoPathFormat',
        'fileUrlPrefix',
        'filePathFormat',
        'imageManagerUrlPrefix',
        'imageManagerListPath',
        'fileManagerUrlPrefix',
        'fileManagerListPath',
    ];

    public function init()
    {
        $this->isCallback = (isset($_GET["callback"])) ? true : false;

        $this->uploader = new Upload();

        $this->lister = new ListFile();

        $this->crawler = new Crawler();

        $this->config = Helpers::getConfigs();
    }

    public function beforeAction($action) 
    {
        $module = \Yii::$app->controller->module;

        $moduleConfigs = [];
        $defaultConfigs = Helpers::getConfigs();

        foreach ($this->params as $value) {
            if(! empty($module->$value)) {
                $moduleConfigs[$value] = $module->$value;
            }
        }

        $this->config = array_merge($defaultConfigs, $moduleConfigs);

        return true;
    }

    public function actionRun()
    {
        $action = Yii::$app->request->get('action');
        switch ($action) {
            case 'config':
                $result = $this->config;
                break;

            /* 上传图片 */
            case 'uploadimage':
                $this->uploader->setPathFormat($this->config['imagePathFormat']);
                $this->uploader->setMaxSize($this->config['imageMaxSize']);
                $this->uploader->setAllowFiles($this->config['imageAllowFiles']);
                $this->uploader->setFieldName($this->config['imageFieldName']);

                $result = $this->uploader->run();
                break;

            /* 上传涂鸦 */
            case 'uploadscrawl':
                $this->uploader->setPathFormat($this->config['scrawlPathFormat']);
                $this->uploader->setMaxSize($this->config['scrawlMaxSize']);
                $this->uploader->setAllowFiles($this->config['scrawlAllowFiles']);
                $this->uploader->setFieldName($this->config['scrawlFieldName']);
                $this->uploader->setOriName('scrawl.png');
                $this->uploader->setBase64('base64');

                $result = $this->uploader->run();
                break;

            /* 上传视频 */
            case 'uploadvideo':
                $this->uploader->setPathFormat($this->config['videoPathFormat']);
                $this->uploader->setMaxSize($this->config['videoMaxSize']);
                $this->uploader->setAllowFiles($this->config['videoAllowFiles']);
                $this->uploader->setFieldName($this->config['videoFieldName']);

                $result = $this->uploader->run();
                break;
            /* 上传文件 */
            case 'uploadfile':
                $this->uploader->setPathFormat($this->config['filePathFormat']);
                $this->uploader->setMaxSize($this->config['fileMaxSize']);
                $this->uploader->setAllowFiles($this->config['fileAllowFiles']);
                $this->uploader->setFieldName($this->config['fileFieldName']);

                $result = $this->uploader->run();
                break;

            /* 列出图片 */
            case 'listimage':
                $this->lister->setAllowFiles($this->config['imageManagerAllowFiles']);
                $this->lister->setListSize($this->config['imageManagerListSize']);
                $this->lister->setPath($this->config['imageManagerListPath']);
                $this->lister->setSize();
                $this->lister->setStart();

                $result = $this->lister->run();
                break;

            /* 列出文件 */
            case 'listfile':      
                $this->lister->setAllowFiles($this->config['fileManagerAllowFiles']);
                $this->lister->setListSize($this->config['fileManagerListSize']);
                $this->lister->setPath($this->config['fileManagerListPath']);
                $this->lister->setSize();
                $this->lister->setStart();

                $result = $this->lister->run();
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $this->crawler->setPathFormat($this->config['catcherPathFormat']);
                $this->crawler->setMaxSize($this->config['catcherMaxSize']);
                $this->crawler->setAllowFiles($this->config['catcherAllowFiles']);
                $this->crawler->setFieldName($this->config['catcherFieldName']);

                $result = $this->crawler->run();
                break;

            default:
                $result = [
                    'state'=> '请求地址出错'
                ];
                break;
        }

        if ($this->isCallback) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . json_encode($result) . ')';
            } else {
                echo json_encode([
                    'state'=> 'callback参数不合法'
                ]);
            }
        } else {
            echo json_encode($result);
        }
    }

}