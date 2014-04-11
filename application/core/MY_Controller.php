<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
    }
    
    private function _response_array($data)
    {
        echo '<pre>';
        if(! $data)
            var_dump($data);
        else
            print_r($data);
        exit;
    }
    
    private function _response_json($data='')
    {
        $this->output->set_content_type('application/json');
        if(! $data)
        {
            echo json_encode(array(
                'success' => FALSE,
                'message' => lang('msg_data_not_found')
            ));
        }
        else
        {
            $response = array_merge(array(
                'success' => FALSE,
                'message' => lang('msg_data_not_found')
            ), $data);
            
            // remove message
            if($response['success'] === TRUE)
            {
                unset($response['message']);
            }
            else
            {
                if((isset($response['data']) && $response['data'] !== FALSE) || count($response) > 2)
                {
                    $response['success'] = TRUE;
                    unset($response['message']);
                }
                else
                {
                    unset($response['data']);
                }
            }
            
            //echo '<pre>'; print_r($response);
            echo json_encode($response, 1);
        }
    }
    
    private function _response_xml($data='')
    {
        return ($data);
    }
    
    protected function response($data=array(), $format='json')
    {
        if($format === 'json')
        {
            $this->_response_json($data);
        }
        elseif($format === 'array')
        {
            $this->_response_array($data);
        }
        else
        {
            $this->_response_xml($data);
        }
    }
    
    protected function response_404()
    {
        $this->response(array(
            'success' => FALSE,
            'message' => lang('msg_404')
        ));
    }
    
}