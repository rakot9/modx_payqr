<?php

if(!defined('SHOPKEEPER_PATH')){
    define('SHOPKEEPER_PATH', MODX_CORE_PATH."components/shopkeeper3/");
}

/**
 * The base class for payqr.
 */
class payqr {
	/* @var modX $modx */
	public $modx;

	private $merchantId;

	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('payqr_core_path', $config, $this->modx->getOption('core_path') . 'components/payqr/');
		$assetsUrl = $this->modx->getOption('payqr_assets_url', $config, $this->modx->getOption('assets_url') . 'components/payqr/');
		$connectorUrl = $assetsUrl . 'connector.php';

		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			'cssUrl' => $assetsUrl . 'css/',
			'jsUrl' => $assetsUrl . 'js/',
			'imagesUrl' => $assetsUrl . 'images/',
			'connectorUrl' => $connectorUrl,

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'templatesPath' => $corePath . 'elements/templates/',
			'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath . 'elements/snippets/',
			'processorsPath' => $corePath . 'processors/'
		), $config);

		$this->modx->addPackage('payqr', $this->config['modelPath']);
		$this->modx->lexicon->load('payqr:default');

		$this->merchantId = $this->getMerchant();
	}
               
        public function getProductsData($page, $productsIds = array())
        {
            $productsData = array();
            
            if(in_array($page, array("category", "product")))
            {
                if(empty($productsIds))
                {
                    return array();
                }
                $criteria = $this->modx->newQuery('ShopContent');
            
                $criteria->where(array('id:IN' => $productsIds));

                $items = $this->modx->getIterator('ShopContent', $criteria);
                
                foreach($items as $item)
                {
                    $productsData[] = array(
                        "article" => $item->id,
                        "name" => $item->pagetitle,
                        "imageUrl" => "http://" .  $_SERVER['SERVER_NAME'] . (defined('MODX_ASSETS_URL')? MODX_ASSETS_URL : '/assets' ) . '/' . $item->image,
                        "quantity" => 1,
                        "amount" => $item->price
                    );
                }
                return $productsData;
            }
            if(in_array($page, array("cart")))
            {
                //Определяем параметры сниппета Shopkeeper
                $sys_property_sets = $this->modx->getOption( 'shk3.property_sets', $this->modx->config, 'default' );
                $sys_property_sets = explode( ',', $sys_property_sets );
                $propertySetName = trim( current( $sys_property_sets ) );

                $snippet = $this->modx->getObject('modSnippet',array('name'=>'Shopkeeper3'));
                $properties = $snippet->getProperties();
                if( $propertySetName != 'default' && $this->modx->getCount( 'modPropertySet', array( 'name' => $propertySetName ) ) > 0 ){
                    $propSet = $this->modx->getObject( 'modPropertySet', array( 'name' => $propertySetName ) );
                    $propSetProperties = $propSet->getProperties();
                    if(is_array($propSetProperties)) $properties = array_merge($properties,$propSetProperties);
                }

                $lang = $this->modx->getOption( 'lang', $properties, 'ru' );
                $this->modx->getService( 'lexicon', 'modLexicon' );
                $this->modx->lexicon->load( $lang . ':shopkeeper3:default' );

                if( !empty( $_SESSION['shk_order'] ) ){

                    require_once SHOPKEEPER_PATH . "model/shopkeeper.class.php";

                    $shopCart = new Shopkeeper( $this->modx, $properties );

                    $purchasesData = $shopCart->getProductsData( true );
                    
                    $_tmp_purchasesData = array();
                    
                    foreach( $shopCart->data as $p_data )
                    {
                        $_tmp_purchasesData[$p_data['id']] =  array("price" => $p_data['price'], "quantity" => $p_data['count']);
                    }

                    foreach($purchasesData as $cartItem)
                    {
                        $productsData[] = array(
                            "article" => $cartItem['id'],
                            "name" => $cartItem['pagetitle'],
                            "imageUrl" => "http://" .  $_SERVER['SERVER_NAME'] . (defined('MODX_ASSETS_URL')? MODX_ASSETS_URL : '/assets' ) . '/' . $cartItem['image'],
                            "quantity" => isset($_tmp_purchasesData[$cartItem['id']])? $_tmp_purchasesData[$cartItem['id']]["quantity"] : 1,
                            "amount" => (isset($_tmp_purchasesData[$cartItem['id']])? $_tmp_purchasesData[$cartItem['id']]["quantity"] :1) * $cartItem['price']
                        );
                    }
                }
                return $productsData;
            }
        }
        
        /**
         * Возвращает merchantId магазина
         * @return type
         */
	private function getMerchant()
	{
		$merchantId = null;

		$criteria = $this->modx->newQuery('payqrItem');

		$criteria->limit(1);

		$criteria->where(array('name' => 'merchant_id'));

		$items = $this->modx->getIterator('payqrItem', $criteria);

		foreach($items as $item)
		{
			$merchantId = $item->htmlvalue;
		}

		return $merchantId;
	}

        public function initPopupJS()
        {
            $this->modx->regClientStartupScript('https://payqr.ru/popup.js?merchId=' . $this->merchantId );
            $this->modx->regClientStartupScript( $this->modx->config['assets_url'] . 'components/payqr/js/mgr/payqr_order.js' );
        }
}