<?php

if(isset($config, $config['status_cancelled']))
{
	$order_id = $Payqr->objectOrder->getOrderId();
        
        if(empty($order_id))
        {
            return false;
        }

        $status_cancelled = payqr_status::getInstance($modx)->getStatusId($config['status_cancelled']);
        
        if(empty($status_cancelled))
        {
            return false;
        }
        
        $payqrOrder = new payqr_order($modx, $Payqr);
        
        $payqrOrder->changeStatus($order_id, $status_cancelled);
}