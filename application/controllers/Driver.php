<?php

defined('BASEPATH') OR exit('No direct script access allowed');



// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver

https://code.tutsplus.com/tutorials/working-with-restful-services-in-codeigniter--net-8814

 */
class Driver extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->load->database();
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('driver_model');
   
       //  $this->product_imagepath = realpath(APPPATH.'../uploads/product/');
      
    }

     public function categories_get(){

        echo "test";
            exit;
	$data = $this->driver_model->get_categories();
//  	print_r($data);
 $this->load->view('cat', $data);

    }

     public function test_get(){
         echo $this->config->item('firebase_api_key');
         die;
     }
     
      public function testemail_post(){
          $mobile_otp = mt_rand(2000,9000);
          $email = $this->post('email');
          $mobile = '9560544627';
          $otp = $mobile_otp;
          $result = $this->driver_model->emailotpsend($email,$mobile,$otp);
          print_r($result);
         
     }
     
  
        public function login_post(){

         $mobile_otp = mt_rand(2000,9000);
        $device_id = $this->post('device_id');
        $device_token = $this->post('device_token');
        $data = array(
                'email' => $this->post('email'),
                'device_id' => $this->post('device_id'),
                'device_type' => $this->post('device_type'),
                'driver_type' => $this->post('driver_type'),
                'mobile_otp' => $mobile_otp
            );
        $result = $this->driver_model->user_login($data);
        
       // print_r($result);
        
        if($result){
        if($result['is_active']=='1'){
        
        
        $date = date('Y-m-d');
      //  $message = 'Welcome to Door2Door APP, your Login Otp Verification code is :' .$mobile_otp;
        $message="Welcome to Door2Door APP, your OTP for login verification ".$mobile_otp." Which is valid for 5 min from now.Do not disclose OTP. if not done by you";

        $country_code = $result['country_id'];
        $mobile_no = $result['mobile_no'];
        $data1 = array(
            
                'user_id' =>$result['user_id'],
                'otp' =>$mobile_otp
            
            );
        
        $result1=$this->driver_model->sendotpmsg($mobile_no,$message,$country_code);
        
        
                $update_data=array('driver_otp' => $mobile_otp, 'device_id' => $device_id, 'device_token' => $device_token, 'last_login_date' => $date);
                $where1 = array('id' => $result['user_id']);
    		    $this->db->update('ci_drivers', $update_data, $where1);
                
          
        if($result['mobile_no']!=''){
            $message = array(
                    'status' => 'true',
                    'message' => 'Login successful!!',
                    'data' => $result
                );
        }else{
            $message = array(
                'status' => 'false',
                'message' => 'This email/phone number is not registered!!',
                'data' => NULL
                );
        }
        }else{
            
            $message = array(
                'status' => 'false',
                'message' => 'Email/phone number is inactive!!',
                'data' => NULL
                ); 
            
        }
        
        }else{
            
           $message = array(
                'status' => 'false',
                'message' => 'This email/phone number is not registered!!',
                'data' => NULL
                ); 
            
            
        }
        
        
        $this->set_response($message, REST_Controller::HTTP_OK);
    }




