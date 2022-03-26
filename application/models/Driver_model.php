<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Driver_model extends CI_Model
{
	private $profile_image_url;
	private $image_path;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->profile_image_url = realpath(APPPATH.'../uploads/driver/');
		$this->imagepath = realpath(APPPATH.'../uploads/driver/');
		
		$this->client_image_url = realpath(APPPATH.'../uploads/client/');
		$this->user_image_url = realpath(APPPATH.'../uploads/users/');
		$this->product_imagepath = realpath(APPPATH.'../uploads/product/');
		$this->qrcode_imagepath = realpath(APPPATH.'../uploads/qrcode/');
		$this->signature_imagepath = realpath(APPPATH.'../uploads/signature/');
		$this->warehouse_imagepath = realpath(APPPATH.'../uploads/warehouse/');
		// $this->image_path = realpath(APPPATH.'../../userpanel/images');
		$this->image_path = realpath(APPPATH.'../uploads/driver/');
		$this->load->library('firebase', array('firebase_api_key' => $this->config->item('firebase_api_key')));
        $this->load->library('userfirebase', array('userfirebase_api_key' => $this->config->item('userfirebase_api_key')));
        
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.smtp2go.com',
            'smtp_port' => 2525,
            'smtp_user' => 'anshul@younggeeks.in',
            'smtp_pass' => 'jlOsKNteCVkv',
            'smtp_crypto'  => 'tls', 
            'charset'  => 'utf-8',
            'newline'  => 'rn',
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

	}
	
	
	
	public function sendMail($to, $subject, $content, $headers){
	    $this->email->from('anshul@younggeeks.in', 'Door2Door');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($content);
        $sent = $this->email->send();
        return true;
	}
	
	
	
	
	public function emailotpsend($email,$mobile,$otp){
	
        $otp = $otp;
        
        $strSubject = "Complete your Otp request";
	    $from = 'anshul@younggeeks.in';
        $headeruser="Mime-Version: 1.0\r\n";
		$headeruser.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headeruser1="Mime-Version: 1.0\r\n";
		$headeruser1.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headeruser1.= "From:Makcik <$from>" . "\r\n";
		$msg = '<!doctype html>
		<html>

		<head>
		    
		    <title>Account Credential</title>
		    <link href="https://fonts.googleapis.com/css?family=Expletus+Sans" rel="stylesheet" type="text/css">
		    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
		</head>

		<body style="margin:0px; padding:0px; font-family: Open Sans, Tahoma, Times, serif; background: rgb(77, 158, 185) none repeat scroll 0% 0%; width: 100%; float: left;">
		    <div class="container" style="width:590px; margin:auto;margin-top:50px;margin-bottom:50px;">
		        <div class="container1" style="background: #fff;width: 100%;float: left;margin-bottom:50px;">
		            <div class="cont" style="width: 490px;float: left;text-align: center;margin: 25px 0px 0px 43px;">
		                <img src="https://door2doorsoftware.com/upload/avatars/56a3cfad8a21c93d0f382ecbff914cbe.png" height="70"><br/><br/>
		                <div class="header" style="font-weight: 600;color: rgb(255, 255, 255);font-size: 30px;
		line-height: 30px;padding: 18px 0px 12px;background-color: rgb(255, 114, 67); font-family: Arial, cursive;">
		                   Forgot Password Credential
		                </div>
		                <div class="pay-head" style="font-family: Lato;font-weight: 400;color: rgb(72, 72, 72);font-size: 25px;line-height: 35px; margin-top: 13px;">
		                    Hello '.$username.' below are the credential of your account
		                </div>
		                <div class="border" style="width: 500px;text-align: left;height: 1px;background-color: #000;float: left;">
		                </div>
		                <div class="txt" style="font-family: Lato,Arial;font-weight: 400;font-size: 15px;line-height: 23px;
		color: rgb(38, 38, 38);width: 100%;margin-top: 24px;">
		                    <p style="margin: 0px !important;">Please donot share this information with any one for some security reason please update your password every month.</p>
		                </div>
		                <div class="amount" style="color: rgb(72, 72, 72);line-height: 35px;font-family: Lato;">
		                 
		                    <h3 style="margin: 8px 0px 10px !important;font-weight: 300;font-size: 20px">Your Email : '.$email.'</h3>
		                    <h3 style="margin: 8px 0px 10px !important;font-weight: 300;font-size: 20px">Your Mobile  : '.$mobile.'</h3>
		                    <h3 style="margin: 8px 0px 10px !important;font-weight: 300;font-size: 20px">Your Verify code  : '.$otp.'</h3>
		                    
		                </div>
		                
		                <div class="line" style="height: 1px;background: rgb(218, 218, 218) none repeat scroll 0% 0%;margin-top: 20px;">
		                </div>
		                <p style="font-family: Lato, Arial; font-weight: 400; font-size: 15px; line-height: 24px; color: #0c0b0c; -webkit-font-smoothing: antialiased; margin: 26px 0px 0px !important;">
		                  Door2Door<br/> All rights reserved 2021 </p>
		                <div class="icon" style="width: 350px;float: left;margin: 18px 0px 25px 149px;">
		                    
		                </div>
		            </div>
		        </div>
		    </div>
		    </div><br/><br/>
		</body>

		</html>';
		           
		 $emails = $this->sendMail( $email, $strSubject, $msg, $headeruser1 );
		                
		 if($emails){
		 	return true;
		 }else{
		 	return false;
		 }
	}
     
		public function user_login($data){
		    
		    $type = $data['driver_type'];
		$response1 = array();
		$this->db->from('ci_drivers');
		$this->db->where("(username = '".$data['email']."' OR email = '".$data['email']."' OR mobile_no = '".$data['email']."')");
		//$this->db->where('password', $data['password']);
		$this->db->where('is_admin', 1);
		$this->db->where('driver_type', $type);
		$this->db->where('is_verify', 1);
		$query = $this->db->get();
 		$rowcount = $query->num_rows();
 		if($rowcount > 0){
 			$this->update_user_device($data);
 			$this->db->from('ci_drivers');
    		$this->db->where("(username = '".$data['email']."' OR email = '".$data['email']."' OR mobile_no = '".$data['email']."')");
    		$this->db->where('driver_type', $type);
    		$query1 = $this->db->get();
 		
    	if ($query->num_rows() == 0){
			return false;
		}
		else{
			//Compare the password attempt with the password we have stored.
			$result = $query->row_array();
		 //   $validPassword = password_verify($data['password'], $result['password']);
		  //  if($validPassword){
		        $response = $query1->row_array();
		        $response1['user_id'] = $response['id'];
		        $response1['unique_id'] = $response['unique_id'];
		        $response1['otp'] = $data['mobile_otp'];
		        $response1['country_id'] = $response['country_id'];
		        $response1['is_active'] = $response['is_active'];
		        $response1['email'] = $response['email'];
		        $response1['mobile_no'] = $response['mobile_no'];
		        $response1['subdomain_name'] = $response['subdomain_name'];
		        $response1['url'] = $response['app_url'];
		        $response1['app_url'] = 'https://'.$response['app_url'].'/driver/';
 			//$response['image'] = $this->profile_image_url.$response['image'];
 			
 	
 	$this->emailotpsend($response['email'],$response['mobile_no'],$data['mobile_otp']);
 	
 		
$domain = 'door2doorsoftware.com/driver/update_otpdata';
$req = 'https://';
$url = $req.$response['subdomain_name'].'.'.$domain;
 			
 		//	$url = 'http://'"'.$response['subdomain_name'].'"'.proximitycrm.com/driver/update_otpdata';

$fields = array(
    'user_id'      => $response['id'],
    'otp'      => $data['mobile_otp'],
    'device_id'      => $data['device_id'],
    'unique_id'      => $response['unique_id'],
    'device_type'      => $data['device_type'],
    'subdomain_name'    => $response['subdomain_name'],
    'mobile_no'      => $response['mobile_no']
);

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);
 			
 			return $response1;

		  //  }

		}


 		}else{
 			return false;
 		}
		
	}
	
	
	
	
	
	    
    public function product_list(){
    	 $data=array();
		$this->db->select('*');
		$this->db->from('ci_products');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
		  
		  $vimage = $this->profile_image_url.$value['product_photo'];

		   $product_prices = $value['product_price'];
    	              $product_price = number_format($product_prices,2,'.','');

    	           
		    
			$data[] =array(
				'product_id' => $value['product_id'],
				'product_name' => $value['product_name'],
				'product_category' => $value['product_category'],
				'product_qty' => $value['product_quantity'],
				'product_price' => $product_price,
				'product_image' =>$vimage

			);		
		}
		$i++;
		return $data;
	}
	
	public function warehouse_list(){
		 $data=array();
		$this->db->select('*');
		$this->db->from('ci_warehouse');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
		  
		  	$data[] =array(
				'ware_id' => $value['ware_id'],
				'ware_name' => $value['name'],
				'ware_address' => $value['address1']

			);		
		}
		$i++;
		return $data;
	}
	
	public function item_list(){
		 $data=array();
		$this->db->select('*');
		$this->db->from('ci_shippingitem');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
		  
		  	$data[] =array(
				'item_id' => $value['ship_id'],
				'item_name' => $value['item_name']

			);		
		}
		$i++;
		return $data;
	}
	
	public function driver_id_exists($user_id){
		$this->db->from('ci_drivers');
		$this->db->where(array('id'=>$user_id));
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if($rowcount){
			return true;
		}else{
			return false;
		}
	}


	public function drivers_id_exists($user_id){
		$this->db->from('ci_drivers');
		$this->db->where(array('id'=>$user_id));
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if($rowcount){
			return $rowcount;
		}else{
			return $rowcount;
		}
	}
	
	public function job_exists($id){
		$this->db->from('ci_booking');
		$this->db->where(array('id'=>$id));
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if($rowcount){
			return $rowcount;
		}else{
			return $rowcount;
		}
	}


	public function drivers_id_check($user_id){
		$this->db->from('ci_drivers');
		$this->db->where(array('id'=>$user_id, 'is_admin'=>'1'));
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if($rowcount){
			return $rowcount;
		}else{
			return $rowcount;
		}
	}


	public function product_exists($id,$product_id){
		$this->db->from('ci_jobproduct');
		$this->db->where(array('product_id'=>$product_id,'job_id'=>$id));
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if($rowcount){
			return $rowcount;
		}else{
			return $rowcount;
		}
	}
	
	
	
		public function verify_otp($data){
		$response1 = array();
		$this->db->select('ci_drivers.*,countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_drivers');
		$this->db->join('countries','countries.id=ci_drivers.country');
		$this->db->join('states','states.id=ci_drivers.state');
		$this->db->join('cities','cities.id=ci_drivers.city');
		$this->db->where('ci_drivers.id', $data['id']);
		$this->db->where('driver_otp', $data['driver_otp']);
		$query = $this->db->get();
 		$rowcount = $query->num_rows();
 		if($rowcount > 0){

			$response = $query->row_array();

			$response1['user_id'] = $response['id'];
			$response1['username'] = $response['username'];
			$response1['title'] = $response['title'];
			$response1['firstname'] = $response['firstname'];
			$response1['lastname'] = $response['lastname'];
			$response1['email'] = $response['email'];
			$response1['mobile_no'] = $response['mobile_no'];
			$response1['address'] = $response['address'];
			$response1['city'] = $response['city_name'];
			$response1['country'] = $response['country_name'];
			$response1['country_id'] = $response['country_id'];
			$response1['licence'] = $response['licence'];
			$response1['dob'] = $response['dob'];
			$response1['state'] = $response['state_name'];
			$response1['date_of_join'] = $response['doj'];
			$response1['gender'] = $response['gender'];
			$response1['vehicle_assign'] = $response['vehicle_assign'];
			$response1['driver_type'] = $response['driver_type'];
			$response1['driver_status'] = $response['is_admin'];
			$response1['driver_fullname'] = $response['firstname'].' '.$response['lastname'];
			$response1['driver_image'] = $response['driver_photo'];
			$response1['full_name'] = $response['firstname'].' '.$response['lastname'];
			$response1['image'] = $this->profile_image_url.$response['driver_photo'];
 
		    $response1['phone_number'] = $response['mobile_no'];
 			$response1['profile_image'] = $this->profile_image_url.$response['driver_photo'];
 			$response1['type'] = $response['driver_type'];

 			return $response1;

 		}else{
 			return false;
 		}
		
	}


    public function update_user_device($data){
    	
    		$this->db->query("update ci_drivers set device_id='".$data['device_id']."',device_type='".$data['device_type']."' where mobile_no='".$data['email']."'");
    
    		return true;
    	}




	public function sendmsg($mobile_no,$message,$country_code)
	{
	      $data = array(
	        'number' => $mobile_no,
	        'message' => $message,
	        'code' => $country_code
	         );
	         
	        //print_r($data);die;
	     $plus='+';
				 $mobile_no= $plus.$country_code.$mobile_no;
			     //echo $mobile_no;die;
			     
			     	$sid = 'AC4be236eaabf05095dad5ee228983e675';
					$token = '475447633626fbdf8ca9b34e1e2c1363';
					
					$client = new Client($sid, $token);
					//echo $client;die;

					$client->messages->create(
					$mobile_no,
					array(
					'from' => '+12565593877',
					'body' => $message
					)
					);
					
			     
					if(!empty($client)){
                    
						return true;
					}else{
						return false;
					}
	}
	



	public function sendotpmsg($mobile_no,$message,$country_code)
	{
	      
	     $record = $this->db->select('id,smtp_details')->from('tbl_setting')->get()->row();
	     $records = json_decode($record->smtp_details);
	     $_my_clicksend_username = $records->clicksend_username;
	     $senderid = $records->clicksend_senderid;
	     $_my_clicksend_key = $records->clicksend_key;
	     
	     
	    
	      $data = array(
	        'number' => $mobile_no,
	        'message' => $message,
	        'code' => $country_code
	         );
	         
	       	            $plus='+';
		    $mobile_no= $plus.$country_code.$mobile_no;
			    
//	$_my_clicksend_username = "info@a6ix.co.uk";
//  $_my_clicksend_key = "6C4F4F01-CF66-0EFE-F2E1-896E8F671BA5";
  
  $to        = $mobile_no;
  
//  $senderid  = "195911";
  
  $url = "https://api.clicksend.com/http/v2/send.php?method=http&username=$_my_clicksend_username&key=$_my_clicksend_key";
  $data = '&to=' . $to .'&message=' . $message . '&senderid=' . $senderid;
  
  $ch = curl_init(); 
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1); 
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36");
  

    $response = curl_exec($ch);
    $err = curl_error($ch);

