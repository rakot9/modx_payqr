<?php

if(!defined('SHOPKEEPER_PATH')){
    define('SHOPKEEPER_PATH', MODX_CORE_PATH."components/shopkeeper3/");
}

class payqr_order {

    private $modx;
    private $Payqr;

    /**
     * @param modX $modx
     */
    public function __construct(modX &$modx, payqr_invoice $Payqr)
    {
        $this->setModX($modx);
        $this->setPayqr($Payqr);
        $this->initSessionOrderData();
    }

    /**
     * @param modX $modx
     */
    private function setModX(modX $modx)
    {
        $this->modx = $modx;
    }
    /**
     * @return type
     */
    public function getModX()
    {
        return $this->modx;
    }
    
    /**
     * @param type $Payqr
     */
    private function setPayqr($Payqr)
    {
        $this->Payqr = $Payqr->objectOrder;
    }
    
    /**
     * @return type
     */
    private function getPayqr()
    {
        return $this->Payqr;
    }
    
    private function getBuyerContacts()
    {
        $cData = $this->getPayqr()->getCustomer();
        
        //Формируем информацию о покупателе
        $contacts = array();
        $FIO = "";

        if(isset($cData->lastName) && !empty($cData->lastName))
        {
            $FIO .= $cData->lastName . " ";
        }

        if(isset($cData->firstName) && !empty($cData->firstName))
        {
            $FIO .= $cData->firstName . " ";
        }

        if(isset($cData->middlename) && !empty($cData->middlename))
        {
            $FIO .= $cData->middlename;
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
        
        return json_encode($contacts, JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * Инициализируем в сессию данные о товарах из корзины 
     */
    public function initSessionOrderData()
    {
        $productsData = $this->getPayqr()->getCart();
        
        if(isset($_SESSION['shk_order']))
        {
            unset($_SESSION['shk_order']);
        }
        
        //Эмулируем сессию корзины
        foreach($productsData as $product)
        {
            $price = 0;
            
            //получаем информацию о товаре
            $result = $this->getModX()->query("SELECT * FROM ".$this->getModX()->getOption('table_prefix')."shop_content WHERE id=" . stripcslashes($product->article));
            
            if (!is_object($result)) {
                $price = 0;
            }
            else{
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $price = $row['price'];
            }
            
            //
            $_SESSION['shk_order'][] = array(
                "id" => $product->article,
                "count" => $product->quantity,
                "price" => $price,
                "name" => $product->name,
                "className" => "ShopContent",
                "packageName" => "shop",
                "options" => array(),
                "url" => "",
                "old_price" => $pData->price
            );
        }
    }
    
    /**
     * 
     * @param type $userId
     */
    public function createShopkeeper3Order( $userId = 0)
    {
        //Определяем параметры сниппета Shopkeeper
        $sys_property_sets =  $this->getModX()->config;
        $propertySetName = trim( current( $sys_property_sets ) );

        $snippet = $this->getModX()->getObject('modSnippet',array('name'=>'Shopkeeper3'));
        $properties = $snippet->getProperties();
        if( $propertySetName != 'default' && $this->getModX()->getCount( 'modPropertySet', array( 'name' => $propertySetName ) ) > 0 ){
            $propSet = $this->getModX()->getObject( 'modPropertySet', array( 'name' => $propertySetName ) );
            $propSetProperties = $propSet->getProperties();
            if(is_array($propSetProperties)) $properties = array_merge($properties,$propSetProperties);
        }

        $lang = 'ru';
        $this->getModX()->getService( 'lexicon', 'modLexicon' );
        $this->getModX()->lexicon->load( $lang . ':shopkeeper3:default' );

        if( !empty( $_SESSION['shk_order'] ) ){

            require_once SHOPKEEPER_PATH . "model/shopkeeper.class.php";
            $shopCart = new Shopkeeper( $this->getModX(), $properties );

            $this->getModX()->addPackage( 'shopkeeper3', SHOPKEEPER_PATH . 'model/' );

            $customerData = $this->getPayqr()->getCustomer();
            $emailField = isset($customerData->email)? $customerData->email : "";
            $phoneField = isset($customerData->phone)? $customerData->phone : "";
            
            //Доставка
            $delivery = $this->getPayqr()->getDeliveryCasesSelected();
            $delivery_price = isset($delivery->amountFrom)? $delivery->amountFrom : 0;
            $delivery_name = isset($delivery->name)? $delivery->name : "";

            //Сохраняем данные заказа
            
            $order = $this->getModX()->newObject('shk_order');
            
            $insert_data = array(
                'contacts' => $this->getBuyerContacts(),
                'options' => '',
                'price' => $this->getTotal(),
                'currency' => $shopCart->config['currency'],
                'date' => strftime('%Y-%m-%d %H:%M:%S'),
                'sentdate' => strftime('%Y-%m-%d %H:%M:%S'),
                'note' => '',
                'email' => $emailField,
                'delivery' => $delivery_name,
                'delivery_price' => $delivery_price,
                'payment' => 'PayQR',
                'tracking_num' => '',
                'phone' => $phoneField,
                'status' => '1'
            );
            
            if( $userId ){
                $insert_data['userid'] = $userId;
            }
            $order->fromArray($insert_data);
            $saved = $order->save();

            //Сохраняем товары заказа
            if( $saved ){

                $purchasesData = $shopCart->getProductsData( true );

                foreach( $shopCart->data as $key => $p_data ){

                    $options = !empty( $p_data['options'] ) ? json_encode( $p_data['options'] ) : '';
                    $fields_data = !empty( $purchasesData[ $key ] ) ? $purchasesData[ $key ] : array();
                    $fields_data['url'] = !empty( $p_data['url'] ) ? $p_data['url'] : '';
                    unset( $fields_data['id'] );
                    $fields_data_str = json_encode( $fields_data );

                    $insert_data = array(
                        'p_id' => $p_data['id'],
                        'order_id' => $order->id,
                        'name' => $p_data['name'],
                        'price' => $p_data['price'],
                        'count' => $p_data['count'],
                        'class_name' => 'ShopContent',
                        'package_name' => 'shop',
                        'data' => $fields_data_str,
                        'options' => $options
                    );

                    $purchase = $this->getModX()->newObject('shk_purchases');
                    $purchase->fromArray( $insert_data );
                    $purchase->save();
                }
            }
            return $order->get('id');
        }else{
            return null;
        }
    }
    
    public function updateShopkeeper3Order($order_id)
    {
        if(empty($order_id))
        {
            return false;
        }
        
        if( !empty( $_SESSION['shk_order'] ) ){

            require_once SHOPKEEPER_PATH . "model/shopkeeper.class.php";
            $shopCart = new Shopkeeper( $this->getModX(), $properties );

            $this->getModX()->addPackage( 'shopkeeper3', SHOPKEEPER_PATH . 'model/' );

            //Доставка
            $delivery = $this->getPayqr()->getDeliveryCasesSelected();
            $delivery_price = isset($delivery->amountFrom)? $delivery->amountFrom : 0;
            $delivery_name = isset($delivery->name)? $delivery->name : "";

            //Сохраняем данные заказа
            $insert_data = array(
                'contacts' => $this->getBuyerContacts(),
                'options' => '',
                'price' => $this->getTotal(),
                'currency' => $shopCart->config['currency'],
                'date' => strftime('%Y-%m-%d %H:%M:%S'),
                'sentdate' => strftime('%Y-%m-%d %H:%M:%S'),
                'note' => '',
                'email' => $emailField,
                'delivery' => $delivery_name,
                'delivery_price' => $delivery_price,
                'payment' => 'PayQR',
                'tracking_num' => '',
                'status' => '1'
            );
            
            if( $userId ){
                $insert_data['userid'] = $userId;
            }
            //производим обновление товара
            $result = $this->modxUpdate($insert_data, $this->getModX()->getOption('table_prefix')."shopkeeper3_orders", "id='".$order_id."'");
            
            if($result)
            {
                $purchasesData = $shopCart->getProductsData( true );
                
                //удаляем все старые товары из заказа
                $this->getModX()->query("DELETE FROM ". $this->getModX()->getOption('table_prefix') ."shopkeeper3_purchases WHERE order_id = " . $order_id);
                //

                foreach( $shopCart->data as $key => $p_data ){

                    $options = !empty( $p_data['options'] ) ? json_encode( $p_data['options'] ) : '';
                    $fields_data = !empty( $purchasesData[ $key ] ) ? $purchasesData[ $key ] : array();
                    $fields_data['url'] = !empty( $p_data['url'] ) ? $p_data['url'] : '';
                    unset( $fields_data['id'] );
                    $fields_data_str = json_encode( $fields_data );

                    $insert_data = array(
                        'p_id' => $p_data['id'],
                        'order_id' => $order_id,
                        'name' => $p_data['name'],
                        'price' => $p_data['price'],
                        'count' => $p_data['count'],
                        'class_name' => 'ShopContent',
                        'package_name' => 'shop',
                        'data' => $fields_data_str,
                        'options' => $options
                    );

                    $purchase = $this->getModX()->newObject('shk_purchases');
                    $purchase->fromArray( $insert_data );
                    $purchase->save();
                }
            }
            return true;
        }else{
            return null;
        }
        
    }
    
    /**
     * @param type $delivery
     * @return type
     */
    public function getTotal($delivery = false)
    {
        $productsData = $this->getPayqr()->getCart();
        
        $total = 0;
        
        foreach($productsData as $product)
        {
            //получаем информацию о товаре
            $result = $this->getModX()->query("SELECT * FROM ". $this->getModX()->getOption('table_prefix') ."shop_content WHERE id=" . stripcslashes($product->article));
            
            if (is_object($result)) 
            {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $total+= $row['price'] * $product->quantity;
            }
        }
        
        if($delivery)
        {        
            $delivery = $this->getPayqr()->getDeliveryCasesSelected();

            //проверяем доставку
            if(isset($delivery->amountFrom) && !empty($delivery->amountFrom) && $total < $delivery->amountFrom)
            {
                $total = (float)$total + (float) $delivery->amountFrom;
            }
        }
        
        return $total;
    }
    
    /**
     * @param type $orderId
     * @param type $status
     */
    public function changeStatus($orderId, $status)
    {
        $this->getModX()->query("UPDATE ". $this->getModX()->getOption('table_prefix'). "shopkeeper3_orders SET status = ".  stripcslashes($status)." WHERE id='" . stripcslashes($orderId) ."'");
    }
    
    /**
     * Проверяем, полу
     * @param type $invoice
     * @return null|int
     */
    public function checkInvoice($invoice_id)
    {
        $order_id = 0;
        
        $result = $this->getModX()->query("SELECT order_id FROM ". $this->getModX()->getOption('table_prefix'). "order_invoice WHERE invoice='". stripcslashes($invoice_id) ."'");
        
        if(is_object($result))
        {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            
            if(isset($row['order_id']) && !empty($row['order_id']))
            {
                return $row['order_id'];
            }
        }
        
        return null;
    }
    
    public function setInvoice($order_id = null, $invoice_id = null)
    {
        if(empty($order_id) || empty($invoice_id))
        {
            return false;
        }
        
        $orderInvoice = $this->getModX()->newObject('orderInvoice');
                    
        $orderInvoice->fromArray(array('order_id' => $order_id, 'invoice' => $invoice_id));
        
        $orderInvoice->save();
        
        return true;
    }
    
    private function modxUpdate($fields, $table, $where = "")
    {
        if (!$table)
            return false;
        else 
        {
            if (!is_array($fields))
            {
                $flds = $fields;
            }
            else 
            {
                $flds = '';
                foreach ($fields as $key => $value) 
                {
                    if (!empty ($flds))
                    {
                        $flds .= ",";
                    }
                    $flds .= $key . "=";
                    $flds .= "'" . $value . "'";
                }
            }
         }
         
        $where = ($where != "") ? "WHERE $where" : "";
         
        return $this->getModX()->query("UPDATE $table SET $flds $where");
    }
}