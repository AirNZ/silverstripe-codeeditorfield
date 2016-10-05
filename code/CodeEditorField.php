<?php

use SilverStripe\View\Requirements;
use SilverStripe\Forms\TextareaField;

class CodeEditorField extends TextareaField 
{

	private static $allowed_actions = array (
		'iframe'
	);

	/**
	 * @var string default_mode
	 */
	private static $default_mode = 'html';

	/**
	 * @var string default_theme
	 */
	private static $default_theme;
	
	/**
	 * @var string mode
	 */
	protected $mode;

	/**
	 * @var string theme
	 */
	protected $theme;

	/**
	 * @var int Visible number of text lines.
	 */
	protected $rows = 8;

    public function getAttributes()
    {
		return array_merge(
			parent::getAttributes(),
			array(
				'data-mode' => $this->getMode(),
				'data-ace-path' => $this->getAcePath(),
				'data-theme' => $this->getTheme()
			)
		);
	}

    public function Field($properties = array())
    {
		$acePath = $this->getAcePath();

		Requirements::javascript($acePath . "ace.js");
		Requirements::javascript($acePath . "mode-" . $this->getMode() . ".js");
	//	Requirements::javascript($acePath . "worker-" . $this->getMode() . ".js");

		Requirements::javascript("codeeditorfield/javascript/CodeEditorField.js");
		Requirements::css("codeeditorfield/css/CodeEditorField.css");
		
		return parent::Field($properties);
	}

    public function setMode($mode)
    {
		$this->mode = $mode;
		return $this;
	}
	
    public function getMode()
    {
		return $this->mode ? $this->mode : $this->config()->get('default_mode');
	}

    public function setTheme($theme)
    {
		$this->theme = $theme;
		return $this;
	}
	
    public function getTheme()
    {
		return $this->theme ? $this->theme : $this->config()->get('default_theme');
	}

    public function getAcePath()
    {
		return basename(dirname(__DIR__)) . '/thirdparty/ace/src-noconflict/';
	}
}