curl_close($ch);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
    
}
  

	}





	
	public function checknumber($mobile_no,$country_code)
    {
        $mobile_no='+'.$country_code.$mobile_no;
        $sid = 'AC4be236eaabf05095dad5ee228983e675';
					$token = '475447633626fbdf8ca9b34e1e2c1363';
        $base_url       =  "https://lookups.twilio.com/v1/PhoneNumbers/$mobile_no?Type=carrier";
        $ch             =  curl_init($base_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$sid:$token");
        $response           =       curl_exec($ch);
        $response           =       json_decode($response);
       // print_r($response);
     //  echo $error=$response->carrier->type;
        $error=$response->carrier->error_code;
        if($error=='')
        {
             return $response;
          
        }
        else
        {
            return false;  
        }
    }
    
    
    
    public function booking_id_exists($user_id){
		$this->db->from('ci_booking');
		$this->db->where(array('id'=>$user_id));
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if($rowcount){
			return true;
		}else{
			return false;
		}
	}
    
    
    
    
    public function get_joblist($user_id){
$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){

		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('driver',$user_id);
		$this->db->join('ci_users', 'ci_users.id = ci_booking.client_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');
		$this->db->order_by("ci_booking.id", "DESC");
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['client_address'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);

			$jstatus = $value['job_status'];
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }
				$client_image = !empty($value['user_photo']) ? $this->client_image_url.$value['user_photo'] : "";    
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['client_id'],
					'client_name' => $value['client_name'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['client_phone'],
					'job_status' => $status,
					'client_location' => $client_location

				);
			
}
$i++;
	
}
return $data;
	}
	
	
	    public function get_deliverjoblist($user_id){
$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){


		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_email,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('driver',$user_id);
		$this->db->where('job_status','1');
		$this->db->join('ci_users', 'ci_users.id = ci_booking.client_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['client_address'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);
			
			
			$jstatus = $value['job_status'];
				    
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }
				    $client_image = !empty($value['user_photo']) ? $this->client_image_url.$value['user_photo'] : "";
				    
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['client_id'],
					'client_name' => $value['client_name'],
					'client_email' => $value['client_email'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['client_phone'],
					'job_status' => $status,
					'client_location' => $client_location

				);
			
}
$i++;
	
}
return $data;
	}
	
	
	public function get_joblist_old($user_id){
$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){

		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('driver',$user_id);
		$this->db->join('ci_users', 'ci_users.id = ci_booking.client_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['client_address'];
			$city = $value['client_city'];
			$state = $value['client_state'];
			$country = $value['client_country'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);
			
			
			$jstatus = $value['job_status'];
				    
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }
				    
				    $client_image = !empty($value['user_photo']) ? $this->client_image_url.$value['user_photo'] : "";
				    
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['client_id'],
					'client_name' => $value['client_name'],
					'client_image' => $client_image,
					'client_address' => $value['client_address'],
					'client_phone_number' => $value['client_phone'],
					'job_status' => $status,
					'client_location' => $client_location,
					'delivery_data' => $this->get_jobdelivery($value['id'])

				);
			
}
$i++;
	
}
return $data;
	}





public function get_djoblist($user_id,$job_id){
$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){
		    
	//$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		//$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		//$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');	   

                $query1 = $this->db->query("SELECT ci_booking.*, countries.nicename as country_name, countries.phonecode as phonecode, states.name as state_name, cities.name as city_name  FROM ci_booking left join countries on countries.id=ci_booking.client_country left join states on states.id=ci_booking.client_state left join cities on cities.id=ci_booking.client_city WHERE ci_booking.id='$job_id' ");
    	             $senders =$query1->row_array();
    	              
    	               
    	               $data = array(
    	                   'reciver_id' => $senders['client_id'],
    	                   'reciver_name' => $senders['client_name'],
    	                   'reciver_email' => $senders['client_email'],
    	                   'reciver_contact' => $senders['client_phone'],
    	                   'reciver_address' => $senders['client_address'],
    	                   'reciver_region' => $senders['city_name'],
    	                   'reciver_town' => $senders['state_name'],
    	                   'reciver_country' => $senders['country_name'],
    	                   'reciver_mobile_code' => '+'.$senders['phonecode'],
    	                   'reciver_zipcode' => $senders['client_zip'],
    	                   'product_list' => $this->get_productlistings($job_id)
    	                   
    	                   
    	                   );
    	               
   }
return $data;
	}
	

public function get_productlistings($job_id){
	$data = array();
		$this->db->select('*');
		$this->db->from('ci_jobproduct');
		$this->db->where('ci_jobproduct.job_id',$job_id);
		//$this->db->where('ci_jobproduct._id',$job_id);
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value1) {

			 		$product_prices = $value1['product_price'];
    	              $product_price = number_format($product_prices,2,'.','');

    	              $price_ranges = $value1['price_range'];
    	              $price_range = number_format($price_ranges,2,'.','');
			
				$data[] =array(

					'job_id' => $value1['job_id'],
					'product_id' => $value1['product_id'],
					'product_name' => $value1['product_name'],
					'product_image' => $this->client_image_url.$value1['product_image'],
					'product_qty' => $value1['product_qty'],
					'product_qty' => $value1['product_qty'],
					'product_price' => $product_price,
					'price_range' => $price_range

				);	
				
				
}
$i++;
	return $data;
	}







