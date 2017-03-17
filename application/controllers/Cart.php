<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends Public_Controller
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // load the language file
        $this->lang->load(['carts']);
        $this->load->model(['carts_model', 'products_model']);
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('/'));
        
        define('DEFAULT_LIMIT', $this->settings->per_page_limit);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "name");
        define('DEFAULT_DIR', "asc");
        
        $this->_redirect_url = THIS_URL;
    }

    
    /**
     * Default
     */
    function index()
    {
        // setup page header data
        $this->set_title('Shopping Cart');

        $data = $this->includes;
        
        $content_data = array(
          
            'cart_items' => $this->carts_model->get_cart_items(),
            
        );
        //echo '<pre>'; print_r($content_data); exit;
        // load views
        $data['content'] = $this->load->view('cart', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

}
