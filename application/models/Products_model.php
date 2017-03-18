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
class Products_model extends MY_Model
{
   protected $_db = 'products';
   
   protected $fillable = ['category_id', 'name', 'image', 'price', 'quantity', 'description', 'is_active'];
   
   public function in_stock(int $product_id, int $quantity_required = 0)
   {
       $product = $this->db->get_where('products', ['id' => $product_id])->row_array();
       if (!empty($product))
        {
            if ($product['quantity'] > 0 && $quantity_required == 0)
            {
                return true;
            }
            elseif ($product['quantity'] > 0 && $quantity_required > 0)
            {
                if ($product['quantity'] >= $quantity_required)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        return false;
    }
   
}