public function get_jobdelivery($job_id){
	 $data=array();
		$this->db->select('ci_booking.customer_id,ci_booking.customer_address,ci_booking.customer_city,ci_booking.customer_state,ci_booking.customer_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.customer_firstname,ci_booking.customer_lastname,ci_booking.customer_email,ci_booking.customer_mobile,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang,ci_warehouse.name as warehousename,ci_warehouse.address1,ci_warehouse.address2,ci_warehouse.email as warehouseemail,ci_warehouse.mobile_no as warehousemobile,ci_warehouse.city as warehousecity,ci_warehouse.state as warehousestate,ci_warehouse.country as warehousecountry,ci_warehouse.warehouse_image as warehouse_image, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('ci_booking.id',$job_id);
		$this->db->join('ci_users', 'ci_users.id = ci_booking.customer_id ', 'Left');
		$this->db->join('ci_warehouse', 'ci_warehouse.ware_id = ci_booking.warehouseid ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.customer_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.customer_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.customer_city ', 'Left');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value1) {
			
			$prefix = ', ';
			$add1 = $value1['customer_address'];
			$city = $value1['city_name'];
			$state = $value1['state_name'];
			$country = $value1['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;
			
			
			

$client_location = array(

	'lat' => $value1['client_lat'],
	'lng' => $value1['client_lang']

);

$customer_location = array(

	'lat' => $value1['customer_lat'],
	'lng' => $value1['customer_lang']

);


			
			$customer_image = !empty($value1['user_photo']) ? $this->client_image_url.$value1['user_photo'] : "";
				$data =array(

					'reciver_id' => $value1['customer_id'],
					'reciver_name' => $value1['customer_firstname'].$value1['customer_lastname'],
					'reciver_address' => $final_address,
					'reciver_email' => $value1['customer_email'],
					'reciver_image' => $customer_image,
					'reciver_address' => $final_address,
					'reciver_phone_number' => $value1['customer_mobile'],
					'reciver_location' => $customer_location,
					'qr_image' => $this->getqrimageofjob($job_id)

				);	
				
				
}
$i++;
	return $data;
	}




public function getqrimageofjob($job_id){
		
       
        $this->db->select('qr_image');
        $this->db->from('ci_jobqrcode');
        $this->db->where('job_id', $job_id);
		$query = $this->db->get();
		$data=$query->row();
		return !empty($data->qr_image) ? $this->qrcode_imagepath.$data->qr_image : "";
	}




    function get_latlong($address1){
        
        //$address1 = "559 kha/141 F, Srinagar, Alambagh, Lucknow, Uttar Pradesh, India";
$address = urlencode($address1);

//$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address);


$url = "https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyBQlTyEslQpEh445rwYXspfaKuZV8_upbc";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
$responseJson = curl_exec($ch);
curl_close($ch);

$response = json_decode($responseJson);

if ($response->status == 'OK') {
    $latitude1 = $response->results[0]->geometry->location->lat;
    $latitude =  number_format((float)$latitude1, 7, '.', '');
    $longitude1 = $response->results[0]->geometry->location->lng;
    $longitude =  number_format((float)$longitude1, 7, '.', '');

   $dataarray = array('lat'=> $latitude ,'lng'=>$longitude);
    
    return $dataarray;
} else {
    $dataarray = $response->status;
     
    return $dataarray;
}
        
        
        
        
    }
    
    
    
    public function get_emergencyjoblist($user_id){
    	 $data=array();
$user_exists = $this->driver_id_exists($user_id);
		
		if($user_exists){

		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_booking.client_email,ci_client.client_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('driver',$user_id);
		$this->db->where('service_type','1');
		$this->db->join('ci_client', 'ci_client.client_id = ci_booking.client_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['client_address'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);


			
			$s_status = $value['ship_status'];
			if($s_status=='0'){
				$ship_status = 'Newly Booked';
			}elseif($s_status=='1'){
				$ship_status = 'Already Picked';
			}if($s_status=='2'){
				$ship_status = 'In Storage';
			}if($s_status=='3'){
				$ship_status = 'In Transit';
			}if($s_status=='4'){
				$ship_status = 'Delivered';
			}if($s_status=='5'){
				$ship_status = 'Problematic';
			}

			$jstatus = $value['ship_status'];
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }
				    $client_image = !empty($value['client_photo']) ? $this->client_image_url.$value['client_photo'] : "";
				    
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['client_id'],
					'client_name' => $value['client_name'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['client_phone'],
					'job_status' => $status,
					'ship_status' => $ship_status,
					'client_location' => $client_location,
					'delivery_data' => $this->get_jobdelivery($value['id'])

				);
			
}
$i++;
	
}
return $data;
	}
	
	
	
	public function get_productList($job_id){
		 $data=array();
$user_exists = $this->booking_id_exists($job_id);
		
		if($user_exists){
        $this->db->select('*');
		$this->db->from('ci_booking');
		$this->db->where('id',$job_id);
		
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			
				$items_detail = unserialize($value['items_detail']);
				$count = count($items_detail['product_description']);
				
				for($i=0; $i<$count; $i++){
				    
			    $lang_id = $items_detail['product_description'][$i];
			    $query1 = $this->db->query("SELECT * FROM ci_shippingitem WHERE item_name='$lang_id' ");
    	             $senders =$query1->row_array();
    	               $attendence = $senders['ship_id'];
           
				$data[] =array(
				    
					'job_id' => $job_id,
					'item_id' => $attendence,
					'item_name' => $items_detail['product_description'][$i],
					'item_quantity' => $items_detail['quantity'][$i],
					'item_price' => $items_detail['price'][$i],
					'item_total' => $items_detail['total'][$i]

				);
				
				}
				$i++;
			//	$data['total'] = $value['grand_total'];
			
}

return $data;	
}

	}
	
	
	
	
	
	
	public function get_productListing($job_id){
$user_exists = $this->booking_id_exists($job_id);
		$data = array();
		if($user_exists){
        $this->db->select('*');
		$this->db->from('ci_jobproduct');
		$this->db->where('job_id',$job_id);
		$this->db->join('ci_booking', 'ci_booking.id = ci_jobproduct.job_id ', 'Left');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
		    
		    $driver_id = $value['driver'];
		    
		    $query1 = $this->db->query("SELECT * FROM ci_drivers join countries on countries.phonecode=ci_drivers.country_id WHERE ci_drivers.id='$driver_id' ");
    	             $senders =$query1->row_array();
    	              
    	                   $currency =  $senders['code'];
			

			 		$product_prices = $value['product_price'];
    	              $product_price = number_format($product_prices,2,'.','');

    	              $price_ranges = $value['price_range'];
    	              $price_range = number_format($price_ranges,2,'.','');

			    
				$data[] =array(
				    'job_id' => $value['job_id'],
				    'item_id' => $value['product_id'],
					'item_name' => $value['product_name'],
					'item_quantity' => $value['product_qty'],
					'item_price' => $product_price,
					'price_range' => $price_range,
					'currency' => $currency,
					'product_image' => $this->product_imagepath.$value['product_image']

				);
				
				
			//	$data['total'] = $value['grand_total'];
			
}
$i++;
	
}
return $data;
	}



