<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct(); 
        $this->load->helper('form');
		$this->load->library('form_validation');  
        $this->load->helper('date'); 
        $this->load->helper('security');
        $this->load->library('pagination');
        $this->load->helper('captcha');
        if (empty($this->session->userdata('is_admin'))) {
            redirect(base_url('login'));
        }
    }

    public function index() { 
        $data['title'] = "Admin | Dashboard "; 
        $whereData['role !='] ='admin';
        $whereIn['active'] ='0';
        $wherep['deleted_at'] =NULL;
        $data['totalPacakage'] = $this->common_model->getRecords($wherep,'tbl_packages','','');
        $data['listRecord'] = $this->common_model->getRecords($whereData,'users','','');
        $data['listDriver'] = $this->common_model->getRecords($whereData,'ci_drivers','','');
        $sqlMonth = "SELECT SUM(`total_amount`) AS total,COUNT(`pay_id`) AS total_count FROM tbl_payment_history";
        $query = $this->db->query($sqlMonth); 
        $data['totalGet'] = $query->row();
        $this->load->view('admin/dashboard', $data);
        // $this->load->view('footer');
    }
    public function profile() { 
        $data['title'] = "Admin | Profile "; 
        $this->load->view('admin/profile', $data); 
    }
    public function user_status(int $status,int $userID)
    {
        $where['id'] = $userID;
        $data['active'] = $status;
        $res = $this->common_model->update_data('users',$data,$where);
        $userData = $this->common_model->getRecord($where,'users');
       
        if($res && !empty($userData->subdomain_name)){
            $con = mysqli_connect("localhost",MAIN_DATABASE_USER,MAIN_DATABASE_PASSWORD,"door2doorcrm_".$userData->subdomain_name); 
             if (mysqli_connect_errno()) {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
              die();
            } 
            $sql = 'UPDATE ci_admin SET is_active="'.$status.'" WHERE subdomain_name="'.$userData->subdomain_name.'"'; 
            
            $save = mysqli_query($con, $sql);
           
            mysqli_close($con); 
            $this->session->set_flashdata('message','Profile Updated Successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->session->set_flashdata('error','OPPS! There was an error!');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function save_profile() { 
        $setData = $this->input->post();
        if($_FILES['profile_image']['name']){   
            $setData['image_path'] = "upload/avatars";
            if( ! file_exists($setData['image_path']) ){
            mkdir($setData['image_path'], 0755, true);
            }   
            $filedata = $this->common_model->uploadImage($_FILES['profile_image'],$setData['image_path']);
            if(!$filedata['message']){
            $this->session->set_flashdata('message', $filedata['error']);
            redirect(base_url('customer')); 
            }else{
            $setData['profile_image'] = $filedata['filename'];
            }
        }else{
            unset($setData['profile_image']);
        }
        if (!empty($setData['password'])) {
            $setData['password_original'] = $setData['password'];
            $setData['password'] = md5($setData['password']);
        }else{
            unset($setData['password']);
        }
        $id = $this->session->userdata('user_id');
        $res = $this->common_model->cupdate($setData, $id, 'id', 'users');
        if ($res) {
            $this->session->set_flashdata('message','Profile Updated Successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('error','OPPS! There was an error');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

}