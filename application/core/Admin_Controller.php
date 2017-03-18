<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Admin Class - used for all administration pages
 */
abstract class Admin_Controller extends MY_Controller
{

    protected $path_list_view = 'admin';
    
    protected $path_form_view = 'admin';
    protected $path_detail_view = 'admin';
    
    protected $columns = [];

    protected $_redirect_url;
    
    public $actions = ['view', 'delete', 'edit'];
    
    public $add_new = true;
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // must be logged in
        if (!$this->user)
        {
            if (current_url() != base_url())
            {
                //store requested URL to session - will load once logged in
                $data = array('redirect' => current_url());
                $this->session->set_userdata($data);
            }

            redirect('login');
        }

        // make sure this user is setup as admin
        if (!$this->user['is_admin'])
        {
            redirect(base_url());
        }

        // load the admin language file
        $this->lang->load('admin');

        // prepare theme name
        $this->settings->theme = strtolower($this->config->item('admin_theme'));

        // set up global header data
        $this
                ->add_css_theme("{$this->settings->theme}.css,summernote-bs3.css")
                ->add_js_theme("summernote.min.js")
                ->add_js_theme("{$this->settings->theme}_i18n.js", TRUE);

        // declare main template
        $this->template = "../../{$this->settings->root_folder}/themes/{$this->settings->theme}/template.php";

        $this->initialize();
    }

    abstract protected function initialize();

    abstract protected function get_filters();

    abstract protected function apply_filters();

    abstract protected function get_model();
    
    
    protected function add_column($col)
    {
        $this->columns[] = $col;
    }
    
    private function get_content_data()
    {
        return $this->content_data;
    }
    protected $content_data = [];
    protected function set_content_data($array = [])
    {
        $this->content_data = array_merge($this->content_data, $array);
    }
    private $add_link;
    protected function set_add_link($link)
    {
        $this->add_link = $link;
    }
    
    protected function get_columns()
    {
        return $this->columns;
    }

    protected $js_files;
    protected $page_title;
    
    function index()
    {
        // get parameters
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
                foreach ($this->apply_filters() as $apply_filter)
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
        $model = $this->get_model()->get_all($limit, $offset, $filters, $sort, $dir);

        // build pagination
        $this->pagination->initialize(array(
            'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
            'total_rows' => $model['total'],
            'per_page'   => $limit
        ));

        $this
			->add_js_theme( $this->js_files, TRUE )
			->set_title($this->page_title);
        
        $data = $this->includes;

        // set content data
        $content_data = array(
            'this_url'   => THIS_URL,
            'result'     => $model['results'],
            'total'      => $model['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir,
            'cols'       => $this->get_columns(),
            'identifier' => $this->get_identifier(),
            'filter_fields' => $this->apply_filters(),
            'add_link' => $this->add_link,
            
            
        );
        $content_data = array_merge($content_data, $this->get_content_data());
        // load views
        $data['content'] = $this->load->view($this->path_list_view, $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function adding()
    {
        
    }
    function saved($saved, $update = false)
    {
        $string = $update ? 'update' : 'add';
        
        if ($saved)
        {
            $this->session->set_flashdata('message', lang($this->get_identifier() . ' msg '.$string.'_success'));
        }
        else
        {
            $this->session->set_flashdata('error', lang($this->get_identifier() . ' msg '.$string.'_failed'));
        }
    }

    function add($id = null)
    {
        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        
        if ($this->form_validation->run() == TRUE)
        {
            
            // save the new item
            if($id)
            {
                $saved = $this->get_model()->edit($this->input->post(), ['id' => $id]);
            }
            else
            {
                $saved = $this->get_model()->add($this->input->post());
                
            }
            $this->saved($saved, empty($id) ? true : false);
            
            
            
            // return to list and display message
            redirect($this->_redirect_url);
        }
        
        $string = !empty($id) ? 'update' : 'add';
        // setup page header data
        $this->set_title(lang($this->get_identifier() . ' title '.$string));

        $data = $this->includes;
        
        
        $content_data = array_merge(['cancel_url' => $this->_redirect_url,], $this->get_content_data());
        
        // load views
        $data['content'] = $this->load->view($this->path_form_view, $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    
    
    /**
     * Delete a user
     *
     * @param  int $id
     */
    function delete($id = NULL)
    {
        // make sure we have a numeric id
        if ( ! is_null($id) OR ! is_numeric($id))
        {
            // get user details
            $item = $this->get_model()->get_by_id($id);

            if ($item)
            {
                // soft-delete the user
                $delete = $this->get_model()->remove($id);

                if ($delete)
                {
                    $this->session->set_flashdata('message', sprintf(lang($this->get_identifier() . ' msg delete'), $item['name']));
                }
                else
                {
                    $this->session->set_flashdata('error', sprintf(lang($this->get_identifier() . ' error delete'), $item['name']));
                }
            }
            else
            {
                $this->session->set_flashdata('error', lang($this->get_identifier() . ' error not_exist'));
            }
        }
        else
        {
            $this->session->set_flashdata('error', lang($this->get_identifier() .  ' error id_required'));
        }

        // return to list and display message
        redirect($this->_redirect_url);
    }
    
    protected $with;
    protected $fk;
    protected $with_key;
    public function with($model, $fk, $with_key)
    {
        $this->with = $model;
        $this->fk = $fk;
        $this->with_key = $with_key;
    }
    
    public function view(int $id)
    {
      
        if ($id)
        {
            // get user details
            $item = $this->get_model()->get_by_id($id);

            if ($item)
            {
                if($this->with && $this->fk)
                {
                    $item[$this->with_key] = $this->with->get_by_field($this->fk, $id)->result_array();
                }
            }
            else
            {
                $this->session->set_flashdata('error', lang($this->get_identifier() . ' error not_exist'));
                redirect($this->_redirect_url);
            }
        }
        else
        {
            $this->session->set_flashdata('error', lang($this->get_identifier() .  ' error id_required'));
             redirect($this->_redirect_url);
        }
        
        // setup page header data
        $this->set_title(sprintf(lang($this->get_identifier() . ' title view'), $id));

        $data = $this->includes;
        
        $content_data = array_merge(['cancel_url' => $this->_redirect_url, 'item' => $item], $this->get_content_data());

        // load views
        $data['content'] = $this->load->view($this->path_detail_view, $content_data, TRUE);
        $this->load->view($this->template, $data);
       
    }

}
