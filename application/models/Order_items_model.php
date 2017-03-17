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
class Order_items_model extends MY_Model
{
   protected $_db = 'order_items';
   
   protected $fillable = ['order_id', 'product_id', 'price', 'quantity'];
   
   public function __construct()
   {
       parent::__construct();
       $this->load->model(['orders_model']);
   }
  
   
}
