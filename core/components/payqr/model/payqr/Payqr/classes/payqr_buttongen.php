<?php

/**
 * Description of payqr_buttonge
 *
 * @author PayQR
 */
class payqr_buttongen {
    
    private static $instance;
    private $config;
    private $page;
    private $payqrButton;
    private $allowed_pages = array("cart", "product", "category");
    
    
    /**
     * 
     * @return type
     */
    public static function getInstance()
    {
        if(isset(self::$instance) && self::$instance instanceof payqr_buttongen)
        {
            return self::$instance;
        }
        return self::$instance = new self();
    }
    
    private function __wakeup(){}
    
    private function __clone(){}
    
    protected function __construct() {}
    
    /**
     * Устанавливаем страницу, на которой отображем кнопку
     * @param type $page
     */
    public function setPage($page)
    {
        $this->page = $page;
        
        return $this;
    }
    
    /**
     * 
     * @param payqr_button $payqrButton
     * @return string
     */
    public function genereateButton(payqr_button $payqrButton)
    {
        $this->config = $payqrButton->getPayqrItems();
        
        $this->payqrButton = $payqrButton;
        
        if(!isset($this->config['merchant_id'], $this->config['secret_key_in'], $this->config['secret_key_out']) ||
            (empty($this->config['merchant_id']) && empty($this->config['secret_key_in']) && empty($this->config['secret_key_out']) ))
        {
            return "";
        }
        
        if(!in_array($this->page, $this->allowed_pages))
        {
            return "";
        }
        
        if(!$this->setPageButtonParam())
        {
            return "";
        }
        
        return $this->payqrButton->getHtmlButton();
    }
    
    private function setPageButtonParam()
    {
        if( !isset($this->config['button_show_on_' . $this->page]) || 
                (isset($this->config['button_show_on_' . $this->page]) && 
                    (empty($this->config['button_show_on_' . $this->page]) || 
                     'no' == trim($this->config['button_show_on_' . $this->page]))
                ) 
          )
        {
            return false;
        }
        
        //устанавливаем переключатели запрашиваемой информации
        $this->payqrButton->firstname_required = $this->config['require_firstname'];
        $this->payqrButton->lastname_required = $this->config['require_lastname'];
        $this->payqrButton->middlename_required = $this->config['require_middlename'];
        $this->payqrButton->phone_required = $this->config['require_phone'];
        $this->payqrButton->email_required = $this->config['require_email'];
        $this->payqrButton->delivery_required = $this->config['require_delivery'];
        $this->payqrButton->deliverycases_required = $this->config['require_deliverycases'];
        $this->payqrButton->pickpoints_required = $this->config['require_pickpoints'];
        $this->payqrButton->promocode_required = $this->config['require_promo_code'];
        $this->payqrButton->promocard_required = $this->config['require_promo_card'];
        //
        
        $this->payqrButton->setUserData(json_encode($this->payqrButton->productsArray));       
        $this->payqrButton->setWidth($this->config[ $this->page . '_button_width']);
        $this->payqrButton->setHeight($this->config[ $this->page . '_button_height']);
        $this->payqrButton->setColor($this->config[ $this->page . '_button_color']);
        $this->payqrButton->setBorderRadius($this->config[ $this->page . '_button_form']);
        $this->payqrButton->setGradient($this->config[ $this->page . '_button_gradient']);
        $this->payqrButton->setFontSize($this->config[ $this->page . '_button_font_trans']);
        $this->payqrButton->setFontWeight($this->config[ $this->page . '_button_font_width']);
        $this->payqrButton->setTextTransform($this->config[ $this->page . '_button_text_case']);
        $this->payqrButton->setShadow($this->config[ $this->page . '_button_shadow']);
        $this->payqrButton->setMessageText($this->config['user_message_text']);
        $this->payqrButton->setMessageImageUrl($this->config['user_message_imageurl']);
        $this->payqrButton->setMessageUrl($this->config['user_message_url']);
        
        return true;
    }
}
