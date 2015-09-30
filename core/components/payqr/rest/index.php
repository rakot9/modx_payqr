<?php
use Payqr\payqr_config;

// Boot up MODX
require_once dirname(dirname(__FILE__)) . '/config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('web');
$modx->getService('error','error.modError', '', '');
// Boot up any service classes or packages (models) you will need
$path = $modx->getOption('payqr_core_path', null, 
   $modx->getOption('core_path').'components/payqr/') . 'model/payqr/';

$modx->getService('payqr', 'payqr', $path);

// Load the modRestService class and pass it some basic configuration
$rest = $modx->getService('rest', 'rest.modRestService', '', array(
    'basePath' => dirname(__FILE__) . '/Controllers/',
    'controllerClassSeparator' => '',
    'controllerClassPrefix' => 'Payqr',
    'xmlRootNode' => 'response',
));
// Prepare the request
$rest->prepare();

// Make sure the user has the proper permissions, send the user a 401 error if not
if (!$rest->checkPermissions()) {
    $rest->sendUnauthorized(true);
}
//
require_once $modx->getOption('payqr_core_path', null, $modx->getOption('core_path') . 'components/payqr/') . 'model/payqr/Payqr/payqr_config.php';

$payqr_button = new payqr_button($modx, 0, []);

$config = $payqr_button->getPayqrItems();

$payqrConfig = payqr_config::init($config['merchant_id'], $config['secret_key_in'], $config['secret_key_out']);
payqr_config::setLogFile($config['log_url']);

payqr_logs::addEnter();

try{
  $Payqr = new payqr_receiver(); // создаем объект payqr_receiver
  $Payqr->receiving(); // получаем идентификатор счета на оплату в PayQR
  // проверяем тип уведомления от PayQR
  switch ($Payqr->getType()) {
    case 'invoice.deliverycases.updating':
      // нужно вернуть в PayQR список способов доставки для покупателя
      require_once PAYQR_HANDLER.'invoice.deliverycases.updating.php';
      break;
    case 'invoice.pickpoints.updating':
      // нужно вернуть в PayQR список пунктов самовывоза для покупателя
      require_once PAYQR_HANDLER.'invoice.pickpoints.updating.php';
      break;
    case 'invoice.order.creating':
      // нужно создать заказ в своей учетной системе, если заказ еще не был создан, и вернуть в PayQR полученный номер заказа (orderId), если его еще не было
      require_once PAYQR_HANDLER.'invoice.order.creating.php';
      break;
    case 'invoice.paid':
      // нужно зафиксировать успешную оплату конкретного заказа
      require_once PAYQR_HANDLER.'invoice.paid.php';
      break;
    case 'invoice.failed':
      // ошибка совершения покупки, операция дальше продолжаться не будет
      require_once PAYQR_HANDLER.'invoice.failed.php';
      break;
    case 'invoice.cancelled':
      // PayQR зафиксировал отмену конкретного заказа до его оплаты
      require_once PAYQR_HANDLER.'invoice.cancelled.php';
      break;
    case 'invoice.reverted':
      // PayQR зафиксировал полную отмену конкретного счета (заказа) и возврат всей суммы денежных средств по нему
      require_once PAYQR_HANDLER.'invoice.reverted.php';
      break;
    case 'revert.failed':
      // PayQR отказал интернет-сайту в отмене счета и возврате денежных средств покупателю
      require_once PAYQR_HANDLER.'revert.failed.php';
      break;
    case 'revert.succeeded':
      // PayQR зафиксировал отмену счета интернет-сайтом и вернул денежные средства покупателю
      require_once PAYQR_HANDLER.'revert.succeeded.php';
      break;
    default:
  }
  $Payqr->response();
}
catch (payqr_exeption $e){
  if(file_exists(PAYQR_ERROR_HANDLER.'invoice_action_error.php'))
  {
    $response = $e->response;
    require PAYQR_ERROR_HANDLER.'receiver_error.php';
  }
}

exit();


//
// Run the request
//$rest->process();