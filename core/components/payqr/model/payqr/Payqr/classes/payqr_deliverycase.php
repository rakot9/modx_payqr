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
        $result = $this->modx->query("SELECT value, xtype FROM ". $this->modx->getOption('table_prefix') ."shopkeeper3_config WHERE setting='delivery'");
        
        if (!is_object($result)) {
            return array();
        }
        
        $row = $result->fetch(PDO::FETCH_ASSOC);
        
        $delivery_json = $row['value'];
        
        if(!empty($delivery_json) && $row['xtype'] == 'array')
        {
            return json_decode( $delivery_json, true );
        }
        
        return array();
    }
} 