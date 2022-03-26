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

public function login_check() {
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_message('required', 'Enter %s');

    if ($this->form_validation->run() === FALSE) {  
       redirect(base_url('login'));
    } else {   
        $data = array(
           'email' => $this->input->post('email'),
           'password' => md5($this->input->post('password')), 
         );

        $check = $this->common_model->auth_check_email($data);

        if($check == FALSE) {
            $this->session->set_flashdata('error','OPPS! Email is not exists');
            redirect(base_url('login'));
            // redirect_subdomain('','login');
        }else{
            $check_password = $this->common_model->auth_check_password($data);
            // var_dump($check); die();
            if($check_password == false){
                $this->session->set_flashdata('error','OPPS! Invalid Password'); 
                // redirect_subdomain('','login');  
                redirect($_SERVER['HTTP_REFERER']);   
             }else{
                if ($check->role !='admin') {
                    $date1=date_create(date('Y-m-d'));
                    $date2=date_create($check->expire_date);
                    $diff=date_diff($date1,$date2);
                    $is__valid = $diff->format("%R%a");
                    if ($is__valid <= 0 || $check->expire_date == date('Y-m-d')) {
                         $this->session->set_flashdata('error','Sorry ! Seems your plan has been expired ! '); 
                        // redirect_subdomain('','login');  
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
                
                $user = [ 
                    'is_admin'  => true,
                    'logged_in'  => true,
                    'user_id' => $check->id,
                    'subdomain_name' => $check->subdomain_name,
                    'role' => $check->role,
                ];
                $this->session->set_userdata($user); 
                redirect( base_url('admin/dashboard') );
             }
        }

    }
}

public function login_auth() {
    $this->form_validation->set_rules('email', 'Email', 'required'); 

    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_message('required', 'Enter %s');

    if ($this->form_validation->run() === FALSE) {  
        redirect(base_url('login'));
    } else {   
        $data = array(
           'email' => $this->input->post('email'), 
         );

        $check = $this->common_model->auth_check_email($data);

        if($check == FALSE) {
            $this->session->set_flashdata('error','Email is not exists');
            redirect(base_url('login'));
        }else{
            
            if ($check->role=='admin') {
                redirect( base_url('login?token='.urlencode(base64_encode($data['email']))) );
            }elseif (!empty($check->subdomain_name)) {
                
                 $date1=date_create(date('Y-m-d'));
                    $date2=date_create($check->expire_date);
                    $diff=date_diff($date1,$date2);
                    $is__valid = $diff->format("%R%a");
                   // echo $check->expire_date;exit;
                   
                     if ($is__valid <= 0 || $check->expire_date == date('Y-m-d')) {
                         $this->session->set_flashdata('error','Sorry ! Seems your plan has been expired ! '); 
                        // redirect_subdomain('','login');  
                        redirect($_SERVER['HTTP_REFERER']);
                    }else{
                        
                        if($check->role=='school'){
                          redirect('https://'.$check->subdomain_name.'.smartschool.one/site/login?token='.urlencode(base64_encode($data['email'])));  
                        }elseif($check->role=='teacher'){
                          redirect('https://'.$check->subdomain_name.'.smartschool.one/site/login?token='.urlencode(base64_encode($data['email'])));  
                        }elseif($check->role=='accountant'){
                           redirect('https://'.$check->subdomain_name.'.smartschool.one/site/login?token='.urlencode(base64_encode($data['email']))); 
                        }elseif($check->role=='receptionist'){
                           redirect('https://'.$check->subdomain_name.'.smartschool.one/site/login?token='.urlencode(base64_encode($data['email']))); 
                        }elseif($check->role=='librarian'){
                           redirect('https://'.$check->subdomain_name.'.smartschool.one/site/login?token='.urlencode(base64_encode($data['email']))); 
                        }elseif($check->role=='student'){
                            redirect('https://'.$check->subdomain_name.'.smartschool.one/site/userlogin?token='.urlencode(base64_encode($data['email'])));
                        }elseif($check->role=='parent'){
                           redirect('https://'.$check->subdomain_name.'.smartschool.one/site/userlogin?token='.urlencode(base64_encode($data['email']))); 
                        }
                        
                        
                        
                        
                        
                    }
                
                // die('sa');
                
                //redirect('https://'.$check->subdomain_name.'.door2doorsoftware.com/d2d/admin/');
                // redirect_subdomain($check->subdomain_name,'?token='.urlencode(base64_encode($data['email'])));
            }else{
                redirect( base_url('/') );
            } 
        }

    }
}

    public function logout() {
        $this->session->sess_destroy();
		//$array_items = array('is_admin');
		$this->session->sess_destroy('is_admin');
		//$this->session->unset_userdata($array_items);
        redirect(base_url());
    }

}