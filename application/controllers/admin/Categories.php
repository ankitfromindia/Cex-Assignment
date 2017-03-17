<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends Admin_Controller {

    protected  $path_list_view = 'admin/list';
     public $actions = ['edit', 'delete'];

    public function initialize()
    {
        // load the language files
        $this->lang->load('categories');

        // load the categories model
        $this->load->model('categories_model');

        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/categories'));
        
        define('DEFAULT_LIMIT', $this->settings->per_page_limit);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "name");
        define('DEFAULT_DIR', "asc");
        
        $this->_redirect_url = THIS_URL;
    }

    /**************************************************************************************
     * PUBLIC FUNCTIONS
     **************************************************************************************/

    protected function get_filters()
    {
        return [
            'name'
        ];
    }
    
    protected function apply_filters()
    {
        return [
            '',
            'name'
            
        ];
    }
    
    protected function get_model()
    {
        return $this->categories_model;
    }

    public function get_identifier()
    {
        return 'categories';
    }
    /**
     * User list page
     */
    function index()
    {
        $this->js_files = 'categories_i18n.js';
        $this->page_title = lang('categories title list_cat');
        
        $this->add_column('id');
        $this->add_column('name');
        $this->set_add_link('admin/categories/add');
        parent::index();
    }


    /**
     * Add new user
     */
    function add()
    {
        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('name', lang('categories input name'), 'required|trim|min_length[5]|max_length[30]|callback__check_name[]');
        
        if ($this->form_validation->run() == TRUE)
        {
            // save the new user
            $saved = $this->categories_model->add_category($this->input->post());

            if ($saved)
            {
                $this->session->set_flashdata('message', lang('categories msg add_success'));
            }
            else
            {
                $this->session->set_flashdata('error', lang('categories msg add_failed'));
            }
            // return to list and display message
            redirect($this->_redirect_url);
        }

        // setup page header data
        $this->set_title(lang('categories title add'));

        $data = $this->includes;
        
        $all_categories = $this->categories_model->get_by_fields(['deleted' => 0, 'parent_id' => 0])->result_array();
        
        $parent_category_array['0'] =  '--' . lang('categories input parent') . '--';
        
        foreach($all_categories as $cat)
        {
            $parent_category_array[$cat['id']] = $cat['name'];
        }
        // set content data
        $content_data = array(
            'cancel_url'        => $this->_redirect_url,
            'category'          => $parent_category_array,
        );

        // load views
        $data['content'] = $this->load->view('admin/categories/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }


    /**
     * Edit existing user
     *
     * @param  int $id
     */
    function edit($id = NULL)
    {
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $category = $this->categories_model->get_category($id);

        // if empty results, return to list
        if ( ! $category)
        {
            redirect($this->_redirect_url);
        }

        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('name', lang('categories input name'), 'required|trim|min_length[5]|max_length[30]|callback__check_name[' . $category['name'] . ']');
       
        if ($this->form_validation->run() == TRUE)
        {
            // save the changes
            $saved = $this->categories_model->edit_category($this->input->post());
           

            if ($saved)
            {
                $this->session->set_flashdata('message', sprintf(lang('categories msg edit_category_success'), $this->input->post('name')));
            }
            else
            {
                $this->session->set_flashdata('error', sprintf(lang('categories error edit_category_failed'), $this->input->post('name')));
            }

            // return to list and display message
            redirect($this->_redirect_url);
        }

        // setup page header data
        $this->set_title( lang('categories title edit_category') );

        $data = $this->includes;
        $all_categories = $this->categories_model->get_by_fields(['deleted' => 0, 'parent_id' => 0]);
        
        $parent_category_array['0'] =  '--' . lang('categories input parent') . '--';
        foreach($all_categories as $cat)
        {
            $parent_category_array[$cat['id']] = $cat['name'];
        }
        //print_r($category); exit;
        // set content data
        $content_data = array(
            'cancel_url'        => $this->_redirect_url,
            'category'              => $parent_category_array,
            'category_id'           => $id,
            'saved_category'        => $category,
                
        );
        
        // load views
        $data['content'] = $this->load->view('admin/categories/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }


    /**************************************************************************************
     * PRIVATE VALIDATION CALLBACK FUNCTIONS
     **************************************************************************************/


    /**
     * Make sure username is available
     *
     * @param  string $name
     * @param  string|null $current
     * @return int|boolean
     */
    function _check_name($name, $current)
    {
        if (trim($name) != trim($current) && $this->categories_model->category_exists($name))
        {
            $this->form_validation->set_message('_check_name', sprintf(lang('categories error category_exists'), $name));
            return FALSE;
        }
        else
        {
            return $name;
        }
    }

}
