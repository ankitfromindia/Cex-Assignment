<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * All  > PUBLIC <  AJAX functions should go in here
 *
 * CSRF protection has been disabled for this controller in the config file
 *
 * IMPORTANT: DO NOT DO ANY WRITEBACKS FROM HERE!!! For retrieving data only.
 */
class Ajax extends Private_Controller
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        
        $this->load->model(['carts_model', 'products_model', 'orders_model']);
        $logged_in_user = $this->session->userdata('logged_in');
        if ($logged_in_user['is_admin'] != 1)
        {
            die(json_encode(['status' => 'fail', 'message' => 'Not Authorized']));
        }
           
    }

    /**
     * Change session language - user selected
     */
    function set_session_language()
    {
        $language                = $this->input->post('language');
        $this->session->language = $language;
        $results['success']      = TRUE;
        echo json_encode($results);
        die();
    }
    
    function cart_add_product()
    {
        $product_id = filter_var($this->input->post('product_id'), FILTER_SANITIZE_NUMBER_INT);
        $quantity = filter_var($this->input->post('quantity'), FILTER_SANITIZE_NUMBER_INT);
        
        if($product_id && $quantity)
        {
            $in_stock = $this->products_model->in_stock($product_id, $quantity);
            $result['in_stock'] = true;
            $result['status'] = 'ok';
            $result['message'] = 'Product added';
            
            if(!$in_stock)
            {
                $result['in_stock'] = false;
                die(json_encode($result));
            }
            
            $this->carts_model->add_to_cart($product_id);
            
            
            $cart_info = $this->carts_model->get_cart_items();
            $result['item_count'] = count($cart_info['items']);
            $result['total'] = $cart_info['total'];
            $result['html'] = $this->load->view('partials/cart', $cart_info, true);
            
        }
        else
        {
            $result['in_stock'] = false;
            $result['status'] = 'fail';
            $result['message'] = 'Product not added';
        }
        
        die(json_encode($result));
        
    }
    
    function change_status()
    {
        $order_id = $this->input->post('order_id', true);
        $status = $this->input->post('status', true);
        $change = ['status' => $status, 'id' => $order_id];
        switch($status)
        {
            case 'dispatched':
                
                $change['order_dispatched_at'] = date('Y-m-d H:i:s');
                break;
            case 'delivered':
                $change['order_delivered_at'] = date('Y-m-d H:i:s');
                break;
            
        }
        $this->orders_model->edit($change);
        die(json_encode(['status' => 'ok']));
    }

}
