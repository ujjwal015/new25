<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Gmeetclasses extends Admin_Controller {

    public function __construct() {
        parent::__construct();
          $this->load->model(["Gmeetclasses_model","Role_model","Class_model"]);
          $this->load->library("form_validation");
          $this->load->helper("url");
          $this->load->library("session");
    }

    public function index() {
        if (!$this->rbac->hasPrivilege('semester', 'can_view')) {
            access_denied();
        }
             
       


        $json_array = array();
        $this->session->set_userdata('top_menu', 'gmeet');
        $this->session->set_userdata('sub_menu', 'gmeet/index');
        $data['title'] = 'Add Classroom';
        $data['title_list'] = 'Add Classroom';
        $gmeet_classes = $this->Gmeetclasses_model->get();
      
        $data['section_array'] = $json_array;



        $this->load->view('layout/header', $data);
        $this->load->view('admin/gmeet_class/gmeet_list', ['data'=>$data,"gmeet"=> $gmeet_classes]);
        $this->load->view('layout/footer', $data);

        
        
    }
// add study year
    public function add() {

        if (!$this->rbac->hasPrivilege('subject_group', 'can_delete')) {
            access_denied();
        }
         $data['title'] = 'Add Gmeet Classes';
        $data['title_list'] = 'Add Gmeet Classes';
        $role=$this->Role_model->getAllRole();
        $class=$this->Class_model->getAll();
        

         $this->load->view('layout/header', $data);
        $this->load->view('admin/gmeet_class/gmeet_add', ['data'=>$data,"role"=>$role,"class"=>$class]);
        $this->load->view('layout/footer', $data);
        
       
    }

//end add study year


 public function create(){
   $data=array(

    "class_title"=>$this->input->post("class_title"),
    "class_date"=>date("Y-m-d",strtotime($this->input->post("date"))),
    "duration"=>$this->input->post('duration'),
    "role"=>$this->input->post("role"),
    "staff"=>$this->input->post("staff"),
    "class"=>$this->input->post("class"),
    "section"=>$this->input->post("section"),
    "url"=>$this->input->post("gmeet_url"),
    "description"=>$this->input->post("description"),
          );

   $checkExist=$this->Gmeetclasses_model->checkExist($data);
   if($checkExist){
echo "Exist";

   }
   else{
    $check=$this->Gmeetclasses_model->add($data);
    if($check){
        $this->session->set_flashdata("msg","success");
        redirect("/admin/Gmeetclasses/add");
    }
    else{
         $this->session->set_flashdata("msg","Whoops! something is wrong");
        redirect("/admin/Gmeetclasses/add");
    }

   }
 }

    //change status coding start

    public function status()
    {
     
    $status =base64_decode($this->input->get("s"));
     $id=base64_decode($this->input->get("id"));
    

       $check=$this->Gmeetclasses_model->status($status,$id);
       if($check){
         $this->session->set_flashdata("msg","<div class='alert alert-success'><i class='fa fa-times-circle close' data-dismiss='alert'></i>Status Updated successfully</div>");
            redirect("admin/Gmeetclasses");
       }
       else{
        $this->session->set_flashdata("msg","<div class='alert alert-warning'><i class='fa fa-times-circle close' data-dismiss='alert'></i>Whoops! something is wrong try again</div>");
            redirect("admin/Gmeetclasses");
       }
    }
    //end change status coding start
    public function update() {
        if (!$this->rbac->hasPrivilege('subject_group', 'can_edit')) {
            access_denied();
        }
        $data=array("id"=>$this->input->post("id"),"room_no"=>$this->input->post("room_no"),"capacity"=>$this->input->post("capacity"));
        $update=$this->Classroom_model->update($data);
        if($update['status']){
            $this->session->set_flashdata("msg","<div class='alert alert-success'><i class='fa fa-times-circle close' data-dismiss='alert'></i>Classroom  Updated successfully</div>");
            redirect("admin/classroom");
        }
        else{
            $this->session->set_flashdata("msg","<div class='alert alert-warning'><i class='fa fa-times-circle close' data-dismiss='alert'></i>".$update['message']."</div>");
            redirect("admin/classroom");
        }
        
    }

  
    public function delete($id){
        $check=$this->Gmeetclasses_model->delete($id);
        if($check){
             $this->session->set_flashdata("msg","<div class='alert alert-success'><i class='fa fa-times-circle close' data-dismiss='alert'></i><b> Deleted successfully</b></div>");
            redirect("admin/Gmeetclasses");
        }
        else{
               $this->session->set_flashdata("msg","<div class='alert alert-warning'><i class='fa fa-times-circle close' data-dismiss='alert'></i><b>Whoops! something is wrong try again</b>/div>");
            redirect("admin/Gmeetclasses");
        }

    }


    public function list(){
         $json_array = array();
        $this->session->set_userdata('top_menu', 'Semester');
        $this->session->set_userdata('sub_menu', 'semester/index');
        $data['title'] = 'Add Semester';
        $data['title_list'] = 'Add Semester';
        $year = $this->Classroom_model->all();
        $data['year'] = $year;
        $data['section_array'] = $json_array;
        


        $this->load->view('layout/header', $data);
        $this->load->view('admin/semester/list', ['data'=>$data]);
        $this->load->view('layout/footer', $data);

    }


    public function year($year){

       $json_array = array();
        $this->session->set_userdata('top_menu', 'Semester');
        $this->session->set_userdata('sub_menu', 'semester/index');
        $data['title'] = 'Add Semester';
        $data['title_list'] = 'Add Semester';
        $year_data = $this->Classroom_model->all();
        $data['year'] = $year_data;
        $data['section_array'] = $json_array;
          $data['semester_data']=$this->Classroom_model->semester($year);


        $this->load->view('layout/header', $data);
        $this->load->view('admin/semester/list', ['data'=>$data]);
        $this->load->view('layout/footer', $data); 
    }


    public function getStaff(){
          $all_staff_id=$this->Gmeetclasses_model->getAllStaffByRole($this->input->get("role_id"));
          
           echo json_encode(['data'=>$all_staff_id]);
    }


    public function getSection(){
        $class_id=$this->input->get("class_id");
        $data=$this->Gmeetclasses_model->getSectionByClassId($class_id);
            if(!empty($data)){
                echo json_encode(['data'=>$data]);
            }

    }

}