function removecart_update($rowid,$job_id) 
    {
        $this->db->where('product_id', $rowid);
        $this->db->where('job_id', $job_id);
        return $this->db->delete('ci_jobproduct');
    }	
	
	public function product_exist($job_id,$product_id){
		$this->db->from('ci_jobproduct');
		$this->db->where(array('job_id'=>$job_id, 'product_id'=>$product_id));
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if($rowcount){
			return $rowcount;
		}else{
			return $rowcount;
		}
	}
	
	
	public function productname_exist($item_name){
		$this->db->from('ci_shippingitem');
		$this->db->where(array('item_name'=>$item_name));
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if($rowcount){
			return $rowcount;
		}else{
			return $rowcount;
		}
	}
	
	
	public function user_check_product($user_id){
		$this->db->from('ci_shippingitem');
		$this->db->where(array('item_name'=>$user_id));
		$query = $this->db->get();
		$rowcount = $query->row_array();
		if($rowcount){
			return $rowcount;
		}else{
			return $rowcount;
		}
	}
	
	
	public function user_check_type($user_id){
		$this->db->from('ci_drivers');
		$this->db->where(array('id'=>$user_id));
		$query = $this->db->get();
		$rowcount = $query->row_array();
		if($rowcount){
			return $rowcount;
		}else{
			return $rowcount;
		}
	}
	
	
	public function user_check_qrcode($user_id){
		$this->db->from('ci_jobqrcode');
		$this->db->where(array('job_id'=>$user_id));
		$query = $this->db->get();
		$rowcount = $query->row_array();
		if($rowcount){
			return $rowcount;
		}else{
			return $rowcount;
		}
	}
	
	
	public function user_check_msg($job_id,$driver_id,$user_type){
		$this->db->from('ci_message');
		$this->db->where(array('job_id'=>$job_id,'driver_id'=>$driver_id,'driver_type'=>$user_type));
		$query = $this->db->get();
		$rowcount = $query->row_array();
		if($rowcount){
			return $rowcount;
		}else{
			return $rowcount;
		}
	}
	
	
	
	public function order_check_type($driver_id,$otp,$job_id){
		$this->db->from('ci_message');
		$this->db->where(array('job_id'=>$job_id,'driver_id'=>$driver_id,'message_otp'=>$otp));
		$query = $this->db->get();
		$rowcount = $query->row_array();
		if($rowcount){
			return $rowcount;
		}else{
			return $rowcount;
		}
	}
	
	
	
	
	
	function addtocart($courseid, $coursename, $courseprice, $courseqty, $subscribe, $time)
    {
        $data = array(
            'item_id' => $courseid,
            'item_name' => $coursename,
            'item_price' => $courseprice,
            'item_qty' => $courseqty,
            'item_image' => $subscribe,
            'subtotal' => $courseprice,
            'created_at' => $time
        );
        $this->db->insert($this->cart, $data);
    }
    
    public function item_count(){
        
        $query1 = $this->db->query("SELECT * FROM ci_shippingitem order by ship_id desc limit 1  ");
    	             $senders =$query1->row_array();
    	             
    	            $ddate = date('Y-m-d');
                $due = $senders['ship_id'];
        
        return $due;
        
	
	}
	
	public function get_qrListing($job_id){
        $data = array();
        $query1 = $this->db->query("SELECT * FROM ci_jobqrcode where job_id='$job_id'  ");
    	             $senders =$query1->row_array();
    	             
                $data = array(
                    'qr_id' => $senders['qr_id'],
                    'job_id' => $senders['job_id'],
                    'qr_code' => $senders['qr_code'],
                    'qr_image' => $this->qrcode_imagepath.$senders['qr_image']
                    
                    );
                
                return $data;
        
	
	}
	
	
	public function get_paymentListing($job_id,$payment_id){
        $data = array();
        $query1 = $this->db->query("SELECT * FROM ci_paymetsdetail where job_id='$job_id' AND payment_id='$payment_id'  ");
    	             $senders =$query1->row_array();
    	             
    	        $data = array(
                    'pay_id' => $senders['pay_id'],
                    'job_id' => $senders['job_id'],
                    'paymentAmount' => $senders['amount'],
                    'payerName' => $senders['payer_name'],
                    'mobile' => $senders['mobile'],
                    'payment_id' => $senders['payment_id'],
                    'paymentType' => $senders['payment_type'],
                    'paymentDate' => $senders['payment_date'],
                    'paymentGateway' => $senders['payment_gateway'],
                    'status' => $senders['status']
                    
                    
                    );
                
          return $data;
        
	
	}
	
	
		public function payment_exist($job_id,$payment_id){
		$this->db->from('ci_paymetsdetail');
		$this->db->where(array('job_id'=>$job_id, 'payment_id'=>$payment_id));
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if($rowcount){
			return $rowcount;
		}else{
			return $rowcount;
		}
	}
	
	
	public function sign_exist($job_id,$driver_id){
		$this->db->from('ci_signature');
		$this->db->where(array('job_id'=>$job_id, 'driver_id'=>$driver_id));
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if($rowcount){
			return $rowcount;
		}else{
			return $rowcount;
		}
	}
	
	
	public function get_signatureListing($job_id,$driver_id){
        $data = array();
        $query1 = $this->db->query("SELECT * FROM ci_signature where job_id='$job_id' AND driver_id='$driver_id'  ");
    	             $senders =$query1->row_array();
    	             
    	        $data = array(
                    'sign_id' => $senders['sign_id'],
                    'job_id' => $senders['job_id'],
                    'driver_id' => $senders['driver_id'],
                    'signature_image' => $this->signature_imagepath.$senders['client_image'],
                    'created_at' => $senders['created_at'],
                    'sign_date' => $senders['sign_date']

                    );
                
                
        
        return $data;
        
	
	}
	
	
	public function get_driver($userid){

	$data1=array();
	$user_exists = $this->driver_id_exists($userid);
	if($user_exists){
	$this->db->select('ci_drivers.*, countries.name as country_name, states.name as state_name, cities.name as city_name');
	$this->db->from('ci_drivers');
	$this->db->join('countries','countries.id=ci_drivers.country');
		$this->db->join('states','states.id=ci_drivers.state');
		$this->db->join('cities','cities.id=ci_drivers.city');
	$this->db->where('ci_drivers.id', $userid);
		$query = $this->db->get();
		// return $data=$query->row();
		$data=$query->row();
		//$d=str_replace("../","/",$data->left_image);
		
		//$data1['image']=$this->profile_image_url.$images;
		$data1['image'] = !empty($data->driver_photo) ? $this->profile_image_url.$data->driver_photo : "";
		$data1['user_id']=$data->id;
		$data1['username']=$data->username;
		$data1['title']=$data->title;
		$data1['firstname']=$data->firstname;
		$data1['lastname']=$data->lastname;
		$data1['email']=$data->email;
		$data1['mobile_no']=$data->mobile_no;
		$data1['address']=$data->address;
		//$data1['sms_code']=$data->sms_code;
		$data1['city']=$data->city_name;
		$data1['country']=$data->country_name;
		$data1['country_id']=$data->country_id;
		$data1['licence']=$data->licence;
		$data1['dob']=$data->dob;
		$data1['state']=$data->state_name;
		$data1['date_of_join']=$data->doj;
		$data1['gender']=$data->gender;
		$data1['vehicle_assign']=$data->vehicle_assign;
		$data1['driver_type']=$data->driver_type;
		$data1['driver_status']=$data->is_admin;

		$data1['driver_fullname']=$data->firstname.' '.$data->lastname;
		$data1['driver_image']=!empty($data->driver_photo) ? $data->driver_photo : "";
		
	}	
		return $data1;

	}
	
	
	 public function get_alljoblist($user_id){
    $user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){


		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_booking.client_email,ci_client.client_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('driver',$user_id);
		//$this->db->where('job_status','0');
		$this->db->join('ci_client', 'ci_client.client_id = ci_booking.client_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['client_address'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);
			
			
			$jstatus = $value['job_status'];
				    
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }
				    
				    $client_image = !empty($value['client_photo']) ? $this->client_image_url.$value['client_photo'] : "";
				    
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['client_id'],
					'client_name' => $value['client_name'],
					'client_email' => $value['client_email'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['client_phone'],
					'job_status' => $status,
					'client_location' => $client_location

				);
			
}
$i++;
	
}
return $data;
	}
	

	public function get_allcjoblist($user_id){
    $user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){


		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_booking.client_email,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang,ci_booking.pick_comp_date, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('driver',$user_id);
		$this->db->where('pickup_status','1');
		$this->db->join('ci_users', 'ci_users.id = ci_booking.client_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['client_address'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);
			
			 $job_compdate = date('d-m-Y', strtotime($value['pick_comp_date']));
			$jstatus = $value['job_status'];
				    
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }
			$client_image = !empty($value['user_photo']) ? $this->client_image_url.$value['user_photo'] : "";	    
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['client_id'],
					'client_name' => $value['client_name'],
					'client_email' => $value['client_email'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['client_phone'],
					'job_status' => $status,
					'ship_status' => $value['ship_status'],
					'complete_date' => $job_compdate,
					'client_location' => $client_location

				);
			
}
$i++;
	
}
return $data;
	}
	
	
	
	public function get_alldestinationjoblist($user_id){
    $user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){


		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_booking.client_email,ci_client.client_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('second_driver',$user_id);
		//$this->db->where('job_status','0');
		$this->db->join('ci_client', 'ci_client.client_id = ci_booking.client_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['client_address'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);
			
			
			$jstatus = $value['job_status'];
				    
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }
				    
				    $client_image = !empty($value['client_photo']) ? $this->client_image_url.$value['client_photo'] : "";
				    
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['client_id'],
					'client_name' => $value['client_name'],
					'client_email' => $value['client_email'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['client_phone'],
					'job_status' => $status,
					'client_location' => $client_location

				);
			
}
$i++;
	
}
return $data;
	}


	public function get_allcdestinationjoblist($user_id){
    $user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){


		$this->db->select('ci_booking.customer_id,ci_booking.customer_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.customer_firstname,ci_booking.customer_lastname,ci_booking.customer_mobile,ci_booking.customer_email,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.drop_comp_date, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('second_driver',$user_id);
		$this->db->where('delivery_status','1');
		$this->db->join('ci_users', 'ci_users.id = ci_booking.customer_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.customer_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.customer_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.customer_city ', 'Left');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['customer_address'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);
			
			$s_status = $value['ship_status'];
			if($s_status=='0'){
				$ship_status = 'Newly Booked';
			}elseif($s_status=='1'){
				$ship_status = 'Already Picked';
			}if($s_status=='2'){
				$ship_status = 'In Storage';
			}if($s_status=='3'){
				$ship_status = 'In Transit';
			}if($s_status=='4'){
				$ship_status = 'Delivered';
			}if($s_status=='5'){
				$ship_status = 'Problematic';
			}


			 $job_compdate = date('d-m-Y', strtotime($value['drop_comp_date']));
			$jstatus = $value['job_status'];
				    
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }
				    $client_image = !empty($value['user_photo']) ? $this->client_image_url.$value['user_photo'] : "";
				    
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['customer_id'],
					'client_name' => $value['customer_firstname'].' '.$value['customer_lastname'],
					'client_email' => $value['customer_email'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['customer_mobile'],
					'job_status' => $status,
					'ship_status' => $ship_status,
					'complete_date' => $job_compdate,
					'client_location' => $customer_location

				);
			
}
$i++;
	
}
return $data;
	}


	public function get_processjoblist($user_id){
$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){


		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_booking.client_email,ci_client.client_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('driver',$user_id);
		$this->db->where('job_status','1');
		$this->db->join('ci_client', 'ci_client.client_id = ci_booking.client_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');
		$this->db->order_by("ci_booking.id", "DESC");
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['client_address'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);
			
			
			$jstatus = $value['job_status'];
				    
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }
				    
				    $client_image = !empty($value['client_photo']) ? $this->client_image_url.$value['client_photo'] : "";

				    
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['client_id'],
					'client_name' => $value['client_name'],
					'client_email' => $value['client_email'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['client_phone'],
					'job_status' => $status,
					'client_location' => $client_location

				);
			
}
$i++;
	
}
return $data;
	}



	public function get_destinationprocessjoblist($user_id){
	$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){


		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_booking.client_email,ci_client.client_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('second_driver',$user_id);
		$this->db->where('job_status','2');
		$this->db->join('ci_client', 'ci_client.client_id = ci_booking.client_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');
		$this->db->order_by("ci_booking.id", "DESC");
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['client_address'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);
			
			
			$jstatus = $value['job_status'];
				    
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }
				    
			$client_image = !empty($value['client_photo']) ? $this->client_image_url.$value['client_photo'] : "";
	    
				    
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['client_id'],
					'client_name' => $value['client_name'],
					'client_email' => $value['client_email'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['client_phone'],
					'job_status' => $status,
					'client_location' => $client_location

				);
			
}
$i++;
	
}
return $data;
	}


