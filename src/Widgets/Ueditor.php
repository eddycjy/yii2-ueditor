<?php
namespace Ueditor\Widgets;

use Yii;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;
use Ueditor\Widgets\UeditorAsset;

class Ueditor extends InputWidget
{
	const DEFAULT_ID = 'ue';

	const DEFAULT_SERVER_URL = 'ueditor/index/run';

	public $id;

	public $serverUrl;

	public $lang = 'zh-cn';

	public $options = [];

	public function init()
	{
		if(empty($this->id)) {
			$this->id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : self::DEFAULT_ID;
		}

		$this->serverUrl = ! empty($this->serverUrl) ? $this->serverUrl : Url::to([self::DEFAULT_SERVER_URL]);

		$this->options = array_merge([
			'serverUrl' => $this->serverUrl,
			'lang'	    => $this->lang,
		], $this->options);
	}

	public function run()
	{
		$this->registerScript();

		if ($this->hasModel()) {
            return Html::activeTextarea($this->model, $this->attribute, ['id' => $this->id]);
        } else {
            return Html::textarea($this->id, $this->value, ['id' => $this->id]);
        }
	}

	private function registerScript()
	{
		UeditorAsset::register($this->view);

		$options = json_encode($this->options);
		$script  = "UE.getEditor('" . $this->id . "', " . $options . ")";

		//加载时包含在jQuery(document).ready()方法里面
		$this->view->registerJs($script, View::POS_READY);
	}

}