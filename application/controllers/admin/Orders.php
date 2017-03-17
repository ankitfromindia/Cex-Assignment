<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Admin_Controller {

    protected  $path_list_view = 'admin/list';
    protected $path_form_view = 'admin/orders/form';
    public $actions = ['view'];
    public $add_new = false;
    
    protected $path_detail_view = 'admin/orders/view';

    public function initialize()
    {
        // load the language files
        $this->lang->load('orders');

        // load the categories model
        $this->load->model(['orders_model', 'categories_model', 'order_items_model']);

        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/orders'));
        
        define('DEFAULT_LIMIT', $this->settings->per_page_limit);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "created");
        define('DEFAULT_DIR', "desc");
        
        $this->_redirect_url = THIS_URL;
    }

    /**************************************************************************************
     * PUBLIC FUNCTIONS
     **************************************************************************************/

    protected function get_filters()
    {
        return [
            'billing_email',
            'billing_mobile',
            'billing_city',
            'billing_state',
            'order_total',
            'created'
        ];
    }
    
    protected function apply_filters()
    {
        return [
            '',
            'billing_email',
            'billing_mobile',
            'billing_city',
            'billing_state',
            ''
        ];
    }
    
    protected function get_model()
    {
        return $this->orders_model;
    }

    public function get_identifier()
    {
        return 'orders';
    }
    /**
     * User list page
     */
    function index()
    {
        
        $this->js_files = 'orders_i18n.js';
        $this->page_title = lang('orders title list');
        $this->add_column('id');
        $this->add_column('billing_email');
        $this->add_column('billing_mobile');
        $this->add_column('billing_city');
        $this->add_column('billing_state');
        $this->add_column('created');
        $this->set_add_link('admin/orders/add');
        
        parent::index();
    }
    
    function view(int $id)
    {
        $this->page_title = lang('orders title view');
        $this->with($this->order_items_model, 'order_id', 'order_items');
        parent::view($id);
    }
    
    
    
    
}
