<?php

//Пользователя гость
$user_id = null;

$cData = $Payqr->objectOrder->getCustomer();
$uData = json_decode($Payqr->objectOrder->getUserData());
$uData = isset($uData[0])? $uData[0] : $uData;

if(!isset($uData->user_id) && empty($uData->user_id)) 
{
	if(!isset($cData->email) && !isset($uData->email))
	{
		//фэйлим заказ клиента
		//система не передала email клиента
		return false;
	}

	//создаем пользователя в системе
	$user_email = isset($cData->email)? $cData->email : $uData->email;

        $user_id = null;
}
else
{
	//имеем клиента, от имени которого будем создавать заказ в системе
	$user_id = $uData->user_id;
}

//Формируем информацию о покупателе
$contacts = array();
$FIO = "";

if(isset($cData->lastName) && !empty($cData->lastName))
{
    $FIO = $cData->lastName . " ";
}

if(isset($cData->firstName) && !empty($cData->firstName))
{
    $FIO = $cData->firstName . " ";
}

if(isset($cData->middlename) && !empty($cData->middlename))
{
    $FIO = $cData->middlename;
}

if(!empty($FIO))
{ 
    $contacts[] = array(
        "name" => "fullname",
        "value" => $FIO,
        "label" => "Имя",
    );
}

if(isset($cData->email) && !empty($cData->email))
{
    $contacts[] = array(
        "name" => "email",
        "value" => $cData->email,
        "label" => "Адрес эл. почты",
    );
}

if(isset($cData->phone) && !empty($cData->phone))
{
    $contacts[] = array(
        "name" => "phone",
        "value" => $cData->phone,
        "label" => "Телефон",
    );
}

$contacts[] = array(
    "name" => "message",
    "value" => "Заказ сделан через платежный сервис PayQR.",
    "label" => "Комментарий",
);

//получаем статусы заказов
$status_created = isset($config['payqr_status_creatted']) && !empty($config['payqr_status_creatted'])? $config['payqr_status_creatted'] : 0;

//создаем заказ на основе актуализированным данных
$OrderModel = new payqr_order($modx, $Payqr);

$order_id = $OrderModel->createShopkeeper3Order( $user_id, $contacts);

$amount = $OrderModel->getTotal();

if(empty($amount))
{
	//не смогли посчитать сумму заказа
	return false;
}

$Payqr->objectOrder->setAmount($amount);

if(!$order_id)
{
	//фэйлим заказ клиента
	//не получилось создать заказ
	return false;
}

//формируем данные для таблицы order_items
$Payqr->objectOrder->setOrderId($order_id);

//проверяем в каком контексте был приобретен товар
if(isset($uData->page) && in_array($uData->page, array('category', 'product')))
{
	//корзину не будем очищать, пропускаем данную ветку
}
else 
{
	//производим очистку корзины
}

$userdata = array(
    "user_id" => $user_id,
    "session_id" => "session"/*$uData->session_id*/,
    "order_id" => $order_id,
    "amount" => $amount,
    "message" => (isset($config['payqr_user_message_text'])? $config['payqr_user_message_text'] : ""),
    "messageImageURL" => (isset($config['payqr_user_message_imageurl'])? $config['payqr_user_message_imageurl'] : ""),
    "messageURL" => (isset($config['payqr_user_message_url'])? $config['payqr_user_message_url'] : "")
);

$Payqr->objectOrder->setUserData(json_encode($userdata));