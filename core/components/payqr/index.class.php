<?php

/**
 * Class payqrMainController
 */
abstract class payqrMainController extends modExtraManagerController {
	/** @var payqr $payqr */
	public $payqr;


	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('payqr_core_path', null, $this->modx->getOption('core_path') . 'components/payqr/');
		require_once $corePath . 'model/payqr/payqr.class.php';

		$this->payqr = new payqr($this->modx);
		//$this->addCss($this->payqr->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->payqr->config['jsUrl'] . 'mgr/payqr.js');
		$this->addHtml('
		<script type="text/javascript">
			payqr.config = ' . $this->modx->toJSON($this->payqr->config) . ';
			payqr.config.connector_url = "' . $this->payqr->config['connectorUrl'] . '";
		</script>
		');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('payqr:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends payqrMainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}