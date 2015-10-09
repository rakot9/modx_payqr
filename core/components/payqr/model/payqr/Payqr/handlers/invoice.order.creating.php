<?php
$cData = $Payqr->objectOrder->getCustomer();
$uData = json_decode($Payqr->objectOrder->getUserData());
$uData = isset($uData[0])? $uData[0] : $uData;

if(!isset($uData->user_id) && empty($uData->user_id)) 
{
    if(!isset($cData->email)) //, $uData->email
    {
        return false;
    }
    $user_id = null;
    //пытаемся зарегистрировать пользователя
}
else
{
    $user_id = $uData->user_id;
}

//производим проверку на наличие inv_id
$inv_id = $Payqr->objectOrder->getInvId();

if(empty($inv_id))
{
    payqr_logs::log("Не смогли получить invoice_id");
    return false;
}

payqr_logs::log("Нашли invoice_id:" . $inv_id);

// производим проверку на наличие invoice
$payqrOrder = new payqr_order($modx, $Payqr);

$order_id = $payqrOrder->checkInvoice($inv_id);

if(!empty($order_id))
{
    //заказ с заданнными параметрами уже создавался
    //производим обновление состояния заказа
    
    if($payqrOrder->updateShopkeeper3Order($order_id))
    {
        payqr_logs::log("Успешно произведено обновление товаров");
    }
    else
    {
        payqr_logs::log("Не смогли произвести обновление товаров в заказе");
    }
}
else
{
    //создаем заказ на основе актуализированным данных
    $order_id = $payqrOrder->createShopkeeper3Order( $user_id );
    
    $payqrOrder->setInvoice($order_id, $inv_id);
}

//Получаем стоимость товара с доставкой
$amount = $payqrOrder->getTotal(true);

if(empty($amount))
{
    payqr_logs::log('Не смогли получить amount у заказа!');
    return false;
}

payqr_logs::log('Итоговая стоимость amount у заказа : ' . $amount);
$Payqr->objectOrder->setAmount($amount);

if(!$order_id)
{
    payqr_logs::log('Не смогли получить orderId у заказа!');
    return false;
}

payqr_logs::log('Устанавливаем orderId: ' . $order_id);
$Payqr->objectOrder->setOrderId($order_id);

//Корзину необходимо очищать 
$userdata = array(
    "cart_id" => (isset($config['cart_id'])? (int) $config['cart_id'] : null),
    "user_id" => $user_id,
    "session_id" => "session"/*$uData->session_id*/,
    "order_id" => $order_id,
    "amount" => $amount,
    "message" => (isset($config['user_message_text'])? $config['user_message_text'] : ""),
    "messageImageURL" => (isset($config['user_message_imageurl'])? $config['user_message_imageurl'] : ""),
    "messageURL" => (isset($config['user_message_url'])? $config['user_message_url'] : "")
);

$Payqr->objectOrder->setUserData(json_encode($userdata));