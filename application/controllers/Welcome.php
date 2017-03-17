<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Public_Controller
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // load the language file
        $this->lang->load(['welcome', 'admin']);
        $this->load->model('products_model');
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('/'));
        
        define('DEFAULT_LIMIT', $this->settings->per_page_limit);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "name");
        define('DEFAULT_DIR', "asc");
        
        $this->_redirect_url = THIS_URL;
    }

    protected function get_filters()
    {
        return [
            'name',
            'price'
        ];
    }
    /**
     * Default
     */
    function index()
    {
        // setup page header data
        $this->set_title(sprintf(lang('welcome title'), $this->settings->site_name));

        $data = $this->includes;


        $limit  = $this->input->get('limit') ? $this->input->get('limit', TRUE) : DEFAULT_LIMIT;
        $offset = $this->input->get('offset') ? $this->input->get('offset', TRUE) : DEFAULT_OFFSET;
        $sort   = $this->input->get('sort') ? $this->input->get('sort', TRUE) : DEFAULT_SORT;
        $dir    = $this->input->get('dir') ? $this->input->get('dir', TRUE) : DEFAULT_DIR;

        // get filters
        $filters = array();

        foreach ($this->get_filters() as $filter)
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

        // save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");

        // are filters being submitted?
        if ($this->input->post())
        {
            if ($this->input->post('clear'))
            {
                // reset button clicked
                redirect(THIS_URL);
            }
            else
            {
                // apply the filter(s)
                $filter = "";
                foreach (['name'] as $apply_filter)
                {
                    if ($this->input->post($apply_filter))
                    {
                        $filter .= "&$apply_filter=" . $this->input->post($apply_filter, TRUE);
                    }
                }

                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
        }

        // get list
        $model = $this->products_model->get_all($limit, $offset, $filters, $sort, $dir);

        // build pagination
        $this->pagination->initialize(array(
            'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
            'total_rows' => $model['total'],
            'per_page'   => $limit
        ));
        
        $content_data = array(
            'welcome_message' => $this->settings->welcome_message[$this->session->language],
            'this_url'   => THIS_URL,
            'result'     => $model['results'],
            'total'      => $model['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
            
            
        );
        // load views
        $data['content'] = $this->load->view('welcome', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

}
