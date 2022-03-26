<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
		$this->load->library('form_validation');
        $this->load->library('session'); 
        $this->load->model('common_model');
        $this->load->helper('date');
        $this->load->helper('security');
        $this->load->library('pagination');
        $this->load->helper('captcha');
    }

    public function index() {
        if ($this->session->userdata('is_admin')) {
            redirect(base_url('admin/dashboard'));
        }
        $data['title'] = "Please Login ";
        $this->load->view('login', $data);
        // $this->load->view('footer');
    }

public function adminlogin() {
    $setData = $this->input->post();
    $setData = $this->security->xss_clean($setData);
    if (isset($setData['email'])) {
        $this->form_validation->set_rules('email', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
    if ($this->form_validation->run() == FALSE) {

    $this->load->view("login");

    } else{

        $user = $this->jwellery_model->admin_login($setData);

        if ($user) {
            $result['status']  = 'success';
            $result['message'] = 'Login Success! Please Wait we will redirect shortly!.';

        }else{ 
            $result['status']  = 'error';
            $result['message'] = 'OPPS!! Invalid Username or Password Try Again!.Make Sure Username and Password may be case senstive!';
        }

        echo json_encode($result);die;
    }
    } else
        $result['status']  = 'error';
        $result['message'] = 'OPPS!! Please Enter Required Fields!';
}

    public function logout() {
        $this->session->sess_destroy();
		//$array_items = array('is_admin');
		$this->session->sess_destroy('is_admin');
		//$this->session->unset_userdata($array_items);
        redirect(base_url());
    }

}