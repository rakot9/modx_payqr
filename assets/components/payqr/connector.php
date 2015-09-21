<?php
/** @noinspection PhpIncludeInspection */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var payqr $payqr */
$payqr = $modx->getService('payqr', 'payqr', $modx->getOption('payqr_core_path', null, $modx->getOption('core_path') . 'components/payqr/') . 'model/payqr/');
$modx->lexicon->load('payqr:default');

// handle request
$corePath = $modx->getOption('payqr_core_path', null, $modx->getOption('core_path') . 'components/payqr/');
$path = $modx->getOption('processorsPath', $payqr->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
	'processors_path' => $path,
	'location' => '',
));