<?php

/**
 * The home manager controller for payqr.
 *
 */
class payqrHomeManagerController extends payqrMainController {
	/* @var payqr $payqr */
	public $payqr;


	/**
	 * @param array $scriptProperties
	 */
	public function process(array $scriptProperties = array()) {
	}


	/**
	 * @return null|string
	 */
	public function getPageTitle() {
		return $this->modx->lexicon('payqr');
	}


	/**
	 * @return void
	 */
	public function loadCustomCssJs() {
		$this->addCss($this->payqr->config['cssUrl'] . 'mgr/main.css');
		$this->addCss($this->payqr->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
		$this->addJavascript($this->payqr->config['jsUrl'] . 'mgr/misc/utils.js');
		$this->addJavascript($this->payqr->config['jsUrl'] . 'mgr/widgets/items.grid.js');
		$this->addJavascript($this->payqr->config['jsUrl'] . 'mgr/widgets/items.windows.js');
		$this->addJavascript($this->payqr->config['jsUrl'] . 'mgr/widgets/home.panel.js');
		$this->addJavascript($this->payqr->config['jsUrl'] . 'mgr/sections/home.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			MODx.load({ xtype: "payqr-page-home"});
		});
		</script>');
	}


	/**
	 * @return string
	 */
	public function getTemplateFile() {
		return $this->payqr->config['templatesPath'] . 'home.tpl';
	}
}