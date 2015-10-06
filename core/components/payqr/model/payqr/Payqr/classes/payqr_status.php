<?php
/**
 * @author payqr
 */
class payqr_status {

    private static $modx;
    
    private static $instance;
    
    public function __construct() {}
    
    public static function getInstance(modX $modx)
    {
        self::$modx = $modx;
        
        if(isset(self::$instance) && self::$instance instanceof payqr_status)
        {
            return self::$instance;
        }
        else
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * 
     * @param type $status
     * @return null|int
     */
    public function getStatusId($status_name, $encoding = "UTF")
    {
        $result = self::$modx->query("SELECT value, xtype FROM ".self::$modx->getOption('table_prefix')."shopkeeper3_config WHERE setting='statuses'");
        
        if(is_object($result))
        {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            
            if($row['xtype'] == "array")
            {
                $statuses = json_decode($row['value'], true);
                
                foreach($statuses as $status)
                {
                    if($status['label'] == $status_name)
                    {
                        return $status['id'];
                    }
                }
            }
            
            return null;
        }
        
        return null;
    }
}