public function finalvale($job_id,$driver_id){

$data = array();
 $query1 = $this->db->query("SELECT * FROM ci_drivers join countries on countries.phonecode=ci_drivers.country_id WHERE ci_drivers.id='$driver_id' ");
    	             $senders =$query1->row_array();
    	              
    if(!empty($senders)){
    
        $currency =  $senders['code']; 
     }else{
       $currency =  'USD';  
     }
    	          

        $this->db->select('*');
        $this->db->from('ci_jobproduct');
        $this->db->where('job_id',$job_id);
    
        $query=$this->db->get();
        $off=$query->result_array();
        $i=0;
        $sum = 0;
        $rent = 0;
        $ftotal = 0;
        foreach ($off as $value) {
        
        $total = ($value['product_qty']*$value['price_range']);
            $sum+= $total;
            $rent+= '0';
           
            
        }
         $ftotal= ($sum+$rent);
       
       if(!empty($off)){
       $data = array(
           'final_value' => $ftotal,
           'currency' => $currency,
           'is_Pay' => TRUE
           
           );
           
       }else{
         $data = array(
           'final_value' => $ftotal,
           'currency' => $currency,
           'is_Pay' => FALSE
           
           );  
           
       }
       
       
         if($currency!=''){  
           $update_data=array('currency' => $currency);
                $where1 = array('id' => $job_id);
    		    $this->db->update('ci_booking', $update_data, $where1);
        
         }
        
return $data;
    }
  
 public function user_check_payment($job_id,$driver_id){
     $data=array();
     $query1 = $this->db->query("SELECT * FROM ci_drivers join countries on countries.phonecode=ci_drivers.country_id WHERE ci_drivers.id='$driver_id' ");
    	             $senders =$query1->row_array();
    	              
     if(!empty($senders)){
    
        $currency =  $senders['code']; 
     }else{
       $currency =  'GBP';  
     }
     
    // $grand_total =  '0';

      $query2 = $this->db->query("SELECT * FROM ci_booking WHERE driver='$driver_id' AND id='$job_id' ");
    $senders2 =$query2->row_array();

	if(!empty($senders2)){
    
        $payment_status =  $senders2['payment_status']; 

        if($payment_status=='Paid'){

        	$grand_total =  $senders2['grand_total']; 

        }else{
            
            $grand_total =  '0';
        }



     }else{
         $grand_total =  '0';
         
     }

    


     $this->db->select('*');
        $this->db->from('ci_jobproduct');
        $this->db->where('job_id',$job_id);
    
        $query=$this->db->get();
        $rowcount = $query->num_rows();
        if($rowcount>0){
        
        
        
        $off=$query->result_array();
        $i=0;
        $sum = 0;
        $rent = 0;
        $ftotal = 0;
        foreach ($off as $value) {
        
        $total = ($value['product_qty']*$value['price_range']);
            $sum+= $total;
            $rent+= '0';
           
            
        }
         $ftotals= ($sum+$rent);

        $ftotal = number_format($ftotals,2,'.','');

        if($grand_total>'0'){
        if($grand_total!=$ftotal){

        	$totals = ($ftotal-$grand_total);
        	$total = number_format($totals,2,'.','');
			$uptotal = ($ftotal+$grand_total);


        }else{
        	$totals = $ftotal;
        	$total = number_format($totals,2,'.','');
        	$uptotal = number_format($totals,2,'.','');

        }
         
         }else{

         	$totals = $ftotal;
        	$total = number_format($totals,2,'.','');
        	$uptotal = number_format($totals,2,'.','');
         }
        		 
     
		$this->db->from('ci_paymetsdetail');
		$this->db->where(array('job_id'=>$job_id,'payment_type !='=>'Cash'));
		$query = $this->db->get();
		$rowcount = $query->row_array();
		if(!empty($rowcount)){
		    $data = array(
           'final_value' => $total,
           'currency' => $currency,
           'is_Pay' => TRUE
           );
		    
		  $jobdata = array(
                      'grand_total' => $uptotal,
                      'currency' => $currency
                     );
                    
                $this->db->where('id', $job_id);
                $jbs = $this->db->update('ci_booking', $jobdata); 
			
		}else{
		   $data = array(
           'final_value' => $total,
           'currency' => $currency,
           'is_Pay' => FALSE
           ); 
		    
		}
        }
		
		return $data;
	} 
  
    
    
    public function get_finaljoblist($job_id,$product_id){
		$data = array();
                $query1 = $this->db->query("SELECT * FROM ci_jobproduct WHERE product_id='$product_id' AND job_id='$job_id' ");
    	             $senders =$query1->row_array();
    	              
    	              $product_prices = $senders['product_price'];
    	              $product_price = number_format($product_prices,2,'.','');

    	              $price_ranges = $senders['price_range'];
    	              $price_range = number_format($price_ranges,2,'.','');
    	               
    	               $data = array(
    	                   'job_id' => $senders['job_id'],
    	                   'product_id' => $senders['product_id'],
    	                   'product_name' => $senders['product_name'],
    	                   'product_qty' => $senders['product_qty'],
    	                   'product_price' => $product_price,
    	                   'price_range' => $price_range,
    	                   'product_image' => $this->product_imagepath.$senders['product_image']
    	                   
    	                   
    	                   );
    	               
 
return $data;
	}
	
	
		public function get_trackdata($job_id){
        $data = array();
        $query1 = $this->db->query("SELECT * FROM ci_track where track_id='$job_id'  ");
    	             $senders =$query1->row_array();
    	             
                $data = array(
                    'track_id' => $senders['track_id'],
                    'job_id' => $senders['job_id'],
                    'driver_id' => $senders['driver_id'],
                    'latitude' => $senders['latitude'],
                    'longitude' => $senders['longitude'],
                    'address' => $senders['address'],
                    'track_date' => $senders['track_date'],
                    'track_datetime' => $senders['track_datetime']
                    
                    );
                
                return $data;
        
	
	}
	
	public function track_list($job_id,$driver_id){
		$data = array();
		$this->db->select('*');
		$this->db->from('ci_track');
		$this->db->where('job_id', $job_id);
		$this->db->where('driver_id', $driver_id);
		$this->db->order_by("track_id", "DESC");
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
		  
		   
			$data[] =array(
				'track_id' => $value['track_id'],
                    'job_id' => $value['job_id'],
                    'driver_id' => $value['driver_id'],
                    'latitude' => $value['latitude'],
                    'longitude' => $value['longitude'],
                    'address' => $value['address'],
                    'track_date' => $value['track_date'],
                    'track_datetime' => $value['track_datetime']

			);		
		}
		$i++;
		return $data;
	}

    
 //*******************************************Jobs For Pickup All *****************************//
 
 
  public function get_alldriversjoblist($user_id){
$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){
			$stat = array('2', '3');
		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_phone,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_users.user_photo,ci_booking.client_email,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang,ci_booking.pick_date,ci_booking.pick_time, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('driver',$user_id);
		$this->db->where('pickup_status','0');
		$this->db->where('delivery_status','0');
		
		$this->db->where_not_in('job_status', $stat);
		$this->db->join('ci_users', 'ci_users.id = ci_booking.client_id ', 'Left');
		$this->db->join('ci_warehouse', 'ci_warehouse.ware_id = ci_booking.warehouseid ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');
		$this->db->order_by("ci_booking.pick_date", "DESC");
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['client_address'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			
            
            $pickup_status = $value['pickup_status'];
            $delivery_status = $value['delivery_status'];
            
            $s_status = $value['ship_status'];
			if($s_status=='0'){
				$ship_status = 'Newly Booked';
			}elseif($s_status=='1'){
				$ship_status = 'Already Picked';
			}if($s_status=='2'){
				$ship_status = 'In Storage';
			}if($s_status=='3'){
				$ship_status = 'In Transit';
			}if($s_status=='4'){
				$ship_status = 'Delivered';
			}if($s_status=='5'){
				$ship_status = 'Problematic';
			}



			$jstatus = $value['job_status'];
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }

$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);

				  $job_date = date('d-m-Y', strtotime($value['pick_date']));	  
				 $client_image = !empty($value['user_photo']) ? $this->client_image_url.$value['user_photo'] : "";
   
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['client_id'],
					'client_name' => $value['client_name'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['client_phone'],
					'pickup_status' => $pickup_status,
					'delivery_status' => $delivery_status,
					'job_status' => $status,
					'job_date' =>$job_date,
					'job_time' => $value['pick_time'],
					'ship_status' => $ship_status,
					'client_location' => $client_location,
					'delivery_data' => $this->firstjobdelivery($value['id'])

				);
			
}
$i++;
	
}
return $data;
	}
	




 public function get_seconddriversjoblist($user_id){
$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){
			$stat = array('2', '3');
		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_booking.client_email,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('second_driver',$user_id);
		//$this->db->where('pickup_status','1');
		$this->db->where('delivery_status','0');
		$this->db->where('ship_status !=','4');
		
		$this->db->where_not_in('job_status', $stat);
		$this->db->join('ci_users', 'ci_users.id = ci_booking.client_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');
		$this->db->order_by("ci_booking.id", "DESC");
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['client_address'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			
			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);
            
            $pickup_status = $value['pickup_status'];
            $delivery_status = $value['delivery_status'];
            
            $s_status = $value['ship_status'];
			if($s_status=='0'){
				$ship_status = 'Newly Booked';
			}elseif($s_status=='1'){
				$ship_status = 'Already Picked';
			}if($s_status=='2'){
				$ship_status = 'In Storage';
			}if($s_status=='3'){
				$ship_status = 'In Transit';
			}if($s_status=='4'){
				$ship_status = 'Delivered';
			}if($s_status=='5'){
				$ship_status = 'Problematic';
			}

			$jstatus = $value['job_status'];
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }
				    
				    $client_image = !empty($value['user_photo']) ? $this->client_image_url.$value['user_photo'] : "";
				    
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['client_id'],
					'client_name' => $value['client_name'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['client_phone'],
					'pickup_status' => $pickup_status,
					'delivery_status' => $delivery_status,
					'job_status' => $status,
					'ship_status' => $ship_status,
					'client_location' => $client_location,
					'delivery_data' => $this->get_jobdelivery($value['id'])

				);
			
}
$i++;
	
}
return $data;
	}
		
	
	
	 public function get_firstdriveremergencyjoblist($user_id){
	      $data = array();
$user_exists = $this->driver_id_exists($user_id);
		
		if($user_exists){

		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('driver',$user_id);
	//	$this->db->or_where('second_driver',$user_id);
		$this->db->where('service_type','1');
		$this->db->join('ci_users', 'ci_users.id = ci_booking.client_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['client_address'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			

			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);
			
			$pickup_status = $value['pickup_status'];
            $delivery_status = $value['delivery_status'];


            $s_status = $value['ship_status'];
			if($s_status=='0'){
				$ship_status = 'Newly Booked';
			}elseif($s_status=='1'){
				$ship_status = 'Already Picked';
			}if($s_status=='2'){
				$ship_status = 'In Storage';
			}if($s_status=='3'){
				$ship_status = 'In Transit';
			}if($s_status=='4'){
				$ship_status = 'Delivered';
			}if($s_status=='5'){
				$ship_status = 'Problematic';
			}
            
			$jstatus = $value['ship_status'];
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }
				    
				    $client_image = !empty($value['user_photo']) ? $this->client_image_url.$value['user_photo'] : "";

				    
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['client_id'],
					'client_name' => $value['client_name'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['client_phone'],
					'pickup_status' => $pickup_status,
					'delivery_status' => $delivery_status,
					'job_status' => $status,
					'ship_status' => $ship_status,
					'client_location' => $client_location,
					'delivery_data' => $this->firstjobdelivery($value['id'])

				);
			
}
$i++;
	
}
return $data;
	}


	public function get_seconddriveremergencyjoblist($user_id){
	      $data = array();
$user_exists = $this->driver_id_exists($user_id);
		
		if($user_exists){

		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name,ci_warehouse.address1,ci_warehouse.name,ci_warehouse.email,ci_warehouse.mobile_no,ci_warehouse.warehouse_image,ci_warehouse.ware_id,ci_warehouse.lat,ci_warehouse.lang');
		$this->db->from('ci_booking');
		$this->db->where('second_driver',$user_id);
	//	$this->db->or_where('second_driver',$user_id);
		$this->db->where('service_type','1');
		$this->db->join('ci_users', 'ci_users.id = ci_booking.client_id ', 'Left');
		$this->db->join('ci_warehouse', 'ci_warehouse.ware_id = ci_booking.warehouseid ', 'Left');
		$this->db->join('countries', 'countries.id = ci_warehouse.country ', 'Left');
		$this->db->join('states', 'states.id = ci_warehouse.state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_warehouse.city ', 'Left');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['address1'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			

			$client_location = array(

	'lat' => $value['lat'],
	'lng' => $value['lang']

);


			
			$pickup_status = $value['pickup_status'];
            $delivery_status = $value['delivery_status'];


            $s_status = $value['ship_status'];
			if($s_status=='0'){
				$ship_status = 'Newly Booked';
			}elseif($s_status=='1'){
				$ship_status = 'Already Picked';
			}if($s_status=='2'){
				$ship_status = 'In Storage';
			}if($s_status=='3'){
				$ship_status = 'In Transit';
			}if($s_status=='4'){
				$ship_status = 'Delivered';
			}if($s_status=='5'){
				$ship_status = 'Problematic';
			}
            
			$jstatus = $value['ship_status'];
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }
				    
				    $client_image = !empty($value['warehouse_image']) ? $this->warehouse_imagepath.$value['warehouse_image'] : "";

				    
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['ware_id'],
					'client_name' => $value['name'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['mobile_no'],
					'pickup_status' => $pickup_status,
					'delivery_status' => $delivery_status,
					'job_status' => $status,
					'ship_status' => $ship_status,
					'client_location' => $client_location,
					'delivery_data' => $this->get_jobdelivery($value['id'])

				);
			
}
$i++;
	
}
return $data;
	}
	
	
	
		public function get_notificationListing($driver_id){
        $data = array();
        $this->db->select('*');
		$this->db->from('ci_notification');
		$this->db->where('driver_id',$driver_id);
		$this->db->join('ci_booking', 'ci_booking.id = ci_notification.job_id ', 'Left');
		$this->db->join('ci_drivers', 'ci_drivers.id = ci_notification.driver_id ', 'Left');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
		  	    $driver_name = $value['firstname'].' '.$value['lastname'];
		  	    $message = $value['message'].' '.$driver_name.' Invoice no : '.$value['invoice_no'];
		  	    
		  	    
				$data[] =array(
				    'notify_id' => $value['notify_id'],
				    'job_id' => $value['job_id'],
					'message' => $message,
					'date' => $value['msg_date']

				);
				
				
			//	$data['total'] = $value['grand_total'];
			
}
$i++;
	

