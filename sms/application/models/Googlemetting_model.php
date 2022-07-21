<?php

class Googlemetting_model extends MY_Model{
    function __construct(){
        parent::__construct();
         $this->current_session = $this->setting_model->getCurrentSession();
         $this->load->database();
    }

    function add($data){
     $query=$this->db->insert("gmeet_staff",$data);
     if($query){
        return true;
     }
     else{
        return false;
     }
    }


    function checkExist($data){
        $this->db->where("metting_title",$data['metting_title']);
         $this->db->where("metting_date",$data['metting_date']);
          $this->db->where("url",$data['url']);
        $query=$this->db->get("gmeet_staff");
        if($query->num_rows()>0){
            return true;
        }
        else{
            return false;
        }
    }

    function get(){
        $result=$this->db->get("gmeet_staff");
        return $result->result_array();
    }
    function all(){
    $this->db->where("status",1);
        $result=$this->db->get("gmeet_staff");
        return $result->result_array();
    }

function status($status,$id){
        
        

        
        
        $this->db->where("id",$id);
        $result=$this->db->update("gmeet_staff",['status'=>"$status"]);
        if($result){
            return true;
        }
        else{
            return false;
        }
    
    
        
    
        

    }


    function update($data){
        $this->db->where("name",$data['name']);
        $result=$this->db->get("gmeet_staff");
        $result=$result->num_rows();
        if($result>1){
            return array("message"=>"gmeet_staff Details Updated successfully updated","status"=>false);
        }
        else{
            $this->db->where("id",$data['id']);
            $result=$this->db->update("gmeet_staff",$data);
            if($result){
                return array("message"=>"Email already exist","status"=>true);
            }
            else{
                return array("message"=>"Whoops! something is wrong try again","status"=>false);
            }

        }
    }


    public function delete($id){
        $result=$this->db->where("id",$id)->delete("gmeet_staff");
        if($result){
            return true;
        }
        else{
            return false;
        }

    }


    function edit($id){
        $this->db->where("id",$id);
        $result=$this->db->get("gmeet_staff")->row();
        return $result;

    }

    
}


?>