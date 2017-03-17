<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model extends MY_Model
{

    protected $fillable = ['parent_id', 'name'];
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        // define primary table
        $this->_db = 'categories';
    }

    

    /**
     * Get specific user
     *
     * @param  int $id
     * @return array|boolean
     */
    function get_category($id = NULL)
    {
        return $this->get_by_id($id);
    }

    /**
     * Add a new user
     *
     * @param  array $data
     * @return mixed|boolean
     */
    function add_category($data = array())
    {
        return $this->add($data);
    }

    /**
     * Edit an existing user
     *
     * @param  array $data
     * @return boolean
     */
    function edit_category($data = array())
    {
        return $this->edit($data);
    }

    /**
     * Soft delete an existing user
     *
     * @param  int $id
     * @return boolean
     */
    function delete_category($id = NULL)
    {
        $this->remove($id);
    }

    /**
     * Check to see if a username already exists
     *
     * @param  string $username
     * @return boolean
     */
    function category_exists($name)
    {
        $sql = "
            SELECT id
            FROM {$this->_db}
            WHERE name = " . $this->db->escape($name) . "
            LIMIT 1
        ";

        $query = $this->db->query($sql);

        if ($query->num_rows())
        {
            return TRUE;
        }

        return FALSE;
    }

    

}