return $data;
	}
	
	
	
	public function invoicedetails($job_id){
		$this->db->select('

					ci_booking.id,

					ci_booking.client_id as client_id,

	    			ci_booking.invoice_no,

	    			ci_booking.customer_id,

	    			ci_booking.items_detail,

	    			ci_booking.payment_status,

	    			ci_booking.job_status,

	    			ci_booking.payment_method,

	    			ci_booking.sub_total,

	    			ci_booking.total_tax,

	    			ci_booking.paid_amount,

	    			ci_booking.balance_amount,


					ci_booking.grand_total,

					ci_booking.currency,

					ci_booking.client_note,

					ci_booking.warehouseid,

					ci_booking.second_driver,

					ci_booking.second_warehouse,

					ci_booking.termsncondition,

					ci_booking.due_date,

					ci_booking.goods,

					ci_booking.created_date,

					ci_booking.service_type,

					ci_booking.location_type,

					ci_booking.goods,

					ci_booking.customer_firstname as customer_firstname,

					ci_booking.customer_lastname as customer_lastname,

					ci_booking.customer_mobile as customer_mobile,

					ci_booking.customer_email as customer_email,

					ci_booking.customer_city as customer_city,

					ci_booking.customer_state as customer_state,

					ci_booking.customer_country as customer_country,

					ci_booking.customer_zipcode as customer_zipcode,

					ci_booking.customer_address as customer_address,



					ci_booking.client_account as client_account,

					ci_booking.client_name as client_name,

					ci_booking.client_lname as client_lname,

					ci_booking.client_company as client_company,

					ci_booking.client_phone as client_phone,

					ci_booking.client_email as client_email,

					ci_booking.client_city as client_city,

					ci_booking.client_state as client_state,

					ci_booking.client_country as client_country,

					ci_booking.client_zip as client_zip,

					ci_booking.client_address as client_address,



					ci_booking.specialinstruction as specialinstruction,

					ci_booking.pick_date as pick_date,

					ci_booking.pick_time as pick_time,

					ci_booking.tracking_number as tracking_number,

					ci_booking.delivery_date as delivery_date,

					ci_booking.ship_mode as ship_mode,

					ci_booking.ship_status as ship_status,

					ci_booking.driver as driver,





					ci_users.firstname,

					ci_users.lastname,

					ci_users.email as client_email,

					ci_users.mobile_no as client_mobile_no,

					ci_users.address as client_address,

					countries.name as country_name,
					states.name as state_name,
					cities.name as city_name,
					cit.name as cust_city_name

					

					'

	    	);

	    	$this->db->from('ci_booking');

	    	$this->db->join('ci_users', 'ci_users.id = ci_booking.customer_id ', 'Left');
	    $this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');

		$this->db->join('countries as co', 'co.id = ci_booking.customer_country ', 'Left');
		$this->db->join('states as st', 'st.id = ci_booking.customer_state ', 'Left');
		$this->db->join('cities as cit', 'cit.id = ci_booking.customer_city ', 'Left');

	    	

	    	$this->db->where('ci_booking.id' , $job_id);

	    	$this->db->order_by("ci_booking.id", "DESC");

	    	$query = $this->db->get();
		
	
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
		  
		  if($value['payment_method']=='credit_card'){
                                                        $mode = "Online Payment";
                                                    }elseif($value['payment_method']=='Paypal or Card Payment'){
                                                        $mode =  "Online Payment";
                                                    }elseif($value['payment_method']=='Credit Card'){
                                                        $mode =  "Online Payment";
                                                    }elseif($value['payment_method']=='cod'){
                                                        $mode =  "Cash On Delivery";
                                                    }elseif($value['payment_method']=='cod'){
                                                        $mode =  "Cash On Delivery";
                                                    }
		   
		   $ship_from = $value['customer_firstname'].' '.$value['customer_lastname'].' '.$value['customer_address'].' '.$value['cust_city_name'];
		   $ship_to = $value['client_name'].' '.$value['client_lname'].' '.$value['client_address'].' '.$value['city_name'];
		   $ship_method = $value['goods'];
		   $ship_date = date_time($value['created_date']);
		   
		   
			$data =array(
				'job_id' => $value['id'],
                    'invoice_no' => $value['invoice_no'],
                    'payment_status' => $value['payment_status'],
                    'payment_mode' => $mode,
                    'ship_from' => $ship_from,
                    'ship_to' => $ship_to,
                    'shipping_method' => $ship_method,
                    'invoice_date' => $ship_date,
                    'products' => $this->productdetaillistings($job_id),
                    'total' => $this->finalvalueofproduct($job_id),
                    'currency' => $value['currency'],

			);		
		}
		$i++;
		return $data;
	}
	
	
	public function productdetaillistings($job_id){
		$this->db->select('*');
		$this->db->from('ci_jobproduct');
		$this->db->where('ci_jobproduct.job_id',$job_id);
		//$this->db->where('ci_jobproduct._id',$job_id);
		$query=$this->db->get();
		$off=$query->result_array();
		$sum = 0;
        $rent = 0;
        $ftotal = 0;
		$i=0;
		foreach ($off as $value1) {
		    $total = ($value1['product_qty']*$value1['price_range']);
            $sum+= $total;
            $rent+= '0';


              $product_prices = $value1['product_price'];
    	              $product_price = number_format($product_prices,2,'.','');

    	              $price_ranges = $value1['price_range'];
    	              $price_range = number_format($price_ranges,2,'.','');
		    
			
				$data[] =array(

					'job_id' => $value1['job_id'],
					'product_id' => $value1['product_id'],
					'product_name' => $value1['product_name'],
					'product_image' => $this->product_imagepath.$value1['product_image'],
					'product_qty' => $value1['product_qty'],
					'product_price' => $product_price,
					'price_range' => $price_range

				);	
				
				
}
$ftotals= ($sum+$rent);
$ftotal = number_format($ftotals,2,'.','');
$i++;




	return $data;
	}

	public function finalvalueofproduct($job_id){
		$this->db->select('*');
		$this->db->from('ci_jobproduct');
		$this->db->where('ci_jobproduct.job_id',$job_id);
		//$this->db->where('ci_jobproduct._id',$job_id);
		$query=$this->db->get();
		$off=$query->result_array();
		$sum = 0;
        $rent = 0;
        $ftotal = 0;
		$i=0;
		foreach ($off as $value1) {
		    $total = ($value1['product_qty']*$value1['price_range']);
            $sum+= $total;
            $rent+= '0';
		    
			
				
				
}
$ftotals= ($sum+$rent);
$i++;

$ftotal = number_format($ftotals,2,'.','');

	return $ftotal;
	}


public function get_detailjobstatus($job_id){
	$data = array();
		$this->db->select('*');
		$this->db->from('ci_booking');
		$this->db->where('ci_booking.id',$job_id);
		//$this->db->where('ci_jobproduct._id',$job_id);
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {


			$jstatus = $value['job_status'];
			$shipstatus = $value['ship_status'];
			$pstatus = $value['payment_method'];

													if($pstatus=='credit_card'){
                                                        $payment_method =  "Online Payment";
                                                    }elseif($pstatus=='Paypal or Card Payment'){
                                                        $payment_method =  "Online Payment";
                                                    }elseif($pstatus=='Credit Card'){
                                                        $payment_method =  "Online Payment";
                                                    }elseif($pstatus=='cod'){
                                                        $payment_method =  "Cash On Delivery";
                                                    }elseif($pstatus=='Cash'){
                                                        $payment_method =  "Cash On Delivery";
                                                    }elseif($pstatus=='cash'){
                                                        $payment_method =  "Cash On Delivery";
                                                    }	




			 		if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }



				    
				    if($shipstatus=='0'){
				       $mystatus = 'Newly Booked'; 
				    }elseif($shipstatus=='1'){
				       $mystatus = 'Already Picked'; 
				    }elseif($shipstatus=='2'){
				       $mystatus = 'In Storage'; 
				    }elseif($shipstatus=='3'){
				       $mystatus = 'In Transit'; 
				    }elseif($shipstatus=='4'){
				       $mystatus = 'Delivered'; 
				    }elseif($shipstatus=='5'){
				       $mystatus = 'Problematic'; 
				    }






			
				$data =array(

					'job_status' => $status,
					'ship_status' => $mystatus,
					'payment_status' => $value['payment_status'],
					'payment_method' => $payment_method

				);	
				
				
}
$i++;
	return $data;
	}


	public function get_otherdetails($user_id,$job_id){
		$data = array();
		$this->db->select('*');
		$this->db->from('ci_booking');
		$this->db->where('ci_booking.id',$job_id);
		//$this->db->where('ci_jobproduct._id',$job_id);
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {

$query12 = $this->db->query("SELECT * FROM ci_drivers join countries on countries.phonecode=ci_drivers.country_id WHERE ci_drivers.id='$user_id' ");
    	             $senders =$query12->row_array();
    	              
    	                   $currency =  $senders['code'];




			
		

		$this->db->select('*');
        $this->db->from('ci_jobproduct');
        $this->db->where('job_id',$job_id);
    
        $query=$this->db->get();
        $off=$query->result_array();
        $i=0;
        $sum = 0;
        $rent = 0;
        $ftotal = 0;
        foreach ($off as $value1) {
        
        $total = ($value1['product_qty']*$value1['price_range']);
            $sum+= $total;
            $rent+= '0';
           
            
        }
       
         $ftotals= ($sum+$rent);

        $ftotal = number_format($ftotals,2,'.','');

        $jobdata = array(
                      'grand_total' => $ftotal,
                      'currency' => $currency
                     );
                    
                $this->db->where('id', $job_id);
                $jbs = $this->db->update('ci_booking', $jobdata); 



			
				$data =array(

					'ship_by' => $value['goods'],
					'ship_mode' => $value['ship_mode'],
					'specialinstruction' => $value['specialinstruction'],
					'invoice_no' => $value['invoice_no'],
					'amount' => $ftotal,
					'currency' => $currency,
					'tracking_number' => $value['tracking_number']
					
				);	
				
				
}
$i++;
	return $data;
	}


