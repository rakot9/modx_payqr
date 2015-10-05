<?php
/**
 * Формирование способов доставки в ответе на уведомление invoice.deliverycases.updating
 */

class payqr_deliverycase {
  
    private $modx;
    
    public function __construct(modX $modx)
    {
        $this->modx =& $modx;
    }
    
    /**
     * 
     * @return array
     */
    public function getDeliveryCases()
    {
        $query = $this->modx->newQuery( 'shk_config' );
        
        if( !empty( $settings ) ){
            $query->where( array( "setting" => 'delivery' ) );
        }
        $config = $this->modx->getIterator( 'shk_config', $query );
        
        if( !empty( $config ) ){
            
            foreach( $config as $key => $conf ){
                
                if( $conf->xtype == 'array' ){
                    $config_value = json_decode( $conf->value, true );
                }else{
                    $config_value = $conf->value;
                }
            }
        }
        
        return $config_value;
    }
} 