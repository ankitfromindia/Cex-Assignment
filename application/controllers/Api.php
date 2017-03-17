<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends API_Controller {

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Default
     */
    public function index()
    {
        $this->lang->load('core');
        $results['error'] = lang('core error no_results');
        display_json($results);
        exit;
    }


    /**
     * Users API - DO NOT LEAVE THIS ACTIVE IN A PRODUCTION ENVIRONMENT !!! - for demo purposes only
     */
    public function users()
    {
        // load the users model and admin language file
        $this->load->model('users_model');
        $this->lang->load('admin');

        // get user data
        $users = $this->users_model->get_all();
        $results['data'] = NULL;

        if ($users)
        {
            // build usable array
            foreach($users['results'] as $user)
            {
                $results['data'][$user['id']] = array(
                    'name'   => $user['first_name'] . " " . $user['last_name'],
                    'email'  => $user['email'],
                    'status' => ($user['status']) ? lang('admin input active') : lang('admin input inactive')
                );
            }
            $results['total'] = $users['total'];
        }
        else
            $results['error'] = lang('core error no_results');

        // display results using the JSON formatter helper
        display_json($results);
        exit;
    }
    
    public function orders()
    {
        $this->load->model(['orders_model', 'order_items_model']);
        define('DEFAULT_LIMIT', $this->settings->per_page_limit);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "created");
        define('DEFAULT_DIR', "desc");
        $limit  = $this->input->get('limit') ? $this->input->get('limit', TRUE) : DEFAULT_LIMIT;
        $offset = $this->input->get('offset') ? $this->input->get('offset', TRUE) : DEFAULT_OFFSET;
        $sort   = $this->input->get('sort') ? $this->input->get('sort', TRUE) : DEFAULT_SORT;
        $dir    = $this->input->get('dir') ? $this->input->get('dir', TRUE) : DEFAULT_DIR;

        // get filters
        $filters = array();

        foreach (['billing_email',
            'billing_mobile',
            'billing_city',
            'billing_state',
            'order_total',
            'created'] as $filter)
        {
            if ($this->input->get($filter))
            {
                $filters[$filter] = $this->input->get($filter, TRUE);
            }
        }
        // build filter string
        $filter = "";

        foreach ($filters as $key => $value)
        {
            $filter .= "&{$key}={$value}";
        }
        $results = $this->orders_model->get_all($limit, $offset, $filters, $sort, $dir);
        display_json($results);
        exit;
        
    }

}
