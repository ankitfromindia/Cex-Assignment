<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Products_model
 *
 * @author ankitvishwakarma
 */
class Carts_model extends MY_Model
{
   protected $_db = 'carts';
   
   protected $fillable = ['product_id', 'customer_id', 'price', 'quantity', 'session_key', 'added', 'updated'];
   
   public function __construct()
   {
       parent::__construct();
       $this->load->model(['products_model']);
   }
  
   
   public function in_stock($product_id)
   {
       return $this->db->get_where('products', ['id' => $product_id])->row_array();
   }
   
   public function add_to_cart($product_id, $quantity = 1)
   {
       
        $product_info = $this->products_model->get_by_id($product_id);
        if(empty($product_info))
        {
            return false;
        }
        $logged_in_user = [];
        if ($this->session->userdata('logged_in'))
        {
            $logged_in_user = $this->session->userdata('logged_in');
            $cart_product = $this->get_by_fields(['product_id' => $product_id, 'customer_id' => $logged_in_user['id']])->row_array();
            $where = ['product_id' => $product_id, 'customer_id' => $logged_in_user['id']];
        }
        else
        {
            $cart_product = $this->get_by_fields(['product_id' => $product_id, 'session_key' => session_id()])->row_array();
            $where = ['product_id' => $product_id, 'session_key' => session_id()];
        }
       
       if($cart_product)
       {
           
           
           $this->edit([
               'quantity' => $cart_product['quantity'] + $quantity,
               'updated' => date('Y-m-d H:i:s')
                ], $where);
       }
       else
       {
           $cart_entry = [
                'product_id' => $product_id,
                'quantity' => $quantity,
                'price' => $product_info['price'],
                'session_key' => session_id(),
                'customer_id' => isset($logged_in_user['id']) ? $logged_in_user['id'] : null,
                'added' => date('Y-m-d H:i:s')
    
        ];
        if ($this->session->userdata('cart_count') > 0)
            {
                $this->session->set_userdata('cart_count', $this->session->userdata('cart_count') + 1);
            }
            else
            {
                $this->session->set_userdata('cart_count', 1);
            }
        return $this->add($cart_entry);
           
       }
       
   }
   /**
    * merge session once logged in 
    */
   public function merge()
    {
        $logged_in_user = [];
        if ($this->session->userdata('logged_in'))
        {
            $logged_in_user = $this->session->userdata('logged_in');


            //already added products : when he was logged in

            $old_products = $this->get_by_fields(['customer_id' => $logged_in_user['id']])->result_array();

            $current_products = $this->get_by_fields(['session_key' => session_id()])->result_array();

            $this->delete(['customer_id' => $logged_in_user['id']]);
            $this->delete(['session_key' => session_id()]);
            
            foreach ($old_products as $op)
            {
                $this->add_to_cart($op['product_id'], $op['quantity']);
            }
            foreach ($current_products as $cp)
            {
                $this->add_to_cart($cp['product_id'], $cp['quantity']);
            }
        }
    }
    
    
    public function get_cart_items($product_id = null)
    {
        if($product_id)
        {
            $this->db->where('product_id', $product_id);
        }
        //if logged in
        if ($this->session->userdata('logged_in'))
        {
            $logged_in_user = $this->session->userdata('logged_in');
            $items = $this
                    ->db
                    ->select('products.name,products.image, carts.*')
                    ->join('products', 'products.id = product_id', 'left')
                    ->get_where($this->_db, ['customer_id' => $logged_in_user['id']])->result_array();

        }
        else
        {
            $items = $this
                    ->db
                    ->select('products.name,products.image, carts.*')
                    ->join('products', 'products.id = product_id', 'left')
                    ->get_where($this->_db, ['session_key' => session_id()])->result_array();

        }
        
        $total = 0;
        foreach($items as $item)
        {
            $total += $item['quantity']*$item['price'];
        }
        
        return [
            'items' => $items,
            'total' => $total
        ];
    }
    
    public function empty_cart()
    {
        $logged_in_user = $this->session->userdata('logged_in');
        $this->db->delete($this->_db, ['customer_id' => $logged_in_user['id']]);
    }
    
    public function is_cart_empty()
    {
        $logged_in_user = $this->session->userdata('logged_in');
        $rec = $this->get_by_field('customer_id', $logged_in_user['id'])->row_array();
        
        return empty($rec);
    }
}
