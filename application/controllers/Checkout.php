<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends Private_Controller
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // load the language file
        $this->lang->load(['carts', 'users', 'checkout']);
        $this->load->model(['carts_model', 'products_model', 'orders_model']);
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('/checkout'));
        
        $this->_redirect_url = THIS_URL;
        
        $empty_cart = $this->carts_model->is_cart_empty();
        if($empty_cart)
        {
            redirect('/');
        }
    }

    
    /**
     * Default
     */
    function index()
    {
        
        // setup page header data
        $this->set_title('Order Review');

        $data = $this->includes;
        
        $content_data = array(
          
            'cart_items' => $this->carts_model->get_cart_items(),
            
        );
        //echo '<pre>'; print_r($content_data); exit;
        // load views
        $data['content'] = $this->load->view('checkout/review', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    
    function step2()
    {
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('email', lang('users input email'), 'required|trim|max_length[256]|valid_email');
        $this->form_validation->set_rules('mobile', lang('users input mobile'), 'required|trim|max_length[10]');
        $this->form_validation->set_rules('address', lang('users input address'), 'required|trim|max_length[256]');
        $this->form_validation->set_rules('city', lang('users input city'), 'required|trim|max_length[256]');
        $this->form_validation->set_rules('state', lang('users input state'), 'required|trim|max_length[256]');
        $this->form_validation->set_rules('pincode', lang('users input pincode'), 'required|trim|max_length[6]|integer');
        
        if ($this->form_validation->run() == TRUE)
        {
            
            // save the changes
            $this->session->set_userdata('clear_step2', 'true');
            $this->session->set_userdata('address', $this->input->post());
            

            // redirect home and display message
            redirect('/checkout/step3');
        }
        // setup page header data
        $this->set_title('Billing address & Shipping Address');

        $data = $this->includes;
        $user = $this->session->userdata('logged_in');
        $content_data    = [
            'user' => [
                'address' => $user['address'],
                'email'   => $user['email'],
                'mobile'  => $user['mobile'],
                'city'    => $user['city'],
                'state'   => $user['state'],
                'pincode' => $user['pincode']
            ]
        ];
        //echo '<pre>'; print_r($content_data); exit;
        // load views
        $data['content'] = $this->load->view('checkout/step2', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    
    function step3()
    {
        if($this->session->userdata('clear_step2') !== 'true')
        {
            redirect('/checkout/step2');
        }
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('option', 'Payment Options', 'required|in_list[cod,nb,dc,cc]');
        if ($this->form_validation->run() == TRUE)
        {
             $this->session->set_userdata('clear_step3', true);
            // save the changes
            $this->orders_model->place_order($this->input->post());
            
            $this->session->unset_userdata('address');

            // redirect home and display message
            redirect('/checkout/thankyou');
        }
        // setup page header data
        $this->set_title('Payment Option');

        $data = $this->includes;
        $content_data    = [
            'payment_options' => [
                'cod' => 'Cash On Delivery'
            ]
        ];
        //echo '<pre>'; print_r($content_data); exit;
        // load views
        $data['content'] = $this->load->view('checkout/step3', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    
    function thankyou()
    {
        if(!$this->session->userdata('clear_step3'))
        {
            redirect('/checkout/step3');
        }
        $this->set_title('Thank You for shopping with use');
        // build email
        $email_msg  = lang('core email start');
        $email_msg .= sprintf(lang('checkout email order_placed'), $this->settings->site_name);
        $email_msg .= lang('core email end');

        // send email
        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail -f' . $this->settings->site_email;
        $this->email->initialize($config);
        $this->email->clear();
        $this->email->from($this->settings->site_email, $this->settings->site_name);
        $this->email->reply_to($this->settings->site_email, $this->settings->site_name);
        $logged_in_user = $this->session->userdata('logged_in');
        $this->email->to($logged_in_user['email']);
        $this->email->subject('Order Placed');
        $this->email->message('Thanks for placing the order with us. We will server you shortly');
        $this->email->send();
        $this->carts_model->empty_cart();
        
        $data = $this->includes;
        $data['content'] = $this->load->view('checkout/thankyou', [], TRUE);
        $this->load->view($this->template, $data);
    }
    
}
