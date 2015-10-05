<?php

if(!defined('SHOPKEEPER_PATH')){
    define('SHOPKEEPER_PATH', MODX_CORE_PATH."components/shopkeeper3/");
}

class payqr_order {

    private $modx;
    private $Payqr;
    
    /**
     * 
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
    
    private function setPayqr($Payqr)
    {
        $this->Payqr = $Payqr->objectOrder;
    }
    
    private function getPayqr()
    {
        return $this->Payqr;
    }
    
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
            $result = $this->modx->query("SELECT * FROM modx_shop_content WHERE id=" . stripcslashes($product->article));
            
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
     * @param type $contacts
     */
    public function createShopkeeper3Order( $userId = 0, $contacts = array())
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

            $contacts = json_encode( $contacts );
            
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
                'contacts' => $contacts,
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
    
    public function getTotal()
    {
        $productsData = $this->getPayqr()->getCart();
        
        $total = 0;
        
        foreach($productsData as $product)
        {
            //получаем информацию о товаре
            $result = $this->modx->query("SELECT * FROM ". $this->getModX()->db->config['table_prefix'] ."shop_content WHERE id=" . stripcslashes($product->article));
            
            if (is_object($result)) 
            {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $total+= $row['price'] * $product->quantity;
            }
        }
        return $total;
    }
}