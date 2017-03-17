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
class Orders_model extends MY_Model
{

    protected $_db      = 'orders';
    protected $fillable = [
        'customer_id',
        'billing_email',
        'billing_mobile',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_pincode',
        'shipping_email',
        'shipping_mobile',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_pincode',
        'order_total',
        'payment_option',
        'created',
        'order_dispatched_at',
        'order_delivered_at',
        'status'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['products_model', 'carts_model', 'order_items_model']);
    }

    public function place_order($post)
    {
        $logged_in_user = $this->session->userdata('logged_in');
        $payment_option = $this->input->post('option');

        $cart_info = $this->carts_model->get_cart_items();

        $address = $this->session->userdata('address');
        $this->db->trans_begin();
        try
        {
            $order_id = $this->add([
                'customer_id'      => $logged_in_user['id'],
                'billing_email'    => $address['email'],
                'billing_mobile'   => $address['mobile'],
                'billing_address'  => $address['address'],
                'billing_city'     => $address['city'],
                'billing_state'    => $address['state'],
                'billing_pincode'  => $address['pincode'],
                'shipping_email'   => $address['email'],
                'shipping_mobile'  => $address['mobile'],
                'shipping_address' => $address['address'],
                'shipping_city'    => $address['city'],
                'shipping_state'   => $address['state'],
                'shipping_pincode' => $address['pincode'],
                'payment_option'   => $payment_option,
                'order_total'      => $cart_info['total'],
                'created'          => date('Y-m-d H:i:s'),
            ]);
            
            foreach ($cart_info['items'] as $item)
            {
                $this->order_items_model->add([
                    'order_id'   => $order_id,
                    'product_id' => $item['product_id'],
                    'price'      => $item['price'],
                    'quantity'   => $item['quantity'],
                ]);
            }
            $this->db->trans_commit();
        }
        catch (Exception $ex)
        {
            $this->db->trans_rollback();
        }
    }

}
