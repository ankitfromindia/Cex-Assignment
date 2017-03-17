<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Model
 *
 * @author ankitvishwakarma
 */
class MY_Model extends CI_Model
{
    /**
     * @vars
     */
    protected $_db;
    
    protected $fillable;
    
    
    /**
     * Get list of non-deleted users
     *
     * @param  int $limit
     * @param  int $offset
     * @param  array $filters
     * @param  string $sort
     * @param  string $dir
     * @return array|boolean
     */
    function get_all($limit = 0, $offset = 0, $filters = array(), $sort = 'name', $dir = 'ASC')
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db}
            WHERE deleted = '0'
        ";

        if (!empty($filters))
        {
            foreach ($filters as $key => $value)
            {
                $value = $this->db->escape('%' . $value . '%');
                $sql   .= " AND {$key} LIKE {$value}";
            }
        }

        $sql .= " ORDER BY {$sort} {$dir}";

        if ($limit)
        {
            $sql .= " LIMIT {$offset}, {$limit}";
        }

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
        {
            $results['results'] = $query->result_array();
        }
        else
        {
            $results['results'] = NULL;
        }

        $sql              = "SELECT FOUND_ROWS() AS total";
        $query            = $this->db->query($sql);
        $results['total'] = $query->row()->total;

        return $results;
    }
    
    public function get_by_id($id = null)
    {
        if ($id)
        {
            $sql = "
                SELECT *
                FROM {$this->_db}
                WHERE id = " . $this->db->escape($id) . "
                    AND deleted = '0'
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows())
            {
                return $query->row_array();
            }
        }

        return FALSE;
    }
    public function adding(&$data)
    {
        
    }
    
    public function add($data = array())
    {
        $this->adding($data);
        $insert = [];
        foreach($data as $key => $d)
        {
            if(in_array($key, $this->fillable))
            {
                $insert[$key] = $d;
            }
        }
        if($insert)
        {
            $this->db->insert($this->_db, $insert);
            return $this->db->insert_id();
        }
        return false;
    }
    
    public function edit($data = array(), $where = array())
    {
        
        $update = [];
        foreach($data as $key => $d)
        {
            if(in_array($key, $this->fillable))
            {
                $update[$key] = $d;
            }
        }
        if($update)
        {
            if(isset($data['id']))
            {
                $where['id'] = $data['id'];
            }
            return $this->db->update($this->_db, $update, $where);
        }
        return false;
    }
    
    public function remove($id = null)
    {
        if ($id)
        {
            $sql = "
                UPDATE {$this->_db}
                SET
                    
                    deleted = '1'
                WHERE id = " . $this->db->escape($id) . "
                    AND id > 1
            ";

            $this->db->query($sql);

            if ($this->db->affected_rows())
            {
                return TRUE;
            }
        }

        return FALSE;
    }
    
    function exists($name, $field = 'name')
    {
        $sql = "
            SELECT id
            FROM {$this->_db}
            WHERE {$field} = " . $this->db->escape($name) . "
            LIMIT 1
        ";

        $query = $this->db->query($sql);

        if ($query->num_rows())
        {
            return TRUE;
        }

        return FALSE;
    }
    
    public function get_by_field($key, $value)
    {
        return $this->db->get_where($this->_db, [$key => $value]);
    }
    
    public function get_by_fields(array $fields)
    {
        return $this->db->get_where($this->_db, $fields);
    }
    
    public function delete(array $fields)
    {
        return $this->db->where($fields)->delete($this->_db);
    }
}
