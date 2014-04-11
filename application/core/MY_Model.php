<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');


class MY_Model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->driver('cache', array('adapter' => 'memcached'));
    }
    
    function available_fields($table_name)
    {
        if (! $table_name)
        {
            return FALSE;
        }

        $key = "available-fields-{$table_name}";
        
        $super_idn = $this->session->userdata('super_idn');
        if($super_idn)
        {
            $key .= 'super-idn';
        }
        
        $fields = $this->cache->get($key);
        
        if($fields === FALSE)
        {
            $fields = $this->db->list_fields($table_name);
            if($fields)
            {
                if($super_idn === TRUE)
                {
                    return $fields;
                }
                else
                {
                    $available_fields = array();
                    foreach($fields as $field)
                    {
                        if(!preg_match('/(id|datecreate)/', $field))
                        {
                            $available_fields[] = $field;
                        }
                    }
                    
                    $this->cache->save($key, $available_fields, CACHE_TIMER_M15);
                    return $available_fields;
                }
            }
            else
            {
                $this->cache->save($key, '', CACHE_TIMER_M03);
                return FALSE;
            }
        }
        
        return $fields;
    }
    
    function global_limit($limit=5)
    {
        return ($limit <= 0) ? 5 : ($limit > 30 ? 30 : $limit);
    }
    
    function global_order($field='', $table_name='')
    {
        $default_order = 'id';
        if(! $field)
        {
            return $default_order;
        }
        
        $available_fields = $this->available_fields($table_name);
        if(in_array($field, $available_fields))
        {
            return $field;
        }
        else
        {
            return $default_order;
        }
    }
    
    function global_sort($sort='asc')
    {
        return (strtolower($sort) == 'desc') ? 'DESC' : 'ASC';
    }
    
}