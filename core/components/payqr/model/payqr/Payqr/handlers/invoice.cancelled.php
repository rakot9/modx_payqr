<?php
/**
 * Код в этом файле будет выполнен, когда интернет-сайт получит уведомление от PayQR об отмене счета (заказа) до его оплаты.
 * Это означает, что либо вышел срок оплаты счета (заказа), либо покупатель отказался от оплаты счета (заказа), либо PayQR успешно обработал запрос в PayQR от интернет-сайта об отказе от счета (заказа) до его оплаты покупателем.
 *
 * $Payqr->objectOrder содержит объект "Счет на оплату" (подробнее об объекте "Счет на оплату" на https://payqr.ru/api/ecommerce#invoice_object)
 *
 * Ниже можно вызвать функции своей учетной системы, чтобы особым образом отреагировать на уведомление от PayQR о событии invoice.cancelled.
 *
 * Получить orderId из объекта "Счет на оплату", по которому произошло событие, можно через $Payqr->objectOrder->getOrderId();
 */