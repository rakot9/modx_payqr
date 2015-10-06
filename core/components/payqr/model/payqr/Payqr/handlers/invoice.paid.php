<?php

if(isset($config, $config['status_paid']))
{
	$order_id = $Payqr->objectOrder->getOrderId();
        
        if(empty($order_id))
        {
            return false;
        }

        $status_paid = payqr_status::getInstance($modx)->getStatusId($config['status_paid']);
        
        if(empty($status_paid))
        {
            return false;
        }
        
        $payqrOrder = new payqr_order($modx, $Payqr);
        
        $payqrOrder->changeStatus($order_id, $status_paid);
}