public function otpVerification_post(){

        $data = array(
                'id' => $this->post('user_id'),
                'driver_otp' => $this->post('otp')
            );
        $result = $this->driver_model->verify_otp($data);
        if(!empty($result)){
            $message = array(
                    'status' => 'true',
                    'message' => 'OTP Matched!!',
                    'data' => $result
                );
        }else{
            $message = array(
                'status' => 'false',
                'message' => 'Sorry, OTP doesn’t match!!',
                'data' => NULL
                );
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

  
    public function change_driver_password_post(){
        $data = array(
                'password'         =>  $this->post('new_password'),
                'user_id'          =>  $this->post('user_id')
            );
        $old_password  =  $this->post('old_password');
        $user_info = $this->driver_model->get_driver_info($data['user_id']);
        if($user_info->password == $old_password){
            $result = $this->driver_model->change_driver_password($data);
            if($result){
                $message = array(
                        'status' => 1,
                        'message' => 'Password updated successfully.',
                        'data' => NULL
                    );
            }else{
                $message = array(
                    'status' => 0,
                    'message' => 'Something goes wrong!',
                    'data' => NULL
                    );
            }
        }else{
            $message = array(
                    'status' => 0,
                    'message' => 'Wrong old password.',
                    'data' => NULL
                    );
        }


        $this->set_response($message, REST_Controller::HTTP_OK);

    }

  
    public function forgotpass_post(){
       $email   =  $this->post('email');
        
         $email_exists = $this->driver_model->user_check_email($email);
        
        if($email_exists){
        $result = $this->driver_model->forgot_pass($email);
        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Password Sent Successfully.',
                    'data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Email ID Not Exist ',
                'data' => NULL
                );
        }
    }else{
            $message = array(
                    'status' => 0,
                    'message' => 'Email not found in our database!',
                    'data' => NULL
                    );
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

  
 
   public function productListing_get(){
       // $userid=$this->get('userid');
        $result=$this->driver_model->product_list();
        if(!empty($result)){
             $message = array(
                    'status' => 1,
                    'message' => 'Product List Found.',
                    'data' => $result
                );
        }else{
            $message = array(
                    'status' => 0,
                    'message' => 'Product Not Found.',
                    'data' => $result
                );
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }
  
  
  public function itemListing_get(){
       // $userid=$this->get('userid');
        $result=$this->driver_model->item_list();
        if(!empty($result)){
             $message = array(
                    'status' => 1,
                    'message' => 'Shipping items List Found.',
                    'data' => $result
                );
        }else{
            $message = array(
                    'status' => 0,
                    'message' => 'Shipping items Not Found.',
                    'data' => $result
                );
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }
  
  
  
  
    public function driver_profile_post(){
        $userid=$this->post('driver_id');
        $result=$this->driver_model->get_driver($userid);
        if(!empty($result)){
             $message = array(
                    'status' => 1,
                    'message' => 'Profile Found.',
                    'data' => $result
                );
        }else{
            $message = array(
                    'status' => 0,
                    'message' => 'Profile Not Found.',
                    'data' => NULL
                );
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }
  


    public function dashboard_get(){
        $user_id = $this->get('user_id');
        $result = $this->driver_model->get_dashboard1($user_id);

        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'No details Found.',
                'data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
  
        

public function check_mobile_number_post()
      {
          $mobile_no = $this->post('mobile_no');
          $country_code=$this->post('country_code');
          $mobile = $this->driver_model->checknumber($mobile_no,$country_code);
          
        //  print_r($mobile);die();
          
         if($mobile){
               $message = array(
                        'status' => 1,
                        'message' => 'Mobile Number Verified',
                        'data' => $mobile
                    );
             }else{
               $message = array(
                        'status' => 0,
                        'message' => 'Mobile number is not Verified',
                        'data' => null
                    );
            }
            
            $this->set_response($message, REST_Controller::HTTP_OK);
       }
    





public function driver_otp_post(){
        $mobile_no=$this->post('mobile_no');
         $message=$this->post('message');
          $country_code=$this->post('country_code');
        $result=$this->driver_model->sendmsg($mobile_no,$message,$country_code);

//print_r($result);

        if ($result) {
             $message = array(
                    'status' => 1,
                    'message' => 'Profile Found.',
                    'data' => $result
                );
        }else{
            $message = array(
                    'status' => 0,
                    'message' => 'Profile Not Found.',
                    'data' => $result
                );
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }
    
    
    
      public function jobListing_post(){
       
        $user_id = $this->post('user_id');
        $driver_exists = $this->driver_model->drivers_id_exists($user_id);
        if($driver_exists>0){
        
        $user_exists = $this->driver_model->user_check_type($user_id);
         if(!empty($user_exists)){
            $user_type = $user_exists['driver_type'];
         }else{
            $user_type = '';
         }



        if($user_type=='pickup'){
           $result = $this->driver_model->get_alldriversjoblist($user_id); 
            if(!empty($result)){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No jobs available for you!!',
                'jobs_data' => NULL
                );
        }
        }elseif($user_type=='destination'){
           $result = $this->driver_model->get_seconddriverjoblisting($user_id); 
            if(!empty($result)){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No jobs for you!!',
                'jobs_data' => NULL
                );
        }
        }elseif($user_type==''){


            $message = array(
                'status' => 0,
                'message' => 'No Driver Available!!',
                'jobs_data' => NULL
                );

        }
        
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No Driver Found!!',
                'jobs_data' => NULL
                );
        }
       

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
    
    
    
    public function sendtowarehouse_post(){
        $job_id = $this->post('job_id');
        $ware_id = $this->post('ware_id');
        $user_id = $this->post('user_id');
        
        
        $update_data=array('warehouseid' => $ware_id, 'job_status' =>'1');
        $where1 = array('id' => $job_id);
    	$this->db->update('ci_booking', $update_data, $where1);
       
        
        $result = $this->driver_model->get_joblist($user_id);

        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No jobs for you!!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
     
    public function deliveryjobListing_post(){
        $user_id = $this->post('user_id');
        
        $result = $this->driver_model->get_deliverjoblist($user_id);

        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No jobs for you!!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
    public function singleDelivery_post(){
        $user_id = $this->post('user_id');
        $job_id = $this->post('job_id');
        
        
        
        $result = $this->driver_model->get_djoblist($user_id,$job_id);

        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No record found!!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
    
    public function reciverUpdate_post(){
        $user_id = $this->post('user_id');
        $job_id = $this->post('job_id');



        
        $activity_data = array(
                             'client_name'       =>  $this->post('client_name'),
                             'client_phone'       =>  $this->post('client_phone')
                                
                     );
              
              
           
            $this->db->where('id', $job_id);
            $dbs = $this->db->update('ci_booking', $activity_data);
        
        $result = $this->driver_model->get_djoblist($user_id,$job_id);

        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Successfully Updated Records',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Something goes wrong!!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
   
    public function emergencyJobListing_post(){
        $user_id = $this->post('user_id');


         $user_exists = $this->driver_model->user_check_type($user_id);
         if(!empty($user_exists)){
            $user_type = $user_exists['driver_type'];
         }else{
            $user_type = '';
         }


if($user_type=='pickup'){
           $result = $this->driver_model->get_firstdriveremergencyjoblist($user_id);
            if(!empty($result)){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No jobs available for you!!',
                'jobs_data' => NULL
                );
        }
        }elseif($user_type=='destination'){
           $result = $this->driver_model->get_seconddriveremergencyjoblist($user_id);
            if(!empty($result)){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No jobs for you!!',
                'jobs_data' => NULL
                );
        }
        }



        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    public function jobProductListing_post(){
        $job_id = $this->post('job_id');
        
        $result = $this->driver_model->get_productList($job_id);

        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'products' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No jobs found!!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
  
    public function addtocart_post(){
        
         $job_id = $this->post('job_id');
         $job_exists = $this->driver_model->job_exists($job_id);
        if($job_exists>0){
                $shipdata = array(
                    'ship_status' => 1
                );
        $this->db->where('id', $job_id);
        $dbs = $this->db->update('ci_booking', $shipdata);
        $product_quantity = $this->post('item_quantity');
            
            $product_name = $this->post('item_name');
            $product_id = $this->post('item_id');
            $product_prices = $this->post('item_price');   
            $product_price = number_format($product_prices,2,'.','');
            $price_ranges = $this->post('price_range');   
            $price_range = number_format($price_ranges,2,'.','');
            $product_image = $this->post('item_image');
            $date = date("Y-m-d H:i:s");
            $time = $date;
                    if(!empty($_FILES)){
                        $filename = $_FILES["item_image"]["name"];
                        $filetype = $_FILES["item_image"]["type"];
                        $filesize = $_FILES["item_image"]["size"]; 

                        $file_data = array(
                                   'name'       =>  $filename,
                                   'type'        => $filetype,
                                   'size'        => $filesize
                                  ); 
                        $uploads_dir = "uploads/product/";
                        $tmp_name = $_FILES["item_image"]["tmp_name"];
                        $name = $_FILES["item_image"]["name"];
                        move_uploaded_file($tmp_name, "$uploads_dir/$name");
                        $activity_image = $name;
                    }else{
                        $activity_image ='';
                    }   
                     
                        $check_exist = $this->driver_model->product_exist($job_id,$product_id);             
                            if($check_exist>0){
                                if($activity_image==''){
                                    $activity_data = array(
                                     'job_id'       =>  $job_id,
                                     'product_id'       =>  $product_id,
                                     'product_name'       =>  $product_name,
                                     'product_qty'       =>  $product_quantity,
                                     'product_price'       =>  $product_price,
                                     'price_range'       =>  $price_range,
                                     'created_at'    =>  $time
                                        
                                                 );
                                }else{
                                      $activity_data = array(
                                                 'job_id'       =>  $job_id,
                                                 'product_id'       =>  $product_id,
                                                 'product_name'       =>  $product_name,
                                                 'product_qty'       =>  $product_quantity,
                                                 'product_price'       =>  $product_price,
                                                 'price_range'       =>  $price_range,
                                                 'product_image'    =>  $activity_image,
                                                 'created_at'    =>  $time
                                                    
                                         );
                                }
                                    $this->db->where('product_id', $product_id);
                                    $this->db->where('job_id', $job_id);
                                    $dbs = $this->db->update('ci_jobproduct', $activity_data);
                            }else{
                                  $items = $this->driver_model->item_count();
                                  $newitem = ($items+1);
                                if($product_id==''){
                                    $checkproductname = $this->driver_model->productname_exist($product_name); 
                                    if($checkproductname>0){
                                        $product_exists = $this->driver_model->user_check_product($product_name);
                                        $item_name = $product_exists['item_name'];
                                        $items_id = $product_exists['ship_id'];
                                        if($activity_image==''){
                                              $activity_datas0 = array(
                                                         'job_id'       =>  $job_id,
                                                         'product_id'       =>  $items_id,
                                                         'product_name'       =>  $product_name,
                                                         'product_qty'       =>  $product_quantity,
                                                         'product_price'       =>  $product_price,
                                                         'price_range'       =>  $price_range,
                                                         'created_at'    =>  $time
                                                            
                                                 );
                                        }else{
                                              $activity_datas0 = array(
                                                         'job_id'       =>  $job_id,
                                                         'product_id'       =>  $items_id,
                                                         'product_name'       =>  $product_name,
                                                         'product_qty'       =>  $product_quantity,
                                                         'product_price'       =>  $product_price,
                                                         'price_range'       =>  $price_range,
                                                         'product_image'    =>  $activity_image,
                                                         'created_at'    =>  $time
                                                            
                                                 );
                                        }
                                        $results = $this->db->insert('ci_jobproduct', $activity_datas0);
            
                                    }else{
                                           
                                           $item_array = array(
                                                     'ship_id'       =>  $newitem,
                                                     'item_name'       =>  $product_name,
                                                     'item_quantity'       =>  '100',
                                                     'is_verify'       =>  '1',
                                                     'is_admin'       =>  '1',
                                                     'is_active'    =>  '1',
                                                     'created_at'    =>  $time
                                                        
                                             );
                                            if($activity_image==''){
                                                  $activity_datas1 = array(
                                                             'job_id'       =>  $job_id,
                                                             'product_id'       =>  $newitem,
                                                             'product_name'       =>  $product_name,
                                                             'product_qty'       =>  $product_quantity,
                                                             'product_price'       =>  $product_price,
                                                             'price_range'       =>  $price_range,
                                                             'created_at'    =>  $time
                                                                
                                                     );
                                            }else{
                                                  $activity_datas1 = array(
                                                             'job_id'       =>  $job_id,
                                                             'product_id'       =>  $newitem,
                                                             'product_name'       =>  $product_name,
                                                             'product_qty'       =>  $product_quantity,
                                                             'product_price'       =>  $product_price,
                                                             'price_range'       =>  $price_range,
                                                             'product_image'    =>  $activity_image,
                                                             'created_at'    =>  $time
                                                                
                                                     );
                                            }
                                          $results = $this->db->insert('ci_jobproduct', $activity_datas1);
                                          $add_item = $this->db->insert('ci_shippingitem', $item_array);  
                                    }
               
                                }else{
                 
                 
                                    if($activity_image==''){
                                                      $activity_datas2 = array(
                                                                 'job_id'       =>  $job_id,
                                                                 'product_id'       =>   $product_id,
                                                                 'product_name'       =>  $product_name,
                                                                 'product_qty'       =>  $product_quantity,
                                                                 'product_price'       =>  $product_price,
                                                                 'price_range'       =>  $price_range,
                                                                 'created_at'    =>  $time
                                                                    
                                                         );
                                                  }else{
                                                      $activity_datas2 = array(
                                                                 'job_id'       =>  $job_id,
                                                                 'product_id'       =>   $product_id,
                                                                 'product_name'       =>  $product_name,
                                                                 'product_qty'       =>  $product_quantity,
                                                                 'product_price'       =>  $product_price,
                                                                 'price_range'       =>  $price_range,
                                                                 'product_image'    =>  $activity_image,
                                                                 'created_at'    =>  $time
                                                                    
                                                         );
                                                  }
                                                  
            
                                    $results = $this->db->insert('ci_jobproduct', $activity_datas2);
                                }
                            }
          
                            $result = $this->driver_model->get_productListing($job_id);

                        if($result){
                            $message = array(
                                    'status' => 1,
                                    'message' => 'Success',
                                    'products' => $result
                                );
                        }else{
                            $message = array(
                                'status' => 0,
                                'message' => 'Sorry, No Product Added!!',
                                'jobs_data' => NULL
                                );
                        }
        
        
                                }else{
                                    
                                    $message = array(
                                        'status' => 0,
                                        'message' => 'No Jobs Available!!',
                                        'jobs_data' => NULL
                                        );
                                }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
    public function addstocarts_post(){
        
        $product_quantity = $this->post('item_quantity');
        
        if($product_quantity<'10'){
            
            $product_name = $this->post('item_name');
            $job_id = $this->post('job_id');
        $product_id = $this->post('item_id');
            
            
         
        $product_price = $this->post('item_price');
        $product_image = $this->post('item_image');
        $price_range = $this->post('price_range');
        $date = date("Y-m-d H:i:s");
        $time = $date;
        
         $filename = $_FILES["item_image"]["name"];
                 $filetype = $_FILES["item_image"]["type"];
                 $filesize = $_FILES["item_image"]["size"]; 

                 
                 $file_data = array(
                                'name'       =>  $filename,
                                'type'        => $filetype,
                                'size'        => $filesize
                      ); 
      
       // $uploads_dir = $this->product_imagepath;
        $uploads_dir = "uploads/product/";
        
                $tmp_name = $_FILES["item_image"]["tmp_name"];
                $name = $_FILES["item_image"]["name"];
                move_uploaded_file($tmp_name, "$uploads_dir/$name");
                
                $activity_image = $name;
                
                     
                     
           //  print_r($activity_data);exit;        
        $check_exist = $this->driver_model->product_exist($job_id,$product_id);             
          
          if($check_exist>0){
              if($activity_image==''){
                  $activity_data = array(
                             'job_id'       =>  $job_id,
                             'product_id'       =>  $product_id,
                             'product_name'       =>  $product_name,
                             'product_qty'       =>  $product_quantity,
                             'product_price'       =>  $product_price,
                             'price_range'       =>  $price_range,
                             'created_at'    =>  $time
                                
                     );
              }else{
                  $activity_data = array(
                             'job_id'       =>  $job_id,
                             'product_id'       =>  $product_id,
                             'product_name'       =>  $product_name,
                             'product_qty'       =>  $product_quantity,
                             'product_price'       =>  $product_price,
                             'price_range'       =>  $price_range,
                             'product_image'    =>  $activity_image,
                             'created_at'    =>  $time
                                
                     );
              }
              
              
              
              $this->db->where('product_id', $product_id);
              $this->db->where('job_id', $job_id);
            $dbs = $this->db->update('ci_jobproduct', $activity_data);
              
             
          }else{
              $items = $this->driver_model->item_count();
              $newitem = ($items+1);
              
                 if($product_id==''){
               $checkproductname = $this->driver_model->productname_exist($product_name); 
               
               if($checkproductname>0){
                 $product_exists = $this->driver_model->user_check_product($product_name);
                                        $item_name = $product_exists['item_name'];
                                        $items_id = $product_exists['ship_id'];
                 
                 
              if($activity_image==''){
                  $activity_datas0 = array(
                             'job_id'       =>  $job_id,
                             'product_id'       =>  $items_id,
                             'product_name'       =>  $product_name,
                             'product_qty'       =>  $product_quantity,
                             'product_price'       =>  $product_price,
                             'price_range'       =>  $price_range,
                             'created_at'    =>  $time
                                
                     );
              }else{
                  $activity_datas0 = array(
                             'job_id'       =>  $job_id,
                             'product_id'       =>  $items_id,
                             'product_name'       =>  $product_name,
                             'product_qty'       =>  $product_quantity,
                             'product_price'       =>  $product_price,
                             'price_range'       =>  $price_range,
                             'product_image'    =>  $activity_image,
                             'created_at'    =>  $time
                                
                     );
              }
              
                   
                  // print_r($activity_datas0);
                 $results = $this->db->insert('ci_jobproduct', $activity_datas0);
            
              
               }else{
                   
                   $item_array = array(
                             'ship_id'       =>  $newitem,
                             'item_name'       =>  $product_name,
                             'item_quantity'       =>  '100',
                             'is_verify'       =>  '1',
                             'is_admin'       =>  '1',
                             'is_active'    =>  '1',
                             'created_at'    =>  $time
                                
                     );
              if($activity_image==''){
                  $activity_datas1 = array(
                             'job_id'       =>  $job_id,
                             'product_id'       =>  $newitem,
                             'product_name'       =>  $product_name,
                             'product_qty'       =>  $product_quantity,
                             'product_price'       =>  $product_price,
                             'price_range'       =>  $price_range,
                             'created_at'    =>  $time
                                
                     );
              }else{
                  $activity_datas1 = array(
                             'job_id'       =>  $job_id,
                             'product_id'       =>  $newitem,
                             'product_name'       =>  $product_name,
                             'product_qty'       =>  $product_quantity,
                             'product_price'       =>  $product_price,
                             'price_range'       =>  $price_range,
                             'product_image'    =>  $activity_image,
                             'created_at'    =>  $time
                                
                     );
              }
              
                   
                   
                 //print_r($activity_datas1);
                 //  print_r($item_array); 
               
                  $results = $this->db->insert('ci_jobproduct', $activity_datas1);
              $add_item = $this->db->insert('ci_shippingitem', $item_array);  
                   
               }
               
               
                 
             }else{
                 
                 
                
              if($activity_image==''){
                  $activity_datas2 = array(
                             'job_id'       =>  $job_id,
                             'product_id'       =>   $product_id,
                             'product_name'       =>  $product_name,
                             'product_qty'       =>  $product_quantity,
                             'product_price'       =>  $product_price,
                             'price_range'       =>  $price_range,
                             'created_at'    =>  $time
                                
                     );
              }else{
                  $activity_datas2 = array(
                             'job_id'       =>  $job_id,
                             'product_id'       =>   $product_id,
                             'product_name'       =>  $product_name,
                             'product_qty'       =>  $product_quantity,
                             'product_price'       =>  $product_price,
                             'price_range'       =>  $price_range,
                             'product_image'    =>  $activity_image,
                             'created_at'    =>  $time
                                
                     );
              }
              
              // print_r($activity_datas2);  
                 $results = $this->db->insert('ci_jobproduct', $activity_datas2);
             }
              
            
              
            //  exit;
            //  $results = $this->db->insert('ci_jobproduct', $activity_datas);
            //  $add_item = $this->db->insert('ci_shippingitem', $item_array);
          }
          
        $result = $this->driver_model->get_productListing($job_id);

        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'products' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No jobs for your location!!',
                'jobs_data' => NULL
                );
        }
        }else{
            
            $message = array(
                'status' => 0,
                'message' => 'More than 10 product quantity not allowed!!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
    
    function removecart_post()
    {   
        
        $rowid = $this->post('item_id');
        $job_id = $this->post('job_id');

        $job_exists = $this->driver_model->job_exists($job_id);
         if($job_exists>0){

        
        $result = $this->driver_model->removecart_update($rowid,$job_id);
        $results = $this->driver_model->get_productListing($job_id);
        if($result === FALSE)
        {
            
            $message = array(
                'status' => 0,
                'message' => 'Order Not Removed. Please try again!',
                'jobs_data' => NULL
                );
        }
        else
        {
            
            $message = array(
                    'status' => 1,
                    'message' => 'Order Removed successfully',
                    'products' => $results
                );
            
            
        }
    

        }else
        {
            
            $message = array(
                    'status' => 1,
                    'message' => 'No Job Available',
                    'products' => $results
                );
            
            
        }
        
         $this->set_response($message, REST_Controller::HTTP_OK);
    }
    
    
    
    public function jobsProductListing_post(){
        $job_id = $this->post('job_id');
        
        
        $result = $this->driver_model->get_productListing($job_id);

        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No jobs Products found!!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
    
    public function notifydata_post(){
                $job_id = $this->post('job_id');
                $driver_id = $this->post('driver_id');
                $user_exists = $this->driver_model->user_check_type($driver_id);
                $user_type = $user_exists['driver_type']; 
                $user_mobile = $user_exists['mobile_no']; 
                $msg = $this->post('message').',';
                
                
                $mobile_otp = mt_rand(2000,9000); 
        $date = date('Y-m-d');
        $message = 'Your Order Otp Verification code is :' .$mobile_otp;
        $country_code = $user_exists['country_id'];
       
        $msg = $this->post('message').','.$message;
       
        
              
                    $data = array( 
                             'job_id'   =>  $job_id,
                             'driver_id'        =>  $driver_id,
                             'driver_type'        =>  $user_type,
                             'message'             =>  $msg,
                             'message_otp'             =>  $mobile_otp,
                             'read_sender'     => '1',
                             'read_receiver'    => '1',
                             'status'    => '0',
                             'msg_date'          => date('Y-m-d')
                           
                    );
                    
                    
                $msg_exists = $this->driver_model->user_check_msg($job_id,$driver_id,$user_type);    
                  if($msg_exists){
                      
                      $msg_id = $msg_exists['msg_id'];
                      
                      $this->db->where('msg_id', $msg_id);
                $result = $this->db->update('ci_message', $data);  
                      
                  }else{
                      
                     $result = $this->db->insert('ci_message', $data); 
                  }
                
                        
    
                    if($result){
                    $result1=$this->driver_model->sendotpmsg($user_mobile,$msg,$country_code);
                        $message = array(
                                'status' => 1,
                                'message' => 'Notification added successfully.',
                                'data' => $result
                            );
                        
                        }else{
                        $message = array(
                            'status' => 0,
                            'message' => 'Something goes wrong!',
                            'data' => NULL
                            );
                        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    } 
    
    
    
    public function orderOtpVerification_post(){
                $job_id = $this->post('job_id');
                $driver_id = $this->post('driver_id');
                $otp = $this->post('otp');
                $user_exists = $this->driver_model->order_check_type($driver_id,$otp,$job_id);
                
                         
    
                    if($user_exists!=''){
                        $user_message = $user_exists['message']; 
                  //  $result1=$this->driver_model->sendotpmsg($user_mobile,$msg,$country_code);
                        $message = array(
                                'status' => 1,
                                'message' => 'Verification successful.',
                                'data' => $user_message
                            );
                        
                        }else{
                        $message = array(
                            'status' => 0,
                            'message' => 'Not Verify, Please try again!',
                            'data' => NULL
                            );
                        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    } 
    
    
    
    
public function saveqr_post(){
        $job_id = $this->post('job_id');
        $job_exists = $this->driver_model->job_exists($job_id);
        if($job_exists>0){
        $qr_code = $this->post('qr_code');
        
        $product_image = $this->post('qr_image');
        $date = date("Y-m-d H:i:s");
        $time = $date;
        if(!empty($_FILES)){
         $filename = $_FILES["qr_image"]["name"];
                 $filetype = $_FILES["qr_image"]["type"];
                 $filesize = $_FILES["qr_image"]["size"]; 

                 
                 $file_data = array(
                                'name'       =>  $filename,
                                'type'        => $filetype,
                                'size'        => $filesize
                      ); 
      
       // $uploads_dir = $this->product_imagepath;
        $uploads_dir = "uploads/qrcode/";
        
                $tmp_name = $_FILES["qr_image"]["tmp_name"];
                $name = $_FILES["qr_image"]["name"];
                move_uploaded_file($tmp_name, "$uploads_dir/$name");
                
                $activity_image = $name;
                
        }else{
            $activity_image = '';
        }        
                     
           //  print_r($activity_data);exit;        
        
        $user_exists = $this->driver_model->user_check_qrcode($job_id);
        
        
          if($user_exists!=''){
              
              $activity_data = array(
                             'job_id'       =>  $job_id,
                             'qr_code'       =>  $qr_code,
                             'qr_image'       =>  $activity_image,
                             'updated_at'    =>  $time
                                
                     );
              
              
             $this->db->where('job_id', $job_id);
            $dbs = $this->db->update('ci_jobqrcode', $activity_data);



                    $jobdata = array(
                      'ship_status' => '1'
                      
                      );
                    
                $this->db->where('id', $job_id);
                $jbs = $this->db->update('ci_booking', $jobdata); 
              
             
          }else{
              $activity_datas = array(
                             'job_id'       =>  $job_id,
                             'qr_code'       =>  $qr_code,
                             'qr_image'       =>  $activity_image,
                             'created_at'    =>  $time
                                
                     );
              
             
              
              $results = $this->db->insert('ci_jobqrcode', $activity_datas);

              $jobdata = array(
                      'ship_status' => '1'
                      
                      );
                    
                $this->db->where('id', $job_id);
                $jbs = $this->db->update('ci_booking', $jobdata); 
            
          }
          
        $result = $this->driver_model->get_qrListing($job_id);

        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'products' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Something goes wrong!',
                'jobs_data' => NULL
                );
        }
        }else{
            
            $message = array(
                'status' => 0,
                'message' => 'No Job Available!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
    public function paymentData_post(){
                $job_id = $this->post('job_id');
                $job_exists = $this->driver_model->job_exists($job_id);
        if($job_exists>0){
                
                $payer_name = $this->post('payerName');
                $amounts = $this->post('paymentAmount');

                $amount = number_format($amounts,2,'.','');
                $mobile = $this->post('mobile');
                $payment_type = $this->post('payment_type');
               
                
                if($payment_type=='Cash'){
                    $payment_gateway = 'Cash on Delivery';
                    $payment_id = mt_rand(100000, 999999);
                    $pay_method = 'cod';
                }elseif($payment_type=='cod'){
                    $payment_gateway = 'Cash on Delivery';
                    $payment_id = mt_rand(100000, 999999);
                    $pay_method = 'cod';
                }elseif($payment_type=='cash'){
                    $payment_gateway = 'Cash on Delivery';
                    $payment_id = mt_rand(100000, 999999);
                    $pay_method = 'cod';
                }else{
                    $payment_id = $this->post('payment_id');
                     $payment_gateway = 'Paypal or Card Payment';
                     $pay_method = 'credit_card';
                }
                
                
                
                $status = $this->post('paymentStatus');
                $txn_id = mt_rand(10000000, 99999999);
               
                $data = array( 
                             'job_id'   =>  $job_id,
                             'amount'   =>  $amount,
                             'mobile'   =>  $mobile,
                             'payer_name'   =>  $payer_name,
                             'status'   =>  $status,
                             'payment_id' => $payment_id,
                             'payment_type' => $payment_type,
                             'payment_gateway' => $payment_gateway,
                             'txn_id'    => $txn_id,
                             'payment_date'          =>  date('Y-m-d')
                           
                    );
               
               
               $pay = $this->driver_model->payment_exist($job_id,$payment_id); 
               
               if($pay>0){
                $status = $this->post('paymentStatus');   
                $this->db->where('job_id', $job_id);
                $this->db->where('payment_id', $payment_id);
                $dbs = $this->db->update('ci_paymetsdetail', $data);  
                if($status=='1'){
                  
                  $jobdata = array(
                      'payment_status' => 'Paid',
                      'ship_status' => '2',
                      'payment_method' => $pay_method,
                      'grand_total' => $amount
                      
                      );
                    
                $this->db->where('id', $job_id);
                $jbs = $this->db->update('ci_booking', $jobdata);  
                }
               
               
                   
               }else{
                   
                $this->db->insert("ci_paymetsdetail", $data); 
                
                
                if($status=='1'){
                  
                  $jobdata = array(
                      'payment_status' => 'Paid',
                      'ship_status' => '2',
                      'payment_method' => $pay_method,
                      'grand_total' => $amount
                      
                      );
                    
                $this->db->where('id', $job_id);
                $jbs = $this->db->update('ci_booking', $jobdata);  
                }
                
                
                
               }
               
                $result = $this->driver_model->get_paymentListing($job_id,$payment_id);    
    
                    if($result){

                        $message = array(
                                'status' => 1,
                                'message' => 'Payment added successfully.',
                                'data' => $result
                            );
                        
                        }else{
                        $message = array(
                            'status' => 0,
                            'message' => 'Something goes wrong!',
                            'data' => NULL
                            );
                        }
        }else{
                        $message = array(
                            'status' => 0,
                            'message' => 'Jobs not Available!',
                            'data' => NULL
                            );
                        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    } 
    
    
    
    public function addSignature_post(){
        $job_id = $this->post('job_id');
        $driver_id = $this->post('driver_id');
        $job_exists = $this->driver_model->job_exists($job_id);
        if($job_exists>0){
        
        $driver_exists = $this->driver_model->drivers_id_exists($driver_id);
        
        if($driver_exists>0){
        
        $product_image = $this->post('signature_image');
        $date = date("Y-m-d H:i:s");
        $time = $date;
        $user_exists = $this->driver_model->user_check_type($driver_id);
        if(!empty($user_exists)){
            $user_type = $user_exists['driver_type']; 
         }else{
            $user_type = '';
         }

                
        if(!empty($_FILES)){
         $filename = $_FILES["signature_image"]["name"];
                 $filetype = $_FILES["signature_image"]["type"];
                 $filesize = $_FILES["signature_image"]["size"]; 

                 
                 $file_data = array(
                                'name'       =>  $filename,
                                'type'        => $filetype,
                                'size'        => $filesize
                      ); 
      
       // $uploads_dir = $this->product_imagepath;
        $uploads_dir = "uploads/signature/";
        
                $tmp_name = $_FILES["signature_image"]["tmp_name"];
                $name = $_FILES["signature_image"]["name"];
                move_uploaded_file($tmp_name, "$uploads_dir/$name");
                
                $activity_image = $name;
        }else{
            
            $activity_image = '';
        }  
        
         if($activity_image==''){
              $activity_data = array(
                             'job_id'       =>  $job_id,
                             'driver_id'       =>  $driver_id,
                             'sign_date'    =>  date('Y-m-d'),
                             'created_at'    =>  $time
                                
                     ); 
             
         }else{
             
              $activity_data = array(
                             'job_id'       =>  $job_id,
                             'driver_id'       =>  $driver_id,
                             'client_image'    =>  $activity_image,
                             'sign_date'    =>  date('Y-m-d'),
                             'created_at'    =>  $time
                                
                     ); 
         }
        
        
                   
                     
           //  print_r($activity_data);exit;        
        $check_exist = $this->driver_model->sign_exist($job_id,$driver_id);             
          
          if($check_exist>0){
              
              $this->db->where('driver_id', $driver_id);
              $this->db->where('job_id', $job_id);
            $dbs = $this->db->update('ci_signature', $activity_data);
              
             
          }else{
              $add_item = $this->db->insert('ci_signature', $activity_data);
          }
          
        $result = $this->driver_model->get_signatureListing($job_id,$driver_id);
        
       
        if(!empty($result)){    
            if($user_type=='pickup'){
                $dataarray = array(
                'pickup_status' => '1',
                'ship_status' => '3',
                'job_status' => '1',
                'pick_comp_date' => date('Y-m-d')
                );
            }else{
                
                $dataarray = array(
                'delivery_status' => '1',
                'ship_status' => '4',
                'job_status' => '2',
                'drop_comp_date' => date('Y-m-d')
                );
            }
            
            
            
            
            
             $this->db->where('id', $job_id);
            $dbs = $this->db->update('ci_booking', $dataarray);
            
        }
        
        
        if(!empty($result)){  
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Something goes wrong!',
                'jobs_data' => NULL
                );
        }
        }else{
            
            $message = array(
                'status' => 0,
                'message' => 'Driver not Available!',
                'jobs_data' => NULL
                );
        }
        }else{
            
            $message = array(
                'status' => 0,
                'message' => 'Job not Available!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    public function allbookingListing_post(){
        $user_id = $this->post('driver_id');
        $driver_exists = $this->driver_model->drivers_id_exists($user_id);
        if($driver_exists>0){
        
        $user_exists = $this->driver_model->user_check_type($user_id);
        $user_type = $user_exists['driver_type']; 
        if($user_type=='pickup'){
            
            $result = $this->driver_model->get_allcjoblist($user_id);
            
        }else{
            
           $result = $this->driver_model->get_allcdestinationjoblist($user_id); 
            
        }
        
        
        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No jobs found!!',
                'jobs_data' => NULL
                );
        }
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No Driver Found!!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
    
    public function completebookingListing_post(){
        $user_id = $this->post('driver_id');
        $driver_exists = $this->driver_model->drivers_id_exists($user_id);
        if($driver_exists>0){


         $user_exists = $this->driver_model->user_check_type($user_id);
         if(!empty($user_exists)){
            $user_type = $user_exists['driver_type'];
         }else{
            $user_type = '';
         }

    
        if($user_type=='pickup'){
           $result = $this->driver_model->get_processjoblist($user_id); 
            if(!empty($result)){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No jobs found!!',
                'jobs_data' => NULL
                );
        }
        }elseif($user_type=='destination'){
           $result = $this->driver_model->get_destinationprocessjoblist($user_id); 
            if(!empty($result)){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No jobs found!!',
                'jobs_data' => NULL
                );
        }
        }elseif($user_type==''){


            $message = array(
                'status' => 0,
                'message' => 'No User Available!!',
                'jobs_data' => NULL
                );

        }
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No Driver Found!!',
                'jobs_data' => NULL
                );
        }


       $this->set_response($message, REST_Controller::HTTP_OK);

    }





    public function detailListing_post(){
        $user_id = $this->post('driver_id');
        $job_id = $this->post('job_id');

        $job_exists = $this->driver_model->job_exists($job_id);
        if($job_exists>0){
        $driver_exists = $this->driver_model->drivers_id_exists($user_id);
        if($driver_exists>0){

         $user_exists = $this->driver_model->user_check_type($user_id);
         if(!empty($user_exists)){
            $user_type = $user_exists['driver_type'];
         }else{
            $user_type = '';
         }

    
        if($user_type=='pickup'){
           $result = $this->driver_model->get_joblistdetail($user_id,$job_id); 
            if(!empty($result)){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, no record available!!',
                'jobs_data' => NULL
                );
        }
        }elseif($user_type=='destination'){
           $result = $this->driver_model->get_destinationjoblistdetail($user_id,$job_id); 
            if(!empty($result)){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, no jobs found!!',
                'jobs_data' => NULL
                );
        }
        }elseif($user_type==''){


            $message = array(
                'status' => 0,
                'message' => 'No User Available!!',
                'jobs_data' => NULL
                );

        }
    } else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, no Driver found!!',
                'jobs_data' => NULL
                );
        }

     } else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, no Job found!!',
                'jobs_data' => NULL
                );
        }   

       $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
    
    
    function amountdetail_post()
    {   
        
        $job_id = $this->post('job_id');
        $driver_id = $this->post('driver_id');
       
        
        $driver_exists = $this->driver_model->drivers_id_exists($driver_id);
        if($driver_exists>0){
       
       $user_exists = $this->driver_model->user_check_payment($job_id,$driver_id);
        
        if(!empty($user_exists)){
       if($user_exists){
       
        $result = $this->driver_model->finalvale($job_id,$driver_id);
       
        if($result === FALSE)
        {
            
            $message = array(
                'status' => 0,
                'message' => 'Price Not Get. Please try again!',
                'data' => NULL
                );
        }
        else
        {
            
            $message = array(
                    'status' => 1,
                    'message' => 'Price Get successfully',
                    'data' => $user_exists
                );
            
            
        }
       }else{
           
           $message = array(
                    'status' => 1,
                    'message' => 'Already Paid',
                    'data' => $user_exists
                );
           
       }
        }else{
            
           $message = array(
                                'status' => 0,
                                'message' => 'Job not available',
                                'data' => null
                            ); 
            
        }
   }else{
            $message = array(
                                'status' => 0,
                                'message' => 'Driver not available',
                                'data' => null
                            );
               }
        
         $this->set_response($message, REST_Controller::HTTP_OK);
   
    }
    
    
    
    function detailProductlist_post()
    {   
        
        $job_id = $this->post('job_id');
        $product_id = $this->post('product_id');

         $job_exists = $this->driver_model->job_exists($job_id);
         if($job_exists>0){

         $product_exists = $this->driver_model->product_exists($job_id,$product_id);
       if($product_exists>0){
        $result = $this->driver_model->get_finaljoblist($job_id,$product_id);
       
        if($result === FALSE)
        {
            
            $message = array(
                'status' => 0,
                'message' => 'Detail not found. Please try again!',
                'data' => NULL
                );
        }
        else
        {
            
            $message = array(
                    'status' => 1,
                    'message' => 'Detail found',
                    'data' => $result
                );
            
            
        }
    }else{
    	$message = array(
                    'status' => 1,
                    'message' => 'Product Not found',
                    'data' => Null
                );

    }

     }else{
    	$message = array(
                    'status' => 1,
                    'message' => 'Job Not found',
                    'data' => Null
                );

    }
        
         $this->set_response($message, REST_Controller::HTTP_OK);
    
    }
    
    
    
    public function trackData_post(){
                $job_id = $this->post('job_id');
                $driver_id = $this->post('driver_id');
                $lat = $this->post('latitude');
                $long = $this->post('longitude');
                $address = $this->post('address');
               
                    $data = array( 
                             'job_id'   =>  $job_id,
                             'driver_id' =>  $driver_id,
                             'latitude'  =>  $lat,
                             'longitude' => $long,
                             'address'    => $address,
                             'track_date' =>  date('Y-m-d')
                           
                    );
                    
                        $this->db->insert('ci_track', $data);
                        $id = $this->db->insert_id() ;
                        $result = $this->driver_model->get_trackdata($id);
                        
    
                    if($result){

                        $message = array(
                                'status' => 1,
                                'message' => 'Tracking added successfully.',
                                'data' => $result
                            );
                        
                        }else{
                        $message = array(
                            'status' => 0,
                            'message' => 'Something goes wrong!',
                            'data' => NULL
                            );
                        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    } 
    
    
    public function trackListing_post(){
       $job_id = $this->post('job_id');
                $driver_id = $this->post('driver_id');
        $result=$this->driver_model->track_list($job_id,$driver_id);
        if ($result) {
             $message = array(
                    'status' => 1,
                    'message' => 'Tracking List Found.',
                    'data' => $result
                );
        }else{
            $message = array(
                    'status' => 0,
                    'message' => 'Tracking Not Found.',
                    'data' => NULL
                );
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }
    
    
    
    
    
  //********************Functions for both type drivers*************************//  
    
    
    public function driversJobListing_post(){
        $user_id = $this->post('user_id');
        
        
        
        
        
        
        $result = $this->driver_model->get_alldriversjoblist($user_id);

        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No jobs for you!!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
     public function driversEmergencyJobListing_post(){
        $user_id = $this->post('user_id');
        
        $result = $this->driver_model->get_driveremergencyjoblist($user_id);

        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No jobs found!!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
    public function notificationListing_post(){
        $driver_id = $this->post('driver_id');
        
        
        $result = $this->driver_model->get_notificationListing($driver_id);
        
        
        

        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Notification List Successfully',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No notification found!!'
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
    public function jobInvoice_post(){
        $job_id = $this->post('job_id');
        
        
        $result = $this->driver_model->invoicedetails($job_id);

        if($result){
            $message = array(
                    'status' => 1,
                    'message' => 'Invoice Found Successfully',
                    'jobs_data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Sorry, No Invoice found!!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }




    public function jobCancel_post(){
        $job_id = $this->post('job_id');
        $driver_id = $this->post('driver_id');
        $remark = $this->post('remark');
        $job_exists = $this->driver_model->job_exists($job_id);
        if($job_exists>0){
        
        $driver_exists = $this->driver_model->drivers_id_exists($driver_id);
        
        if($driver_exists>0){
        
       
        $date = date("Y-m-d");
        $user_exists = $this->driver_model->user_check_type($driver_id);
        if(!empty($user_exists)){
            $user_type = $user_exists['driver_type']; 
         

                     
            if($user_type=='pickup'){
                $dataarray = array(
                'job_status' => '3',
                'pick_date' => date('Y-m-d')
            );

             $jobarray = array(
                'job_id' => $job_id,
                'driver_id' => $driver_id,
                'job_status' => '3',
                'job_date' => $date,
                'type' => 'cancel',
                'remark' => $remark
            );   



            $this->db->where('id', $job_id);
            $dbs = $this->db->update('ci_booking', $dataarray);

           $this->db->insert('ci_jobdetails', $jobarray);
           $result = $this->driver_model->get_alldriversjoblist($driver_id); 

            }else{
                
                $dataarray = array(
                'job_status' => '3',
                'delivery_date' => date('Y-m-d')
                );

                $jobarray = array(
                'job_id' => $job_id,
                'driver_id' => $driver_id,
                'job_status' => '3',
                'job_date' => $date,
                'type' => 'cancel',
                'remark' => $remark
            ); 

            $this->db->where('id', $job_id);
            $dbs = $this->db->update('ci_booking', $dataarray);

            $this->db->insert('ci_jobdetails', $jobarray);
            $result = $this->driver_model->get_seconddriversjoblist($driver_id);

            }
            
       }

        
        if(!empty($result)){  
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Something goes wrong!',
                'jobs_data' => NULL
                );
        }
        }else{
            
            $message = array(
                'status' => 0,
                'message' => 'Driver not Available!',
                'jobs_data' => NULL
                );
        }
        }else{
            
            $message = array(
                'status' => 0,
                'message' => 'Job not Available!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    


    public function jobPostponed_post(){
        $job_id = $this->post('job_id');
        $driver_id = $this->post('driver_id');
        $post_date = $this->post('date');
        $remark = $this->post('remark');
        $status = $this->post('status');
        $date1 = date("Y-m-d");
        if($status=='cancel'){
            $postponed_date = date('Y-m-d', strtotime($date1));
            $job_status = '3';
            $type = 'cancel';
            $pick_status = '1';
            $del_status = '1';
        }else{
           $postponed_date = date('Y-m-d', strtotime($this->post('date'))); 
           $job_status = '4';
           $type = 'postponed';
            $pick_status = '0';
            $del_status = '0';
        }

        $job_exists = $this->driver_model->job_exists($job_id);
        if($job_exists>0){
        
        $driver_exists = $this->driver_model->drivers_id_exists($driver_id);
        
        if($driver_exists>0){
        
       
        $date = date("Y-m-d");
        $user_exists = $this->driver_model->user_check_type($driver_id);
        if(!empty($user_exists)){
            $user_type = $user_exists['driver_type']; 
         

                     
            if($user_type=='pickup'){
                $dataarray = array(
                'job_status' => $job_status,
                'pickup_status' => $pick_status,
                'pick_date' => $postponed_date
            );

             $jobarray = array(
                'job_id' => $job_id,
                'driver_id' => $driver_id,
                'job_status' => $job_status,
                'job_date' => $postponed_date,
                'type' => $type,
                'remark' => $remark
            );   



            $this->db->where('id', $job_id);
            $dbs = $this->db->update('ci_booking', $dataarray);

           $result = $this->db->insert('ci_jobdetails', $jobarray);
           $this->driver_model->get_alldriversjoblist($driver_id); 

            }else{
                
                $dataarray = array(
                'job_status' => $job_status,
                'pickup_status' =>$pick_status,
                'delivery_status' => $del_status,
                'delivery_date' => $postponed_date
                );

                $jobarray = array(
                'job_id' => $job_id,
                'driver_id' => $driver_id,
                'job_status' => $job_status,
                'job_date' => $postponed_date,
                'type' => $type,
                'remark' => $remark
            ); 

            $this->db->where('id', $job_id);
            $dbs = $this->db->update('ci_booking', $dataarray);

            $result = $this->db->insert('ci_jobdetails', $jobarray);
           

            }
            
       }

        
        if(!empty($result)){  
            $message = array(
                    'status' => 1,
                    'message' => 'Success',
                    'data' => $result
                );
        }else{
            $message = array(
                'status' => 0,
                'message' => 'Something goes wrong!',
                'jobs_data' => NULL
                );
        }
        }else{
            
            $message = array(
                'status' => 0,
                'message' => 'Driver not Available!',
                'jobs_data' => NULL
                );
        }
        }else{
            
            $message = array(
                'status' => 0,
                'message' => 'Job not Available!',
                'jobs_data' => NULL
                );
        }

        $this->set_response($message, REST_Controller::HTTP_OK);

    }
    
    
public function googlemapApi_get(){
       // $userid=$this->get('userid');
        $result=$this->driver_model->googlemapApi_list();
        if(!empty($result)){
             $message = array(
                    'status' => 1,
                    'message' => 'Api Found.',
                    'data' => $result
                );
        }else{
            $message = array(
                    'status' => 0,
                    'message' => 'Api Not Found.',
                    'data' => $result
                );
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }
    
    
    
    
    
        

} // this closing is for class do not delete it
?>