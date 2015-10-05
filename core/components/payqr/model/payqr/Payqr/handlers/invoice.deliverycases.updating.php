<?php

//получаем способы доставки товара
$delivery_cases = array();

$deliveryObj = new payqr_deliverycase();

$deliveries = $deliveryObj->getDeliveryCases();

$i = 1;

$payqrOrder = new payqr_order($modx, $Payqr);

$order_amount = $payqrOrder->getTotal();

foreach($deliveries as $delivery)
{
    $_delivery = array();
    
    $_delivery['article'] = $delivery['id'];
    $_delivery['number'] = $i++;
    $_delivery['name'] = $delivery['label'];
    $_delivery['description'] = $delivery['label'];
    $_delivery['amountFrom'] = $_delivery['amountTo'] = ($order_amount >= $delivery['free_start'])? 0 : $delivery['free_start'];
    
    $delivery_cases[] = $_delivery;
}

$Payqr->objectOrder->setDeliveryCases($delivery_cases);

function __log($message = null, $line = 0, $debug = false, $delete_old_log_file = false)
{
	if($delete_old_log_file) @unlink("__worker.log");if(empty($message) || !$debug) return;$fp = fopen("__worker.log", "a");fwrite($fp, "[{$line}]\r\n\t{$message}\r\n");fclose($fp);
}