public function user_check_jobs($user_id){
		$this->db->from('ci_booking');
		$this->db->where(array('id'=>$user_id));
		$query = $this->db->get();
		$rowcount = $query->row_array();
		if($rowcount){
			return $rowcount;
		}else{
			return $rowcount;
		}
	}




public function get_joblistdetail($user_id,$job_id){
$data = array();
$job = $this->user_check_jobs($job_id);
if(!empty($job)){
		$data['job_id'] = $job_id;
		$data['customer'] = $this->customer_joblistdetail($user_id,$job_id);
		$data['client'] = $this->client_firstjoblistdetail($user_id,$job_id);
		$data['products'] = $this->get_productListing($job_id);
		$data['status'] = $this->get_detailjobstatus($job_id);
		$data['others'] = $this->get_otherdetails($user_id,$job_id);
}
		return $data;
}




	public function customer_joblistdetail($user_id,$job_id){
	$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){


		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.customer_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_lname,ci_booking.client_email,ci_booking.client_phone,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('driver',$user_id);
		$this->db->where('ci_booking.id',$job_id);
		$this->db->join('ci_client', 'ci_client.client_id = ci_booking.client_id ', 'Left');
		$this->db->join('ci_users', 'ci_users.id = ci_booking.client_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');
		//$this->db->order_by("ci_booking.id", "DESC");
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			
			$add2 = $value['client_address'];
			$city1 = $value['city_name'];
			$state1 = $value['state_name'];
			$country1 = $value['country_name'];
			$customer_address = $add2.$prefix.$city1.$prefix.$state1.$prefix.$country1;

		
			
			
			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);
			
			
			$jstatus = $value['job_status'];
			$shipstatus = $value['ship_status'];
				 

			 if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }



				    
				    if($shipstatus=='0'){
				       $mystatus = 'Newly Booked'; 
				    }elseif($shipstatus=='1'){
				       $mystatus = 'Already Picked'; 
				    }elseif($shipstatus=='2'){
				       $mystatus = 'In Storage'; 
				    }elseif($shipstatus=='3'){
				       $mystatus = 'In Transit'; 
				    }elseif($shipstatus=='4'){
				       $mystatus = 'Delivered'; 
				    }elseif($shipstatus=='5'){
				       $mystatus = 'Problematic'; 
				    }
				    
				    $customer_image = !empty($value['user_photo']) ? $this->client_image_url.$value['user_photo'] : "";
				    
				$data =array(
				    
				    'customer_id' => $value['client_id'],
					'customer_name' => $value['client_name'].' '.$value['client_lname'],
					'customer_email' => $value['client_email'],
					'customer_image' => $customer_image,
					'customer_address' => $customer_address,
					'customer_phone_number' => $value['client_phone'],
					'customer_location' => $client_location

				);
			
}
$i++;
	
}
return $data;
	}


	public function client_joblistdetail($user_id,$job_id){
	$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){


		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_booking.client_email,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('driver',$user_id);
		$this->db->where('ci_booking.id',$job_id);
		$this->db->join('ci_users', 'ci_users.id = ci_booking.client_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.client_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.client_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.client_city ', 'Left');
		//$this->db->order_by("ci_booking.id", "DESC");
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['client_address'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;

			

			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);
			
			
			
			$jstatus = $value['job_status'];
			$shipstatus = $value['ship_status'];
				 

			 if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }



				    
				    if($shipstatus=='0'){
				       $mystatus = 'Newly Booked'; 
				    }elseif($shipstatus=='1'){
				       $mystatus = 'Already Picked'; 
				    }elseif($shipstatus=='2'){
				       $mystatus = 'In Storage'; 
				    }elseif($shipstatus=='3'){
				       $mystatus = 'In Transit'; 
				    }elseif($shipstatus=='4'){
				       $mystatus = 'Delivered'; 
				    }elseif($shipstatus=='5'){
				       $mystatus = 'Problematic'; 
				    }
				    
				    $client_image = !empty($value['user_photo']) ? $this->client_image_url.$value['user_photo'] : "";
				    
				$data =array(
				    
				    'client_id' => $value['client_id'],
					'client_name' => $value['client_name'],
					'client_email' => $value['client_email'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['client_phone'],
					'client_location' => $client_location

				);
			
}
$i++;
	
}
return $data;
	}



	public function client_firstjoblistdetail($user_id,$job_id){
	$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){


		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_booking.client_email,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang,ci_warehouse.name as warehousename,ci_warehouse.address1,ci_warehouse.address2,ci_warehouse.email as warehouseemail,ci_warehouse.mobile_no as warehousemobile,ci_warehouse.city as warehousecity,ci_warehouse.state as warehousestate,ci_warehouse.country as warehousecountry,ci_warehouse.warehouse_image as warehouse_image,ci_warehouse.lat as warehouselat,ci_warehouse.lang as warehouselang,ci_warehouse.ware_id, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('driver',$user_id);
		$this->db->where('ci_booking.id',$job_id);
		$this->db->join('ci_users', 'ci_users.id = ci_booking.client_id ', 'Left');
		$this->db->join('ci_warehouse', 'ci_warehouse.ware_id = ci_booking.warehouseid ', 'Left');
		$this->db->join('countries', 'countries.id = ci_warehouse.country ', 'Left');
		$this->db->join('states', 'states.id = ci_warehouse.state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_warehouse.city ', 'Left');
		//$this->db->order_by("ci_booking.id", "DESC");
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['address1'].', '.$value['address2'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;

			

			$client_location = array(

	'lat' => $value['warehouselat'],
	'lng' => $value['warehouselang']

);


			
			
			
			$jstatus = $value['job_status'];
			$shipstatus = $value['ship_status'];
				 

			 if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }



				    
				    if($shipstatus=='0'){
				       $mystatus = 'Newly Booked'; 
				    }elseif($shipstatus=='1'){
				       $mystatus = 'Already Picked'; 
				    }elseif($shipstatus=='2'){
				       $mystatus = 'In Storage'; 
				    }elseif($shipstatus=='3'){
				       $mystatus = 'In Transit'; 
				    }elseif($shipstatus=='4'){
				       $mystatus = 'Delivered'; 
				    }elseif($shipstatus=='5'){
				       $mystatus = 'Problematic'; 
				    }
				    
				    $client_image = !empty($value['warehouse_image']) ? $this->warehouse_imagepath.$value['warehouse_image'] : "";
				    
				$data =array(
				    
				    'client_id' => $value['ware_id'],
					'client_name' => $value['warehousename'],
					'client_email' => $value['warehouseemail'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['warehousemobile'],
					'client_location' => $client_location

				);
			
}
$i++;
	
}
return $data;
	}
	

public function get_destinationjoblistdetail($user_id,$job_id){
$data = array();
$job = $this->user_check_jobs($job_id);
if(!empty($job)){
		$data['job_id'] = $job_id;
		$data['customer'] = $this->get_secondjoblistsdetails($user_id,$job_id);
		$data['client'] = $this->get_dclientjoblistdetails($user_id,$job_id);
		$data['products'] = $this->get_productListing($job_id);
		$data['status'] = $this->get_detailjobstatus($job_id);
		$data['others'] = $this->get_otherdetails($user_id,$job_id);
}
		return $data;
}



	
	public function get_dcusjoblistdetails($user_id,$job_id){
	$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){


		$this->db->select('ci_booking.customer_id,ci_booking.customer_address,ci_booking.customer_city,ci_booking.customer_state,ci_booking.customer_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.customer_firstname,ci_booking.customer_lastname,ci_booking.customer_email,ci_booking.customer_mobile,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name');
  
		$this->db->from('ci_booking');
		$this->db->where('second_driver',$user_id);
		$this->db->where('ci_booking.id',$job_id);
		$this->db->join('ci_client', 'ci_client.client_id = ci_booking.client_id ', 'Left');
		$this->db->join('ci_users', 'ci_users.id = ci_booking.customer_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.customer_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.customer_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.customer_city ', 'Left');
		//$this->db->order_by("ci_booking.id", "DESC");
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			
			$add2 = $value['customer_address'];
			$city1 = $value['city_name'];
			$state1 = $value['state_name'];
			$country1 = $value['country_name'];
			$customer_address = $add2.$prefix.$city1.$prefix.$state1.$prefix.$country1;

			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);
			
			
			$jstatus = $value['job_status'];
			$shipstatus = $value['ship_status'];
				 

			 if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }



				    
				    if($shipstatus=='0'){
				       $mystatus = 'Newly Booked'; 
				    }elseif($shipstatus=='1'){
				       $mystatus = 'Already Picked'; 
				    }elseif($shipstatus=='2'){
				       $mystatus = 'In Storage'; 
				    }elseif($shipstatus=='3'){
				       $mystatus = 'In Transit'; 
				    }elseif($shipstatus=='4'){
				       $mystatus = 'Delivered'; 
				    }elseif($shipstatus=='5'){
				       $mystatus = 'Problematic'; 
				    }
				    
				    $customer_image = !empty($value['user_photo']) ? $this->client_image_url.$value['user_photo'] : "";
				    
				$data =array(
				    
				   	'customer_id' => $value['customer_id'],
					'customer_name' => $value['customer_firstname'].' '.$value['customer_lastname'],
					'customer_email' => $value['customer_email'],
					'customer_image' => $customer_image,
					'customer_address' => $customer_address,
					'customer_phone_number' => $value['customer_mobile'],
					'customer_location' => $customer_location

				);
			
}
$i++;
	
}
return $data;
	}



	public function get_secondjoblistsdetails($user_id,$job_id){
	$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){


		$this->db->select('ci_booking.customer_id,ci_booking.customer_address,ci_booking.customer_city,ci_booking.customer_state,ci_booking.customer_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.customer_firstname,ci_booking.customer_lastname,ci_booking.customer_email,ci_booking.customer_mobile,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang,ci_warehouse.name as warehousename,ci_warehouse.address1,ci_warehouse.address2,ci_warehouse.email as warehouseemail,ci_warehouse.mobile_no as warehousemobile,ci_warehouse.city as warehousecity,ci_warehouse.state as warehousestate,ci_warehouse.country as warehousecountry,ci_warehouse.warehouse_image as warehouse_image,ci_warehouse.lat as warehouselat,ci_warehouse.lang as warehouselang,ci_warehouse.ware_id, countries.name as country_name,states.name as state_name,cities.name as city_name');
  
		$this->db->from('ci_booking');
		$this->db->where('second_driver',$user_id);
		$this->db->where('ci_booking.id',$job_id);
		$this->db->join('ci_client', 'ci_client.client_id = ci_booking.client_id ', 'Left');
		$this->db->join('ci_users', 'ci_users.id = ci_booking.customer_id ', 'Left');
		$this->db->join('ci_warehouse', 'ci_warehouse.ware_id = ci_booking.warehouseid ', 'Left');
		$this->db->join('countries', 'countries.id = ci_warehouse.country ', 'Left');
		$this->db->join('states', 'states.id = ci_warehouse.state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_warehouse.city ', 'Left');
		//$this->db->order_by("ci_booking.id", "DESC");
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			
			$add2 = $value['address1'].', '.$value['address2'];
			$city1 = $value['city_name'];
			$state1 = $value['state_name'];
			$country1 = $value['country_name'];
			$customer_address = $add2.$prefix.$city1.$prefix.$state1.$prefix.$country1;

			$client_location = array(

	'lat' => $value['client_lat'],
	'lng' => $value['client_lang']

);

$customer_location = array(

	'lat' => $value['warehouselat'],
	'lng' => $value['warehouselang']

);
			
			
			$jstatus = $value['job_status'];
			$shipstatus = $value['ship_status'];
				 

			 if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }



				    
				    if($shipstatus=='0'){
				       $mystatus = 'Newly Booked'; 
				    }elseif($shipstatus=='1'){
				       $mystatus = 'Already Picked'; 
				    }elseif($shipstatus=='2'){
				       $mystatus = 'In Storage'; 
				    }elseif($shipstatus=='3'){
				       $mystatus = 'In Transit'; 
				    }elseif($shipstatus=='4'){
				       $mystatus = 'Delivered'; 
				    }elseif($shipstatus=='5'){
				       $mystatus = 'Problematic'; 
				    }
				    
