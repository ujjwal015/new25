<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pricing extends CI_Controller {

    public function __construct() {
        parent::__construct(); 
        $this->load->helper('form');
		$this->load->library('form_validation'); 
        $this->load->helper('date');
        $this->load->helper('security');
        $this->load->library('pagination');
        $this->load->helper('captcha');
    }

    public function index() { 
        $data['title'] = "Pricing";
        $where['deleted_at'] = NULL;
        $data['listRecord'] = $this->common_model->getRecords($where,'tbl_packages','','');
        $this->load->view('pricing', $data);
        // $this->load->view('footer');
    } 

}