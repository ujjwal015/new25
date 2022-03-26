<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model
{
public function __construct() {

$this->load->database();

}


public function auth_check_email($data='')
{
  $check_email = $data['email']; 
  $this->db->select('*');
  $this->db->from('users');
  $this->db->where('email', $check_email);
  $result = $this->db->get()->row();

  if(!empty($result)) {
    return $result;
  }else{
    return false;
  }
}

public function auth_check_password($data){
    $check_password = $data['password'];

    $result = $this->db->select('*')->from('users')->where(array('email'=>$data['email'], 'password'=> $check_password))->get();

    if($result->num_rows() == 1) {
      return $result->row();
    }else{
      return false;
    }
}

public function insert_data($table, $data){
$data = $this->security->xss_clean($data);
$this->db->insert($table, $data);
// echo $this->db->last_query();die();
return $this->db->insert_id();
}

public function insert_multi_data($table, $data){
$data = $this->security->xss_clean($data);
$this->db->insert_batch($table, $data);
//echo $this->db->last_query();
return $this->db->insert_id();
}

public function insertRecord($table, $data){
$data = $this->security->xss_clean($data);
$this->db->insert($table, $data);
//echo $this->db->last_query();
return $this->db->insert_id();
}

public function rawQuery($sql){
return $this->db->simple_query($sql);
}

function update_data($table, $data, $where){
  if (!empty($where)) {
   $this->db->where($where);
  }

$this->db->update($table, $data);
//echo $this->db->last_query();
return true;
}



public function login($data){
$username = $data['username'];
$password = $data['password'];
$sql 	  = "SELECT * FROM ebn_user WHERE username = ? AND password=?  AND publish=?";

$datar    = array('username'=>$username,'password'=>md5($password),'publish'=>1);

$query = $this->db->query($sql,$datar);

$num =  $query->row();

if(count($num) == 1)

{	$row = $query->row();

$data 		= array(

'userid' 		=> $row->uid,

'useremail' 	=> $row->email,

'username' => $row->username,

'name' 		 => $row->name,

'is_user' 	=> true

);

$this->session->set_userdata($data);

return true;

}

return false;

} 

public function admin_login($data){
$username = $data['email'];
$password = $data['password'];
$sql 	  = "SELECT * FROM users WHERE email = ? AND password=? ";

$datar    = array('email'=>$username,'password'=>md5($password));

$query = $this->db->query($sql,$datar);

$num =  $query->row();

if(count($num) == 1)

{	$row = $query->row();

$data 		= array(

'admin_id' 		=> $row->user_id,

'admin_email' 	=> $row->email,

'admin_username' 	=> $row->first_name.' '.$row->last_name,

'admin_name'    => $row->first_name,

'role' 		=> $row->role,

'is_admin' 	=> true

);

$this->session->set_userdata($data);

return true;

}

return false;

}

public function getRecords($dataset="",$table, $culumns='', $join=array()){

if($dataset) $this->db->where($dataset);

if($culumns) $this->db->select($culumns);

if( is_array($join) && count($join)){

$this->db->join($join[0], $join[1], $join[2]);

}
$this->db->order_by('id','DESC');
$query = $this->db->get($table);

//echo $this->db->last_query(); exit;

return $query->result();

}


public function getNewRecords($dataset="",$table, $culumns='', $join=array()){

if($dataset) $this->db->where($dataset);

if($culumns) $this->db->select($culumns);

if( is_array($join) && count($join)){

$this->db->join($join[0], $join[1], $join[2]);

}
$this->db->order_by('pay_id','DESC');
$query = $this->db->get($table);

//echo $this->db->last_query(); exit;

return $query->result();

}



public function getFileupload($dataset="",$table, $like=array(),$limit, $offset, $join=array()){

if($dataset) $this->db->where($dataset);

if($like)  $this->db->like($like);

if( is_array($join) && count($join)){

$this->db->join($join[0], $join[1], $join[2]);

}

if($limit)

$this->db->limit($limit, $offset);

$query = $this->db->get($table);

//echo $this->db->last_query(); exit;

return $query->result();

}



public function getDataItem($dataset="",$column,$table){

if($column)$this->db->select($column);

if($dataset) $this->db->where($dataset);

$query = $this->db->get($table);

$this->db->last_query();

return $query->result();

}

public function getRows($table,$dataset="",$limit,$offset){

$this->db->where($dataset);

$this->db->from($table);

$this->db->limit($limit,$offset);

$query = $this->db->get()->result();

$this->db->last_query();

return $query;

}

public function getnumRows($table){

$this->db->select('count(*) as total');

$this->db->from($table);

$query = $this->db->get();

$total = $query->row()->total;

return $total;

}

function getData($table, $where='', $select=' * ', $join=array(), $order_by = ''){

$this->db->select($select);

if(!empty($where)){

$this->db->where($where);

}

if(!empty($order_by)){

$this->db->order_by($order_by);

}

if( is_array($join) && count($join)){

$this->db->join($join[0], $join[1], $join[2]);

}

$query = $this->db->get($table);

// $this->db->last_query();



return $query->row();

}

public function getnumRow($table,$where=""){

if($where) $this->db->where($where);

$this->db->select('count(*) as total');

$this->db->from($table);

$query = $this->db->get();

//echo $this->db->last_query(); exit;

$total = $query->row()->total;

return $total;

}



public function getnumRowOR($table,$where=""){

if($where) $this->db->or_where($where);

$this->db->select('count(*) as total');

$this->db->from($table);

$query = $this->db->get();

//echo $this->db->last_query(); exit;

$total = $query->row()->total;

return $total;

}



public function getnumRec($table,$where="",$like=array()){

if($where) $this->db->where($where);

if($like)  $this->db->like($like);

$this->db->select('count(*) as total');

$this->db->from($table);

$query = $this->db->get();

//echo $this->db->last_query(); exit;

$total = $query->row()->total;

return $total;

}



public function cdel($id,$column,$table){

$this->db->where($column, $id);

$res = $this->db->delete($table);

if($res)

return true;

}

public function deleteItem($data,$table){

$this->db->where($data);

$res = $this->db->delete($table);

if($res)

return true;

}

public function cupdate($data,$id,$column,$table){
$data['updated_at'] 		= date("Y-m-d h:i:s");

$data = $this->security->xss_clean($data);

$this->db->where($column, $id);

$res = $this->db->update($table, $data);

// echo $this->db->last_query(); die;

if($res) 
return true;

}

public function updateItem($data,$where,$table){

// $data['modified'] 		= date("Y-m-d h:i:s");

$data = $this->security->xss_clean($data);

$this->db->where($where);

$res = $this->db->update($table, $data);

if($res)

return true;

}
public function softDelete(array $where,string $table){

$data['deleted_at']     = date("Y-m-d h:i:s");

$data = $this->security->xss_clean($data);

$this->db->where($where);

$res = $this->db->update($table, $data);

if($res)

return true;

}

public function getRecord($dataset,$table,$join=array()){

  if( is_array($join) && count($join)){
    $this->db->join($join[0], $join[1], $join[2]);
  }
  $this->db->where($dataset);

  $query = $this->db->get($table);

//echo $this->db->last_query(); exit;

return $query->row();

}

 function fetch_single_details($customer_id)
 {
  $this->db->where('id', $customer_id);
  $data = $this->db->get('product_rent');
  
      $this->db->where('product_rent_id', $customer_id);
      $productData = $this->db->get('product_rent_item');

      $wher['product_rent_id'] = $wher1['id'] = $customer_id;
      
      $dataset = $this->getRecords($wher,'product_rent_item', '', '');
      
      $productUser = $this->getRecord($wher1,'product_rent'); 

      $wher2['user_id'] = $productUser->user_id;

      $userDetail = $this->getRecord($wher2,'users');

      $userFName = !empty($userDetail->first_name) ? $userDetail->first_name:'NA';
      $userLName = !empty($userDetail->first_name) ? $userDetail->first_name:'NA';
      $userPhone = !empty($userDetail->phone) ? $userDetail->phone:'NA';
      $userEmail = !empty($userDetail->email) ? $userDetail->email:'NA';
      $userAddress = !empty($userDetail->address1) ? $userDetail->address1:'NA';
      $userName = $userFName.' '.$userLName;

      if (!empty($productUser->created_date) && $productUser->created_date !='0000-00-00'){    
        $newDate = date("d-M-Y", strtotime($productUser->created_date)); 
      }else{
        $newDate = date("d-M-Y", strtotime($productUser->created_at));
      }


      // $userName = $userDetail->first_name.' '.$userDetail->last_name ;

  $output = '<div class="container"><div class="row">';
  $file = base_url("assets/img/logo/new-logo.png");

  $randNo = mt_rand(100, 999);
  $invoiceNo = "#". $customer_id.''.$randNo;
  $output .= ' 
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="row p-5">
                        <div class="col-md-4">
                            <img src="$file">
                        </div>
                        <div class="col-md-6 text-right" style="text-align:right;margin-top:-80px;">
            <span class="font-weight-bold mb-1">Invoice '.$invoiceNo.'</span><br>
                            <span class="text-muted">Due to: '.date('d M, Y').'</span><br>
            <span>Adress: Makrand Nagar, kannauj-209726</span><br>
            <span>Mobile : 9918538880,8318016147</span>
                            
                        </div>
                    </div>
                    <hr class="my-5">
                    <div class="row pb-5 p-5">
                        <div class="col-md-6">
                            <p class="font-weight-bold mb-8" style="color:red;">Customer Information</p>
                            <span>'.$userName.'</span><br>
                            <span><b>Adress : </b> '.$userAddress.'</span><br> 
                            <span><b>Email Id :</b> '.$userEmail.'</span><br>
                            <span><b>Phone No. :</b> +91 '.$userPhone.'</span><br>
                            
                        </div>
                    </div>
                    <div class="row p-5">
                        <div class="col-md-12">
                            <table class="table" border="1" cellpadding="5" style="width:100%">
                                <thead >
                                    <tr style="background-color: #B32C39;">
                                        <th>ID</th>
                                        <th >Image</th>
                                        <th >Item</th>
                                        <th >Weight</th>
                                        <th >Unit Cost</th>
                                        <th >Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    $garandTotal = '';
                    if (!empty($dataset)) {
                     
                    foreach ($dataset as $key => $value) { 

                      $key = $key + 1;
                      $wherr['id'] = $value->product_unit_id;
                    
                      $unitDetail  = $this->jwellery_model->getRecord($wherr,'product_unit');
                      
                      if (!empty($value->product_image) && file_exists("upload/product/".$value->product_image)) {
                        $file = base_url("upload/product/".$value->product_image);
                      }else{
                        $file = base_url("upload/product/img.jpg");
                      } 
                      
                      $unitName = !empty($unitDetail->unit_name) ? $unitDetail->unit_name:'';
              
                    $output .='<tr style="border-bottom: 1px solid #ddd;">
                                    <td>'. $key .'</td>
                                    <td><img src="'.$file.'"  class="img-responsive" style="width:70px"/></td>
                                    <td>'.$value->product_name.'</th>
                                    <td>'.$value->product_weight.' '.$unitName.'</td> 
                                    <td>'.$value->product_rate.'</td> 
                                    <td>'.$value->total_amount.'</td> 
                                </tr>';   
                    $garandTotal = $garandTotal + $value->total_amount;
                            }
                          }              
                     $output .='</tbody>
                            </table>
                        </div>
                    </div> 
                      <div class="col-md-4">
                            
                        </div> 
                        <div class="col-md-6 text-right" style="text-align:right;margin-top:20px;">
                         <span><b>AMOUNT TOTAL :</b> Rs.'.$garandTotal.'</span><br>
                          <span><b>AMOUNT PAID :</b> Rs.'.$productUser->give_amount.'</span><br>
                          <span><b>Amount PENDING :</b>  Rs.'.$productUser->pending_amount.'</span> 
                            
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse bg-dark text-white p-4">
                        <div class="py-3 px-5 text-right">
                           <span> Issue Date '.$newDate.'</span><br>
                            <span>Due Date '.date('d/M/Y', strtotime($productUser->last_date)).'</span>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-light mt-5 mb-5 text-center small">by : <a class="text-light" target="_blank" href="http://singhjeweler.com">Singh Jewler</a>
   ';
  $output .= '</div></div> 
  ';
  // $output .= '</table>';
  return $output;
 }


 function product_buy_single_details($id)
 {

  $wher1['id'] = $id;
       
  $productDetail = $this->getRecord($wher1,'product_buy');

  $wher2['user_id'] = $productDetail->user_id;

  $userDetail = $this->getRecord($wher2,'users');

  $userName = $userDetail->first_name.' '.$userDetail->last_name ;

  $randNo = mt_rand(100, 999);
  $invoiceNo = "#". $id.''.$randNo;

  if (!empty($productDetail->created_date) && $productDetail->created_date !='0000-00-00'){    
    $newDate = date("d-M-Y", strtotime($productDetail->created_date)); 
  }else{
    $newDate = date("d-M-Y", strtotime($productDetail->created_at));
  }

  $output = '';
  $output = '<div class="container"><div class="row">';  
  $output .= ' 
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="row p-5">
                        <div class="col-md-4">
                            <img src="$file">
                        </div>
                        <div class="col-md-6 text-right" style="text-align:right;margin-top:-80px;">
            <span class="font-weight-bold mb-1">Invoice '.$invoiceNo.'</span><br>
                            <span class="text-muted">Due to: '.date('d M, Y').'</span><br>
            <span>Adress: Makrand Nagar, kannauj-209726</span><br>
            <span>Mobile : 9918538880,8318016147</span>
                            
                        </div>
                    </div>
                    <hr class="my-5">
                    <div class="row pb-5 p-5">
                        <div class="col-md-6">
                            <p class="font-weight-bold mb-8" style="color:red;">Customer Information</p>
                            <span>'.$userName.'</span><br>
                            <span><b>Adress : </b> '.$userDetail->address1.'</span><br> 
                            <span><b>Email Id :</b> '.$userDetail->email.'</span><br>
                            <span><b>Phone No. :</b> +91 '.$userDetail->phone.'</span><br>
                            
                        </div>
                    </div>
                    <div class="row p-5">
                        <div class="col-md-12">
                            <table class="table" border="1" cellpadding="5" style="width:100%">
                                <thead >
                                    <tr style="background-color: #B32C39;">
                                        <th>ID</th> 
                                        <th>Product Name</th>
                                        <th>Product Weight</th> 
                                        <th>Product Rate</th> 
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>'; 
                    $output .='<tr style="border-bottom: 1px solid #ddd;">
                                    <td>1</td> 
                                    <td>'.$productDetail->product_name.'</th>
                                    <td>'.$productDetail->product_weight.' '.$unitName.'</td> 
                                    <td>'.$productDetail->product_rate.'</td> 
                                    <td>'.$productDetail->total_amount.'</td> 
                                </tr>';  
                    $GST = 0;
                    $GT = (!empty($productDetail->making_charge) ? $productDetail->making_charge:'0' );
                    $GST_CHARGE = (!empty($productDetail->gst_charge) ? $productDetail->gst_charge:'0' );
                    if ($GST_CHARGE > 0) {
                      $GST = $productDetail->total_amount / $GST_CHARGE;
                    }
                    

                    $GTOTAL = $productDetail->total_amount + $GT + $GST;

                     $output .='</tbody>
                            </table>
                        </div>
                    </div> 
                      <div class="col-md-4">
                            
                        </div> 
                        <div class="col-md-6 text-right" style="text-align:right;margin-top:20px;">
                        <span><b> TOTAL :</b> Rs.'.$productDetail->total_amount.'</span><br>
                        <span><b>Making Charge :</b> Rs.'.(!empty($productDetail->making_charge) ? $productDetail->making_charge:'0' ).'</span><br>
                        <span><b>GST Charge :</b>  Rs.'.(!empty($productDetail->gst_charge) ? $productDetail->gst_charge:'0' ).' %</span> <br>
                        <span><b>Grand Total Amount :</b>  Rs.'.$GTOTAL.'</span> <br>
                        <span><b>Paid Total Amount :</b>  Rs.'.(!empty($productDetail->paid_amount) ? $productDetail->paid_amount:'0' ).'</span> <br>
                        <span><b>Pending Amount :</b>  Rs.'.(!empty($productDetail->pending_amount) ? $productDetail->pending_amount:'0' ).'</span>  
                            
                        </div>
                    </div> 
                    <div class="d-flex flex-row-reverse bg-dark text-white p-4">
                        <div class="py-3 px-5 text-right">
                           <span> Issue Date '.$newDate.'</span><br>
                            <span>Due Date '.date('d/M/Y', strtotime($productDetail->last_date)).'</span>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-light mt-5 mb-5 text-center small">by : <a class="text-light" target="_blank" href="http://singhjeweler.com">Singh Jewler</a>
   ';
  return $output;
}


public function getRowRecord($table,$dataset,$select){

$this->db->where($dataset);

$query = $this->db->get($table);

$this->db->last_query();

return $query->row();

}

private function get_client_ip() {

$ipaddress = '';

if (isset($_SERVER['HTTP_CLIENT_IP']))

$ipaddress = $_SERVER['HTTP_CLIENT_IP'];

else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))

