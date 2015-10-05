<?php

require_once $modx->getOption('payqr_core_path', null, $modx->getOption('core_path') . 'components/payqr/') . 'model/payqr/Payqr/payqr_config.php';

/** @var array $scriptProperties */
/** @var payqr $payqr */
if (!$payqr = $modx->getService('payqr', 'payqr', $modx->getOption('payqr_core_path', null, $modx->getOption('core_path') . 'components/payqr/') . 'model/payqr/', $scriptProperties)) {
	return 'Could not load payqr class!';
}
/** @var pdoTools $pdoTools */
$pdoTools = $modx->getService('pdoTools');

if (!($payqr instanceof payqr) || !($pdoTools instanceof pdoTools)) return '';

$payqr->initPopupJS();

//Получаем список идентификаторов товаров
$productsData = $payqr->getProductsData($page, (isset($id) && !empty(trim($id)))? array(0 => $id) : array() );

$output = payqr_buttongen::getInstance()
            ->setPage($page)
            ->genereateButton(new payqr_button($modx, $productsData));

return $output;