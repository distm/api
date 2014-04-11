<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->response_404();
    }
       
}