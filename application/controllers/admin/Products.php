<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Admin_Controller {

    protected  $path_list_view = 'admin/list';
    protected $path_form_view = 'admin/products/form';
    public $actions = ['edit', 'delete'];
    private $file_data;

    public function initialize()
    {
        // load the language files
        $this->lang->load(['products', 'categories']);

        // load the categories model
        $this->load->model(['products_model', 'categories_model']);

        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/products'));
        
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
            '',
            'name',
            'price'
        ];
    }
    
    protected function apply_filters()
    {
        return [
            '',
            '',
            'name',
            'price'
        ];
    }
    
    protected function get_model()
    {
        return $this->products_model;
    }

    public function get_identifier()
    {
        return 'products';
    }
    /**
     * User list page
     */
    function index()
    {
        
        $this->js_files = 'products_i18n.js';
        $this->page_title = lang('products title list');
        $this->add_column('id');
        $this->add_column('image');
        $this->add_column('name');
        $this->add_column('price');
        $this->set_content_data(['image_col' => 'image']);
        $this->set_add_link('admin/products/add');
        
        parent::index();
    }
    
    function add($id = null)
    {
        $this->form_validation->set_rules('category_id', lang('products input category'), 'required|trim');
        
        $this->form_validation->set_rules('name', lang('products input name'), 'required|trim|min_length[5]|max_length[30]|callback__check_name[]');
        $this->form_validation->set_rules('description', lang('products input description'), 'required|trim|alpha_numeric_spaces');
        if(empty($id))
        {
            $this->form_validation->set_rules('image', lang('products input image'), 'callback_file_selected_test');
        }
        $this->form_validation->set_rules('quantity', lang('products input quantity'), 'required|trim|integer');
        $this->form_validation->set_rules('price', lang('products input price'), 'required|trim|decimal');
        
        $categories = $this->categories_model->get_by_fields(['deleted' => 0, 'parent_id' => 0])->result_array();
        
        $category_dropdown[''] =  '--' . lang('categories input choose_category') . '--';
        foreach($categories as $cat)
        {
            
            $sub_categories = $this->categories_model->get_by_fields(['deleted' => 0, 'parent_id' => $cat['id']])->result_array();
            foreach($sub_categories as $subcat)
            {
                $category_dropdown[$cat['name']][$subcat['id']] = $subcat['name'];
            }
        }
        $this->set_content_data([
            'category' =>$category_dropdown
        ]);
        
        parent::add($id);
        
    }
    public function saved($saved, $update = false)
    {
        $this->products_model->edit(['image' => $this->file_data['file_name'], 'id' => $saved]);
        parent::saved($saved);
    }
    
    function file_selected_test()
    {
        
        if (empty($_FILES['image']['name']))
        {
            $this->form_validation->set_message('file_selected_test', 'Please select file.');
            return false;
        }
        else
        {
            $this->load->library('upload');

            if (!empty($_FILES['image']['name']))
            {
                $config['upload_path']   = './uploads/';
                $config['allowed_types'] = '*';   //@TODO
                $config['encrypt_name'] = true;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('image'))
                {
                    $this->file_data = $this->upload->data();
                    return true;
                }
                else
                {
                    $this->form_validation->set_message('file_selected_test', $this->upload->display_errors());
                    exit;
                }
            }
            return true;
        }
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
        $data['saved_product'] = $this->products_model->get_by_id($id);
        //echo '<pre>';print_r($data); exit;
        $this->set_content_data($data);
        
        $this->add($id);
        //redirect($this->_redirect_url);
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
        if (trim($name) != trim($current) && $this->products_model->exists($name))
        {
            $this->form_validation->set_message('_check_name', sprintf(lang('products error products_exists'), $name));
            return FALSE;
        }
        else
        {
            return $name;
        }
    }

}
