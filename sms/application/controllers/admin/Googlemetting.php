<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Googlemetting extends Admin_Controller {

    public function __construct() {
        parent::__construct();
          $this->load->model(["Googlemetting_model","Role_model","Staff_model"]);
          $this->load->library("form_validation");
          $this->load->helper("url");
          $this->load->library("session");
    }

    public function index() {

        if (!$this->rbac->hasPrivilege('googlemetting', 'can_view')) {
            access_denied();
        }
             



        $json_array = array();
        $this->session->set_userdata('top_menu', 'googlemetting');
        $this->session->set_userdata('sub_menu', 'googlemetting/index');
        $data['title'] = 'Fee';
        $data['title_list'] = 'Fee_list';
        $stafflist=$this->Staff_model->getStaffName();
       
        
        // $data['disc']=$this->Guardian_model->get();
       

        $data['section_array'] = $json_array;
        
      
        $this->load->view('layout/header', $data);
        $this->load->view('admin/gmetting/add',['stafflist'=>$stafflist]);
        $this->load->view('layout/footer', $data);

        // $this->form_validation->set_rules(
        //         'name', $this->lang->line('name'), array(
        //     'required',
        //     array('class_exists', array($this->subjectgroup_model, 'class_exists')),
        //         )
        // );

        // $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');

        // $this->form_validation->set_rules('subject[]', $this->lang->line('subject'), 'trim|required|xss_clean');



        // $this->form_validation->set_rules(
        //         'sections[]', $this->lang->line('section'), array(
        //     'required',
        //     array('check_section_exists', array($this->subjectgroup_model, 'check_section_exists'))
        //         )
        // );


        // if ($this->form_validation->run() == false) {
        //     $data['section_array'] = $this->input->post('sections');
        // } else {
        //     $name = $this->input->post('name');
        //     $session = $this->setting_model->getCurrentSession();
        //     $class_array = array(
        //         'name' => $this->input->post('name'),
        //         'session_id' => $session,
        //         'description' => $this->input->post('description'),
        //     );
        //     $subject = $this->input->post('subject');
        //     $sections = $this->input->post('sections');

        //     $this->subjectgroup_model->add($class_array, $subject, $sections);
        //     $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
        //     redirect('admin/subjectgroup');
        // }
        // $subject_list = $this->subject_model->get();
        // $data['subjectlist'] = $subject_list;
        // $subjectgroupList = $this->subjectgroup_model->getByID();
        // $data['subjectgroupList'] = $subjectgroupList;
        
    }
// add study year
    public function create() {


        if (!$this->rbac->hasPrivilege('incomegroup', 'can_delete')) {
            access_denied();
        }

        $this->form_validation->set_rules("metting_title","meeting title","xss_clean|trim|required",array("required"=>"Metting Title Required"));
        $this->form_validation->set_rules("date","date","xss_clean|trim|required",array("required"=>"Metting Date Required"));
        $this->form_validation->set_rules("duration","duration","xss_clean|trim|required",array("required"=>"Metting Duration Required"));

        $this->form_validation->set_rules("url","url","xss_clean|trim|required",array("required"=>"Metting URL Required"));
        $this->form_validation->set_rules("description","description","xss_clean|trim|required",array("required"=>"Metting Description Required"));
      
        $this->form_validation->set_rules("staff[]","staff","xss_clean|trim|required",array("required"=>"Select Staff"));
          if($this->form_validation->run()==false){


             $json_array = array();
        $this->session->set_userdata('top_menu', 'googlemetting');
        $this->session->set_userdata('sub_menu', 'googlemetting/index');
        $data['title'] = 'Fee';
        $data['title_list'] = 'Fee_list';
        $stafflist=$this->Staff_model->getStaffName();
       
        
        // $data['disc']=$this->Guardian_model->get();
       

        $data['section_array'] = $json_array;
        
      
        $this->load->view('layout/header', $data);
        $this->load->view('admin/gmetting/add',['stafflist'=>$stafflist]);
        $this->load->view('layout/footer', $data);

          }
          else{
           $data=array(
             "metting_title"=>$this->input->post("metting_title"),
             "metting_date"=>date("Y-m-d",strtotime($this->input->post("date"))),
             "metting_duration"=>$this->input->post("duration"),
             "url"=>$this->input->post("url"),
             "description"=>$this->input->post("description"),
             "staff_id"=>json_encode($this->input->post("staff"))
         );

          $checkExist=$this->Googlemetting_model->checkExist($data);
          
        if(!$checkExist){
           $create=$this->Googlemetting_model->add($data);
           if($create){
              
            $this->session->set_flashdata("success","Metting Created Successfully");
            redirect("admin/Googlemetting");
           }
           else{
                $this->session->set_flashdata("warning","Whoops! something is wrong");
            redirect("admin/Googlemetting");
           }
        }
        else{
            $this->session->set_flashdata("warning","Metting already exists");
            redirect("admin/Googlemetting");
        }
          }
     
         


    }

//end add study year


    //change status coding start

   public function status()
    {
     
    $status =base64_decode($this->input->get("s"));
     $id=base64_decode($this->input->get("id"));
    

       $check=$this->Googlemetting_model->status($status,$id);
       if($check){
         $this->session->set_flashdata("msg","<div class='alert alert-success'><i class='fa fa-times-circle close' data-dismiss='alert'></i>Status Updated successfully</div>");
            redirect("admin/Googlemetting/list");
       }
       else{
        $this->session->set_flashdata("msg","<div class='alert alert-warning'><i class='fa fa-times-circle close' data-dismiss='alert'></i>Whoops! something is wrong try again</div>");
            redirect("admin/Googlemetting/list");
       }
    }
    //end change status coding start
    public function update() {
        if (!$this->rbac->hasPrivilege('incomegroup', 'can_edit')) {
            access_denied();
        }
           
            $data=array(
            "name"=>$this->input->post("name"),
            "id"=>$this->input->post("id"),
             );
              $update=$this->Incomegroup_model->update($data);
        if($update['status']){
            $this->session->set_flashdata("msg","<div class='alert alert-success'><i class='fa fa-times-circle close' data-dismiss='alert'></i>Incomegroup Details Updated successfully</div>");
            redirect("admin/incomegroup");
        }
        else{
            $this->session->set_flashdata("msg","<div class='alert alert-warning'><i class='fa fa-times-circle close' data-dismiss='alert'></i>".$update['message']."</div>");
            redirect("admin/incomegroup");
        }

     
        
      
        
    }

  
    public function delete($id){
        $check=$this->Googlemetting_model->delete($id);
        if($check){
             $this->session->set_flashdata("msg","<div class='alert alert-success'><i class='fa fa-times-circle close' data-dismiss='alert'></i><b> Deleted successfully</b></div>");
            redirect("admin/Googlemetting/list");
        }
        else{
               $this->session->set_flashdata("msg","<div class='alert alert-warning'><i class='fa fa-times-circle close' data-dismiss='alert'></i><b>Whoops! something is wrong try again</b>/div>");
            redirect("admin/Googlemetting/list");
        }

    }


    
    public function list(){

        $data=$this->Googlemetting_model->get();
        $this->load->view('layout/header', $data);
        $this->load->view("admin/gmetting/list",['listdata'=>$data]);
        $this->load->view('layout/footer', $data);
     
        
    }

   

}