$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];

else if(isset($_SERVER['HTTP_X_FORWARDED']))

$ipaddress = $_SERVER['HTTP_X_FORWARDED'];

else if(isset($_SERVER['HTTP_FORWARDED_FOR']))

$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];

else if(isset($_SERVER['HTTP_FORWARDED']))

$ipaddress = $_SERVER['HTTP_FORWARDED'];

else if(isset($_SERVER['REMOTE_ADDR']))

$ipaddress = $_SERVER['REMOTE_ADDR'];

else

$ipaddress = 'UNKNOWN';

return $ipaddress;

}



public function insertData($table, $data){

$data = $this->security->xss_clean($data);

$this->db->insert($table, $data);

echo $this->db->last_query(); exit;

return $this->db->insert_id();

}





public function getDataRows($table, $where='', $limit, $offset, $group_by = '', $order_by, $join=''){

			if(!empty($where)){

				$this->db->where($where);

			}

			if( is_array($join) && count($join)){

				$this->db->join($join[0], $join[1], $join[2]);

			}

			if(!empty($group_by)){

				$this->db->group_by($group_by);

			}

			if(!empty($order_by)) {

				$this->db->order_by($order_by);

			}

			if($limit)

				$this->db->limit($limit, $offset);

			$query = $this->db->get($table);

			//echo $this->db->last_query();

			return $query->result();

		}

		