$customer_image = !empty($value['warehouse_image']) ? $this->warehouse_imagepath.$value['warehouse_image'] : "";
				    
				$data =array(
				    
				   	'customer_id' => $value['ware_id'],
					'customer_name' => $value['warehousename'],
					'customer_email' => $value['warehouseemail'],
					'customer_image' => $customer_image,
					'customer_address' => $customer_address,
					'customer_phone_number' => $value['warehousemobile'],
					'customer_location' => $customer_location

				);
			
}
$i++;
	
}
return $data;
	}



	public function get_dclientjoblistdetails($user_id,$job_id){
	$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){


		$this->db->select('ci_booking.customer_id,ci_booking.customer_firstname,ci_booking.customer_lastname,ci_booking.customer_address,ci_booking.customer_email,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.customer_mobile,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('second_driver',$user_id);
		$this->db->where('ci_booking.id',$job_id);
		$this->db->join('ci_users', 'ci_users.id = ci_booking.customer_id ', 'Left');
		$this->db->join('countries', 'countries.id = ci_booking.customer_country ', 'Left');
		$this->db->join('states', 'states.id = ci_booking.customer_state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_booking.customer_city ', 'Left');
		//$this->db->order_by("ci_booking.id", "DESC");
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['customer_address'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;

			
			$client_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);

$customer_location = array(

	'lat' => $value['customer_lat'],
	'lng' => $value['customer_lang']

);

			
			$jstatus = $value['job_status'];
			$shipstatus = $value['ship_status'];
				 

			 if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }



				    
				    if($shipstatus=='0'){
				       $mystatus = 'Newly Booked'; 
				    }elseif($shipstatus=='1'){
				       $mystatus = 'Already Picked'; 
				    }elseif($shipstatus=='2'){
				       $mystatus = 'In Storage'; 
				    }elseif($shipstatus=='3'){
				       $mystatus = 'In Transit'; 
				    }elseif($shipstatus=='4'){
				       $mystatus = 'Delivered'; 
				    }elseif($shipstatus=='5'){
				       $mystatus = 'Problematic'; 
				    }
				    
				    $client_image = !empty($value['user_photo']) ? $this->client_image_url.$value['user_photo'] : "";

				    
				$data =array(
				    
				   'client_id' => $value['customer_id'],
					'client_name' => $value['customer_firstname'].' '.$value['customer_lastname'],
					'client_email' => $value['customer_email'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['customer_mobile'],
					'client_location' => $client_location

				);
			
}
$i++;
	
}
return $data;
	}
	




public function firstjobdelivery($job_id){
	 $data=array();
		$this->db->select('ci_booking.customer_id,ci_booking.customer_address,ci_booking.customer_city,ci_booking.customer_state,ci_booking.customer_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.customer_firstname,ci_booking.customer_lastname,ci_booking.customer_email,ci_booking.customer_mobile,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang,ci_warehouse.name as warehousename,ci_warehouse.address1,ci_warehouse.address2,ci_warehouse.email as warehouseemail,ci_warehouse.mobile_no as warehousemobile,ci_warehouse.city as warehousecity,ci_warehouse.state as warehousestate,ci_warehouse.country as warehousecountry,ci_warehouse.warehouse_image as warehouse_image,ci_warehouse.lat as warehouselat,ci_warehouse.lang as warehouselang,ci_warehouse.ware_id, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('ci_booking.id',$job_id);
		$this->db->join('ci_users', 'ci_users.id = ci_booking.customer_id ', 'Left');
		$this->db->join('ci_warehouse', 'ci_warehouse.ware_id = ci_booking.warehouseid ', 'Left');
		$this->db->join('countries', 'countries.id = ci_warehouse.country ', 'Left');
		$this->db->join('states', 'states.id = ci_warehouse.state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_warehouse.city ', 'Left');
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value1) {
			
			$prefix = ', ';
			$add1 = $value1['address1'].', '.$value1['address2'];
			$city = $value1['city_name'];
			$state = $value1['state_name'];
			$country = $value1['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;
			
			
			


$customer_location = array(

	'lat' => $value1['warehouselat'],
	'lng' => $value1['warehouselang']

);


			
			$customer_image = !empty($value1['warehouse_image']) ? $this->warehouse_imagepath.$value1['warehouse_image'] : "";
				$data =array(

					'reciver_id' => $value1['ware_id'],
					'reciver_name' => $value1['warehousename'],
					'reciver_address' => $final_address,
					'reciver_email' => $value1['warehouseemail'],
					'reciver_image' => $customer_image,
					'reciver_address' => $add1,
					'reciver_phone_number' => $value1['warehousemobile'],
					'reciver_location' => $customer_location,
					'qr_image' => $this->getqrimageofjob($job_id)

				);	
				
				
}
$i++;
	return $data;
	}




public function get_seconddriverjoblisting($user_id){
$user_exists = $this->driver_id_exists($user_id);
		$data = array();
		if($user_exists){

		$this->db->select('ci_booking.client_id,ci_booking.client_address,ci_booking.client_city,ci_booking.client_state,ci_booking.client_country,ci_booking.pickup_status,ci_booking.delivery_status,ci_booking.ship_status,ci_booking.job_status,ci_booking.id,ci_booking.client_name,ci_booking.client_phone,ci_booking.client_email,ci_users.user_photo,ci_booking.customer_lat,ci_booking.customer_lang,ci_booking.client_lat,ci_booking.client_lang,ci_warehouse.name as warehousename,ci_warehouse.address1,ci_warehouse.address2,ci_warehouse.email as warehouseemail,ci_warehouse.mobile_no as warehousemobile,ci_warehouse.city as warehousecity,ci_warehouse.state as warehousestate,ci_warehouse.country as warehousecountry,ci_warehouse.warehouse_image as warehouse_image,ci_warehouse.lat as warehouselat,ci_warehouse.lang as warehouselang,ci_warehouse.ware_id,ci_booking.due_date,ci_booking.pick_time, countries.name as country_name,states.name as state_name,cities.name as city_name');
		$this->db->from('ci_booking');
		$this->db->where('second_driver',$user_id);
		//$this->db->where('pickup_status','1');
		$this->db->where('delivery_status','0');
		$this->db->where('ship_status !=','4');
		$this->db->where('job_status !=','2');
		$this->db->join('ci_users', 'ci_users.id = ci_booking.client_id ', 'Left');
		$this->db->join('ci_warehouse', 'ci_warehouse.ware_id = ci_booking.warehouseid ', 'Left');
		$this->db->join('countries', 'countries.id = ci_warehouse.country ', 'Left');
		$this->db->join('states', 'states.id = ci_warehouse.state ', 'Left');
		$this->db->join('cities', 'cities.id = ci_warehouse.city ', 'Left');
		$this->db->order_by("ci_booking.due_date", "DESC");
		$query=$this->db->get();
		$off=$query->result_array();
		$i=0;
		foreach ($off as $value) {
			$prefix = ', ';
			$add1 = $value['address1'].', '.$value['address2'];
			$city = $value['city_name'];
			$state = $value['state_name'];
			$country = $value['country_name'];
			$final_address = $add1.$prefix.$city.$prefix.$state.$prefix.$country;	
			
			$client_location = array(

	'lat' => $value['warehouselat'],
	'lng' => $value['warehouselang']

);


            
            $pickup_status = $value['pickup_status'];
            $delivery_status = $value['delivery_status'];
            
            $s_status = $value['ship_status'];
			if($s_status=='0'){
				$ship_status = 'Newly Booked';
			}elseif($s_status=='1'){
				$ship_status = 'Already Picked';
			}if($s_status=='2'){
				$ship_status = 'In Storage';
			}if($s_status=='3'){
				$ship_status = 'In Transit';
			}if($s_status=='4'){
				$ship_status = 'Delivered';
			}if($s_status=='5'){
				$ship_status = 'Problematic';
			}

			$jstatus = $value['job_status'];
				    
				    if($jstatus=='0'){
				       $status = 'Pending'; 
				    }elseif($jstatus=='1'){
				       $status = 'Processing'; 
				    }elseif($jstatus=='2'){
				       $status = 'Delivered'; 
				    }elseif($jstatus=='3'){
				       $status = 'Cancel'; 
				    }elseif($jstatus=='4'){
				       $status = 'Postponed'; 
				    }
	
	$job_date = date('d-m-Y', strtotime($value['due_date']));			    
	$client_image = !empty($value['warehouse_image']) ? $this->warehouse_imagepath.$value['warehouse_image'] : "";
				    
				$data[] =array(
				    
				    'job_id' => $value['id'],
					'client_id' => $value['ware_id'],
					'client_name' => $value['warehousename'],
					'client_image' => $client_image,
					'client_address' => $final_address,
					'client_phone_number' => $value['warehousemobile'],
					'pickup_status' => $pickup_status,
					'delivery_status' => $delivery_status,
					'job_status' => $status,
					'job_date' => $job_date,
					'job_time' => $value['pick_time'],
					'ship_status' => $ship_status,
					'client_location' => $client_location,
					'delivery_data' => $this->get_jobdelivery($value['id'])

				);
			
}
$i++;
	
}
return $data;
	}




	public function googlemapApi_list(){
    	 $data=array();
		$query12 = $this->db->query("SELECT * FROM ci_admin WHERE admin_id='1' and username='superadmin' ");
    	             $senders =$query12->row_array();
    	              
    	$data['google_map_api'] =  $senders['google_map_api'];
		return $data;
	}
    
    


} //This end loop braces for class dont delete

	?>