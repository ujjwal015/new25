<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

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
        $data['title'] = "Register ";
        $this->load->view('register', $data);
        // $this->load->view('footer');
    } 
    public function forgot_password() { 
        $data['title'] = "Forgot Password ";
        $this->load->view('forgot_password', $data);
        // $this->load->view('footer');
    } 

    public function save() {
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|trim');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('first_name', 'First Name', 'required');
    $this->form_validation->set_rules('last_name', 'Last Name', 'required');
    $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|is_unique[users.username]');

    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_message('required', ' %s is required field');

    if ($this->form_validation->run() === FALSE) {  
        $this->session->set_flashdata('error',validation_errors());
       redirect($_SERVER['HTTP_REFERER']);
    } else {   
        $data = array(
           'email' => $this->input->post('email'),
           'password' => md5($this->input->post('password')), 
         );

        $check = $this->common_model->auth_check_email($data);
        $setData = $this->input->post();
        $setData['password_original'] = $setData['password'];
        $setData['password'] = md5($setData['password']);
        if($check == FALSE) {
            $this->session->set_flashdata('message','Your account has been created');
            $res = $this->common_model->insert_data('users',$setData);
            $whereData['id']= $res;
            $updateData['subdomain_name']= $setData['username'].$res;
            $res = $this->common_model->update_data('users',$updateData,$whereData);
            redirect(base_url('login'));
            // redirect_subdomain('','login');
        }else{
            $this->session->set_flashdata('error','OPPS! There was an error!'); 
            redirect($_SERVER['HTTP_REFERER']); 
        }

    }
}

}