public function getDataRec($table, $where='', $limit, $offset, $group_by = '', $order_by,$like=array(), $join=''){

			if(!empty($where)){

				$this->db->where($where);

			}

			if(!empty($like)){

				$this->db->like($like);

			}

			if( is_array($join) && count($join)){

				$this->db->join($join[0], $join[1], $join[2]);

			}

			if(!empty($group_by)){

				$this->db->group_by($group_by);

			}

			if(!empty($order_by)) {

				$this->db->order_by($order_by);

			}

			if($limit)

				$this->db->limit($limit, $offset);

			$query = $this->db->get($table);

			//echo $this->db->last_query();

			return $query->result();

		}

		

public function getFolders($data,$limit,$offset){

		$selectCol="f.*,d.*";

		$this->db->select($selectCol, false);

		$this->db->from('ebn_filedata as d');

		$this->db->join('ebn_folder as f','f.catid = d.catid','left');

		if($data)$this->db->where($data);

		//$this->db->order_by("t.citationid","desc");

		if($limit)$this->db->limit($limit, $offset);

		$query = $this->db->get()->result();

		echo $this->db->last_query(); exit;

		return $query;

	}	

  public function uploadImage($file,$path){
  $fileName = md5(time().uniqid("filename", true));
  $config = array(
  'upload_path' => $path,
  'allowed_types' => "gif|jpg|png|jpeg",
  'overwrite' => FALSE,
  'file_name' => $fileName,
  'max_size' => "8004800",
  );
  $_FILES['uploadedimage']['name'] = $file['name'];
  $_FILES['uploadedimage']['type'] = $file['type'];
  $_FILES['uploadedimage']['tmp_name'] = $file['tmp_name'];
  $_FILES['uploadedimage']['error'] = $file['error'];
  $_FILES['uploadedimage']['size'] = $file['size'];
  $this->load->library('upload');
  $this->upload->initialize($config);
  $result = array();
  if ( $this->upload->do_upload('uploadedimage') )
  {
  $data['upload_data'] = $this->upload->data();
  $result['message'] = 1;
  $result['filename'] = $data['upload_data']['file_name'];
  return $result;
  }
  else{
  $result['message'] = 0;
  $result['error'] = $this->upload->display_errors(); 
  return $result;
  }
  }	
  
  
  
  public function get_invoice_by_id($id){



			$this->db->from('tbl_payment_history');
            $this->db->join('users', 'users.id = tbl_payment_history.user_id ', 'Left');
            $this->db->join('tbl_packages', 'tbl_packages.id = tbl_payment_history.package_id ', 'Left');
	    	$this->db->where('tbl_payment_history.pay_id' , $id);

	    	$query = $this->db->get();					 

			return $query->row_array();



		}
		
		public function admindetails(){



			$this->db->from('users');
            $this->db->where('users.id' , 1);

	    	$query = $this->db->get();					 

			return $query->row_array();



		}
  
  
  
  
  
  
  
  
  
  
  
  
  
  
}
?>