<?php

/**
 * The base class for payqr.
 */
class payqr {
	/* @var modX $modx */
	public $modx;


	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('payqr_core_path', $config, $this->modx->getOption('core_path') . 'components/payqr/');
		$assetsUrl = $this->modx->getOption('payqr_assets_url', $config, $this->modx->getOption('assets_url') . 'components/payqr/');
		$connectorUrl = $assetsUrl . 'connector.php';

		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			'cssUrl' => $assetsUrl . 'css/',
			'jsUrl' => $assetsUrl . 'js/',
			'imagesUrl' => $assetsUrl . 'images/',
			'connectorUrl' => $connectorUrl,

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'templatesPath' => $corePath . 'elements/templates/',
			'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath . 'elements/snippets/',
			'processorsPath' => $corePath . 'processors/'
		), $config);

		$this->modx->addPackage('payqr', $this->config['modelPath']);
		$this->modx->lexicon->load('payqr:default');
	}
        
    public function getButton()
    {
        $this->modx->regClientStartupScript('https://payqr.ru/popup.js?merchId=892889-13811');
        
        return '<button
            class="payqr-button"
            data-scenario="buy"
            data-cart=\'[{"article":"123123","name":"Хороший товар","quantity":"1","amount":"500.00","imageurl":"http://modastuff.ru/item1.jpg"},{"article":"123123","name":"Очень хороший товар","quantity":"2","amount":"1000.00","imageurl":"http://modastuff.ru/item2.jpg"}]\'
            data-amount="2500.00"
            style="width: 163px; height: 36px;" > Купить быстрее </button>';
    }
}