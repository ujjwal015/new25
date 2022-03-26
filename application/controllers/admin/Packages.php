<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends CI_Controller {

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
        $data['title'] = "Admin | Packages";
        $where['deleted_at'] = NULL;
        $data['listRecord'] = $this->common_model->getRecords($where,'tbl_packages','','');
        $this->load->view('admin/packages', $data);
        // $this->load->view('footer');
    }
    public function addNew($id='') { 
        $data['title'] = "Admin | Add Packages";
        if (!empty($id) && is_numeric($id)) {
            $data['title'] = "Admin | Edit Packages";
            $data['details'] = $this->common_model->getRecord(array('id'=>$id),'tbl_packages','');
        }
        $this->load->view('admin/add-package', $data);
        // $this->load->view('footer');
    }
     
    public function save($id='') { 
        $setData = $this->input->post(); 
        
       // print_r($setData);exit;
        // $id =$setData['id'];
        if (!empty($id) && is_numeric($id)) {
            $save = $this->common_model->update_data('tbl_packages',$setData,array('id'=>$id));
            $this->session->set_flashdata('message','Record Updated Successfully!');
            redirect(admin_url('packages'));
        }
        $res = $this->common_model->insert_data('tbl_packages',$setData);
        if ($res) {
            $this->session->set_flashdata('message','Record Save Successfully!');
            redirect(admin_url('packages'));
        }else{
            $this->session->set_flashdata('error','OPPS! There was an error');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function delete(int $value)
    {
        $where['id'] = $value;  
        $res = $this->common_model->softDelete($where,'tbl_packages');
        if ($res) {
           $this->session->set_flashdata('message','Record deleted Successfully!');
        }else{
            $this->session->set_flashdata('error','OPPS! There was an error!');
        } 
        redirect($_SERVER['HTTP_REFERER']); 
    }
    
    
     public function add($id='') { 
        $data['title'] = "Admin | Add Packages";
        if (!empty($id) && is_numeric($id)) {
            $data['title'] = "Admin | Edit Packages";
            $data['details'] = $this->common_model->getRecord(array('id'=>$id),'tbl_packages','');
        }
        $this->load->view('admin/add-newpackage', $data);
        // $this->load->view('footer');
    }
    
    
    
    
    
    
    
    
    
    
    
    

}