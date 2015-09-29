<?php

require_once $modx->getOption('payqr_core_path', null, $modx->getOption('core_path') . 'components/payqr/') . 'model/payqr/Payqr/payqr_config.php';

use Payqr\payqr_config;

/** @var array $scriptProperties */
/** @var payqr $payqr */
if (!$payqr = $modx->getService('payqr', 'payqr', $modx->getOption('payqr_core_path', null, $modx->getOption('core_path') . 'components/payqr/') . 'model/payqr/', $scriptProperties)) {
	return 'Could not load payqr class!';
}
/** @var pdoTools $pdoTools */
$pdoTools = $modx->getService('pdoTools');

if (!($payqr instanceof payqr) || !($pdoTools instanceof pdoTools)) return '';

$payqr->initPopupJS();

$payqrConfig = payqr_config::init($config['merchant_id'], $config['secret_key_in'], $config['secret_key_out']);

$output = payqr_buttongen::getInstance()
            ->setPage($page)
            ->genereateButton(new payqr_button($modx, $amount, []));

return $output;