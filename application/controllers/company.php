<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class Company extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('company_model');
    }
    
    function index()
    {
        $this->response_404();
    }
    
    function info()
    {
        $code = $this->input->get('code', TRUE);
        $info = $this->company_model->get_info($code);
        $this->response(array(
            'success' => ($info) ? TRUE : FALSE,
            'data' => $info
        ));
    }
    
    function info_all()
    {
        $code  = $this->input->get('code', TRUE);
        $info  = $this->company_model->get_info($code);
        $quote = $this->company_model->get_quote($code);
        if($info && $quote)
        {
            unset($quote['code'], $quote['name']);
            $info['quote'] = $quote;
            
            $this->response(array(
                'success' => TRUE,
                'data' => $info
            ));
        }
        else
        {
            $this->response(array(
                'success' => FALSE
            ));
        }
    }
    
    function quote()
    {
        $code = $this->input->get('code', TRUE);
        $info = $this->company_model->get_quote($code);
        $this->response(array(
            'success' => ($info) ? TRUE : FALSE,
            'data' => $info
        ));
    }
    
    function get()
    {
        $limit = (int)$this->input->get('limit', TRUE);
        $start = (int)$this->input->get('start', TRUE);
        $order = $this->input->get('order', TRUE);
        $sort  = $this->input->get('sort', TRUE);
        
        $data = $this->company_model->companies($limit, $start, $order, $sort);
        $this->response(array(
            'success' => (bool)$data,
            'total' => $this->company_model->total_companies(),
            'data' => $data
        ));
    }
    
}