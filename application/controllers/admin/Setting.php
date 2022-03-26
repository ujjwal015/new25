<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

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
        $data['title'] = "Admin | Setting";
        $data['record'] = $this->db->select('id,smtp_details')->from('tbl_setting')->get()->row();
       
        $this->load->view('admin/setting', $data);
        // $this->load->view('footer');
    } 
     
    public function save($id='') { 
        $dataSet=[];
        $setData = $this->input->post();
        if($_FILES['logo_image']['name']){   
            $setData['image_path'] = $dataSet['image_path'] = "upload/avatars";
            if( ! file_exists($setData['image_path']) ){
            mkdir($setData['image_path'], 0755, true);
            }   
            $filedata = $this->common_model->uploadImage($_FILES['logo_image'],$setData['image_path']);
            if(!$filedata['message']){
            $this->session->set_flashdata('message', $filedata['error']);
                redirect(base_url('admin/setting')); 
            }else{
            $dataSet['logo_image'] = $filedata['filename'];
            }
        }else{
            unset($dataSet['logo_image']);
        }

        $dataSet['smtp_details'] = json_encode($setData);
        $isRow = $this->db->select('id')->from('tbl_setting')->get()->row();
        if (!empty($isRow)) {
            $res = $this->common_model->update_data('tbl_setting',$dataSet,'');
            $this->session->set_flashdata('message','Record Save Successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        } 
        $res = $this->common_model->insert_data('tbl_setting',$dataSet);
        if ($res) {
            $this->session->set_flashdata('message','Record Save Successfully!'); 
        }else{
            $this->session->set_flashdata('error','OPPS! There was an error'); 
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete(int $value)
    {
        $setData['id'] = $value;  
        $res = $this->common_model->deleteItem($setData,'tbl_payment_details');
        if ($res) {
           $this->session->set_flashdata('message','Record deleted Successfully!');
        }else{
            $this->session->set_flashdata('error','OPPS! There was an error!');
        } 
        redirect($_SERVER['HTTP_REFERER']); 
    }

}