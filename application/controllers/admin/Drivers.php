<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Drivers extends CI_Controller {

    public function __construct() {
        parent::__construct(); 
        $this->load->helper('form');
		$this->load->library('form_validation'); 
        $this->load->helper('security');
        $this->load->library('pagination'); 
        if (empty($this->session->userdata('is_admin'))) {
            redirect(base_url('login'));
        }
    }

    public function index() { 
        $data['title'] = "Admin | Drivers";
        // $data['listRecord'] = $this->common_model->getRecords('','tbl_companies','','');
        $whereData['role !='] ='admin';
        $data['listRecord'] = $this->common_model->getRecords($whereData,'ci_drivers','','');
        // echo $this->db->last_query();die();
        $this->load->view('admin/drivers', $data);
        // $this->load->view('footer');
    }
    public function add($id='') { 
        $data['title'] = "Admin | Add Companies ";
        $this->load->view('admin/add-companies', $data);
        // $this->load->view('footer');
    } 
     
    public function save($id='') { 
        $setData = $this->input->post();
        $where['name'] = $setData['name']; 
        if (check_row('tbl_companies',$where)) {
            $this->session->set_flashdata('error','OPPS! Company alredy exist !');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if($_FILES['logo_image']['name']){   
            $setData['image_path'] = "upload/company-logo";
            if( ! file_exists($setData['image_path']) ){
            mkdir($setData['image_path'], 0755, true);
            }   
            $filedata = $this->common_model->uploadImage($_FILES['logo_image'],$setData['image_path']);
            if(!$filedata['message']){
            $this->session->set_flashdata('message', $filedata['error']);
            redirect(base_url('customer')); 
            }else{
            $setData['logo_image'] = $filedata['filename'];
            }
        }else{
            unset($setData['logo_image']);
        }
        $res = $this->common_model->insert_data('tbl_companies',$setData);
        if ($res) {
            $this->session->set_flashdata('message','Record Save Successfully!');
            redirect(admin_url('companies'));
        }else{
            $this->session->set_flashdata('error','OPPS! There was an error');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function delete(int $value)
    {
        $setData['id'] = $value;  
        $res = $this->common_model->deleteItem($setData,'tbl_companies');
        if ($res) {
           $this->session->set_flashdata('message','Record deleted Successfully!');
        }else{
            $this->session->set_flashdata('error','OPPS! There was an error!');
        } 
        redirect($_SERVER['HTTP_REFERER']); 
    }

}