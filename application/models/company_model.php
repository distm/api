<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class Company_model extends MY_Model {
    
    function companies($limit=5, $start=0, $order='id', $sort='asc')
    {
        $limit = $this->global_limit($limit);
        $start = abs($start);
        $order = $this->global_order($order, 'company');
        $sort  = $this->global_sort($sort);
        
        $key = "cm-companies-{$limit}-{$start}-{$order}-{$sort}";
        $data = $this->cache->get($key);
		
        if($data === FALSE)
        {
            $fields = $this->available_fields('company');
            $get = $this->db->select($fields)
                            ->order_by($order, $sort)
                            ->limit($limit, $start)
                            ->get('company');
            
            if($get && $get->num_rows())
            {
                $result = array();
                foreach($get->result_array() as $row)
                {
                    if(isset($row['summary']))
                    {
                        $row['summary'] = json_decode($row['summary'], TRUE);
                    }
                    
                    if(isset($row['description']))
                    {
                        $row['description'] = json_decode($row['description'], TRUE);
                    }
                    
                    $result[] = $row;
                }
                
                $this->cache->save($key, $result, CACHE_TIMER_COMPANIES);
                return $result;
            }
            else
            {
                $this->cache->save($key, '', CACHE_TIMER_COMPANIES_NONE);
                return FALSE;
            }
        }
        
        return $data;
    }

    function get_info($code, $fields = FALSE)
    {
        if(!$code)
        {
            return FALSE;
        }

        $selected_field = $available_fields = $this->available_fields('company');
        $key = "cm-get_info-{$code}";
        
        // parse fields
        if($fields !== FALSE)
        {
            $fields = is_array($fields) ? $fields : (strpos($fields, ',') !== FALSE ? explode(',', $fields) : array($fields));
            $selected_field = array('code', 'name');
            foreach($fields as $field)
            {
                if(in_array($field, $available_fields) && !in_array($field, $selected_field))
                {
                    $selected_field[] = $field;
                }
            }

            $key .= implode('', $selected_field);
        }

        $data = $this->cache->get($key);
        if($data === FALSE)
        {
            $get = $this->db->select($selected_field)
                    ->where('code', $code)
                    ->get('company');
            
            if($get && $get->num_rows() > 0)
            {
                $result = array();
                foreach($get->row_array() as $col_name => $col_value)
                {
                    if(preg_match('/(summary|description)/', $col_name))
                    {
                        $result[$col_name] = json_decode($col_value, TRUE);
                    }
                    else
                    {
                        $result[$col_name] = $col_value;
                    }
                }

                $this->cache->save($key, $result, CACHE_TIMER_COMPANY_INFO);
                return $result;
            }
            else
            {
                $result = '';
                $this->cache->save($key, $result, CACHE_TIMER_COMPANY_INFO_NONE);
                return $result;
            }
        }

        return $data;
    }

    function get_quote($code, $fields = FALSE)
    {
        if(!$code)
        {
            return FALSE;
        }

        $selected_field = $available_fields = $this->available_fields('quote');
        $key = "cm-get_quote-{$code}";

        // parse fields
        if($fields !== FALSE)
        {
            $fields = is_array($fields) ? $fields : (strpos($fields, ',') !== FALSE ? explode(',', $fields) : array($fields));
            $selected_field = array('code');
            foreach($fields as $field)
            {
                if(in_array($field, $available_fields) && !in_array($field, $selected_field))
                {
                    $selected_field[] = $field;
                }
            }

            $key .= implode('', $selected_field);
        }

        $data = $this->cache->get($key);
        if($data === FALSE)
        {
            $get = $this->db->select($selected_field)
                    ->where('code', $code)
                    ->get('quote');

            if($get && $get->num_rows() > 0)
            {
                $result = array();

                // get name
                $get_name = $this->get_info($code, 'name');
                $result['name'] = $get_name ? $get_name['name'] : '';

                foreach($get->row_array() as $col_name => $col_value)
                {
                    if(preg_match('/(code|status|date)/', $col_name))
                    {
                        $result[$col_name] = $col_value;
                    }
                    else
                    {
                        $result[$col_name] = (double) $col_value;
                    }
                }

                $this->cache->save($key, $result, CACHE_TIMER_QUOTE);
                return $result;
            }
            else
            {
                $result = '';
                $this->cache->save($key, $result, CACHE_TIMER_QUOTE_NONE);
                return $result;
            }
        }

        return $data;
    }
    
    function search_companies($search, $limit=5, $start=0, $order='id', $sort='asc')
    {
		if(! $search)
		{
			return FALSE;
		}
		
        $limit = $this->global_limit($limit);
        $start = abs($start);
        $order = $this->global_order($order, 'company');
        $sort  = $this->global_sort($sort);
        
        $key = "cm-search-companies-{$search}-{$limit}-{$start}-{$order}-{$sort}";
        $data = $this->cache->get($key);
		
        if($data === FALSE)
        {
			// where match
			foreach(explode(' ', $search) as $str)
			{
				$this->db->or_like('code', $str, 'both');
				$this->db->or_like('name', $str, 'both');
			}
			
            $fields = $this->available_fields('company');
            $get = $this->db->select($fields)
                            ->order_by($order, $sort)
                            ->limit($limit, $start)
                            ->get('company');
            
            if($get && $get->num_rows())
            {
                $result = array();
                foreach($get->result_array() as $row)
                {
                    if(isset($row['summary']))
                    {
                        $row['summary'] = json_decode($row['summary'], TRUE);
                    }
                    
                    if(isset($row['description']))
                    {
                        $row['description'] = json_decode($row['description'], TRUE);
                    }
                    
                    $result[] = $row;
                }
                
                $this->cache->save($key, $result, CACHE_TIMER_COMPANIES);
                return $result;
            }
            else
            {
                $this->cache->save($key, '', CACHE_TIMER_COMPANIES_NONE);
                return FALSE;
            }
        }
        
        return $data;
    }

    function total_companies($config='')
    {
		if(! $config)
		{
			return $this->db->count_all('company');
		}
		else
		{
			if(isset($config['search']))
			{
				// where match
				foreach(explode(' ', $config['search']) as $str)
				{
					$this->db->or_like('code', $str, 'both');
					$this->db->or_like('name', $str, 'both');
				}
				return $this->db->count_all_results('company');
			}			
		}
    }

}
