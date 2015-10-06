<?php

//получаем способы доставки товара
$delivery_cases = array();

$deliveryObj = new payqr_deliverycase($modx);

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