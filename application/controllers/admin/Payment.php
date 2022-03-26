<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

    public function __construct() {
        parent::__construct(); 
        $this->load->helper('form');
		$this->load->library('form_validation'); 
        $this->load->helper('security');
        $this->load->library('pagination');
        $this->load->library('email');
        if (empty($this->session->userdata('is_admin'))) {
            redirect(base_url('login'));
        }
    }

    public function index() { 
        $data['title'] = "Admin | Payment";
        $data['record'] = $this->db->select('*')->from('tbl_payment_details')->get()->row();
        $this->load->view('admin/payment', $data);
        // $this->load->view('footer');
    }
      
    public function invoice($id='') { 
        if (!empty($id)) {
            $data['title'] = "Admin | Invoices Details";
            $where['tbl_payment_history.pay_id']=$id;
            $joinArr = ['tbl_packages','tbl_packages.id=tbl_payment_history.package_id','left'];
            $data['details'] = $this->common_model->getNewRecords($where,'tbl_payment_history',$joinArr);
            // echo $this->db->last_query();die;
            $this->load->view('admin/invoice-detail', $data);
        }else{
            $culumns=['tbl_payment_history.*','users.id as user_id','users.username as subdomain'];
            $data['title'] = "Admin | Invoices";
            $joinArr = ['users','users.id=tbl_payment_history.user_id','left'];
            $data['listRecord'] = $this->common_model->getNewRecords('','tbl_payment_history',$culumns,$joinArr);
            $this->load->view('admin/invoices', $data);
        }
        
        // $this->load->view('footer');
    }
    
    
    public function invoiceEdit($id='') { 
        if (!empty($id)) {
            $data['title'] = "Admin | Invoices Details";
            $where['tbl_payment_history.pay_id']=$id;
            $joinArr = ['tbl_packages','tbl_packages.id=tbl_payment_history.package_id','left'];
            $data['details'] = $this->common_model->getRecord($where,'tbl_payment_history',$joinArr);
            // echo $this->db->last_query();die;
            $this->load->view('admin/invoice-edit', $data);
        }
        
        // $this->load->view('footer');
    }
    
    public function updateInvoice($id='') { 
        if (!empty($id)) {
           // echo $id;
            $setData = $this->input->post();
           // print_r($setData);
            
            $this->input->post('payment_status');
            $user_id = $this->input->post('user_id');
            $data1 = array( 'package_id' => $this->input->post('package_id'), 'max_user_allowed' => $this->input->post('max_user'),'package_price' => $this->input->post('package_price'),'package_name' => $this->input->post('package_title') );
            
            
            $data = array( 'Payment_state' => $this->input->post('payment_status') );
            $where = array( 'pay_id' => $id );
            $where1 = array( 'id' => $id );
            $where2 = array( 'id' => $user_id );
           $res = $this->common_model->update_data('tbl_payment_history',$setData,$where);
           $res1 = $this->common_model->update_data('package_payments',$data,$where1);
           $res2 = $this->common_model->update_data('users',$data1,$where2);
                
           // exit;
           
            redirect(base_url('admin/payment/invoiceEdit/'.$id));
     
            
           
        }
        
        // $this->load->view('footer');
    }
    
    
     
    public function save($id='') { 
        $setData = $this->input->post();
        if($_FILES['qr_image']['name']){   
            $setData['image_path'] = $dataSet['image_path'] = "upload/avatars";
            if( ! file_exists($setData['image_path']) ){
            mkdir($setData['image_path'], 0755, true);
            }   
            $filedata = $this->common_model->uploadImage($_FILES['qr_image'],$setData['image_path']);
            if(!$filedata['message']){
            $this->session->set_flashdata('message', $filedata['error']);
                redirect(base_url('admin/payment')); 
            }else{
            $setData['qr_image'] = $filedata['filename'];
            }
        }else{
            unset($setData['qr_image']);
        }
        
        
        
        $setData['gateway_name'] ='paypal_pay';
        $isRow = $this->db->select('id')->from('tbl_payment_details')->get()->row();
        if (!empty($isRow)) {
            $res = $this->common_model->update_data('tbl_payment_details',$setData,'');
            $this->session->set_flashdata('message','Record Save Successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        } 
        $res = $this->common_model->insert_data('tbl_payment_details',$setData);
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
    
    
    
    
    
    function sendInvoice($id)
    {
    
    //echo $id;
    // $culumns=['tbl_payment_history.*','users.id as user_id','users.first_name','users.last_name','users.username','users.email'];
            
    //         $where['tbl_payment_history.id']=$id;
    //         $joinArr = ['tbl_packages','tbl_packages.id=tbl_payment_history.package_id','left'];
    $admindetails = $this->common_model->admindetails();
    
            $details = $this->common_model->get_invoice_by_id($id);
    $data['details'] = $this->common_model->get_invoice_by_id($id);
            // echo $this->db->last_query();die;
         //   print_r($admindetails);
          
    
     $email = $details['email'];
                 
                         $logo_url = "https://door2doorsoftware.com/d2d/".$details['logo_url'];
    
                  

    
        $from_email = 'noreplys@door2doorsoftware.com'; //change this to yours
       
        $to_email = $details['email'];
        
      
        
        $subject = 'Invoice : Door2Door';
        
    $logo = site_url()."/public/assets/img/logo.png";
    
    if($logo_url==''){
       $complogo_url =  $logo; 
    }else{
        
       $complogo_url =  $logo_url;
    }
    
  $valid = $details['valid_for_days'] ?? '30';
  $cvalid = $details['created_at'];
                                            $exDate=date_create(date('Y-m-d'));
                                            date_add($exDate,date_interval_create_from_date_string($valid." days"));
                                            $dateValid = changeDateFormat('M/d/Y',date_format($exDate,"Y-m-d")); 
    
    $cdateValid = date('M/d/Y'); 
    
    $background = site_url()."/public/assets/img/invoice-background.png";
       
        
 
        $mailContent ='<body style="background-color:#e2e1e0 !important;font-family: Open Sans, sans-serif;font-size:100%;line-height:1.4;color:#000;">
         <table style="max-width:670px;width:100%;margin:50px auto 10px;background-color:#fff !important;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);">
            <thead>
               <tr>
                  <th style="text-align: left; font-size: 13px;">Invoice#'.$details['pay_id'].'</th>
                  <th style="text-align:right; font-size: 12px;">Date-issue:'.$cdateValid.'  Date-due:'.$dateValid.' </th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <th style="text-align: left; font-size: 34px; color:cornflowerblue">Invoice <span style="font-size: 22px; color: #000;"><br>Door2Door</span></th>
                  <!-- <th style="">Invoice</th> -->
                  <th style="text-align:right;font-weight:400; "><img style="max-width: 80px;" src="https://door2doorsoftware.com/upload/avatars/f21628925ca7c7e532da1452240ed012.png"></th>
               <tr>
                  <td colspan="2" style="height:35px; border-bottom: 1px solid rgba(0, 0, 0, 0.125);"></td>
               </tr>
               <tr>
                  <td style="width:50%;padding:20px;vertical-align:top">
                     <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">Billing From</span> '.$admindetails['first_name'].'</p>
                     <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-size:13px;">'.$admindetails['email'].'</span></p>
                     <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-size:13px;">'.$admindetails['full_address'].'</span> </p>
                     <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-size:13px;">'.$admindetails['phone'].'</span> </p>
                  </td>
                  <td style="width:50%;padding:20px;vertical-align:top">
                     <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Billing to</span>'.$details['first_name'].' '.$details['last_name'].'</p>
                     <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-size:13px;">'.$details['email'].'</span></p>
                     <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-size:13px;">'.$details['phone'].'</span></p>
                  </td>
               </tr>
               <tr>
                  <td colspan="2" style="height:35px; border-bottom: 1px solid rgba(0, 0, 0, 0.125);"></td>
               </tr>
               <tr>
                  <td style="width: 100%;">
                     <table style="width:143%; height:auto; background-color:#fff;text-align:center; padding:10px;">
                        <tbody>
                           <tr style="color:#6c757d; font-size: 20px;">
                              <td style="border-right:1.5px dashed  #DCDCDC; width:20%;font-size:12px;font-weight:700;padding: 0px 0px 10px 0px;">Package Name</td>
                              <td style="border-right:1.5px dashed  #DCDCDC; width:20%;font-size:12px;font-weight:700;padding: 0px 0px 10px 0px;">description</td>
                              <td style="border-right: 1.5px dashed  #DCDCDC ;width:20%;font-size:12px;font-weight:700;padding: 0px 0px 10px 0px;">Cost</td>
                              <td style="border-right:1.5px dashed  #DCDCDC ;width:20%;font-size:12px;font-weight:700;padding: 0px 0px 10px 0px;">transaction Id</td>
                              <td style="width:20%;font-size:12px;font-weight:700;padding: 0px 0px 10px 0px;">Max-user</td>
                           </tr>
                           <tr style="background-color:#fff; font-size:12px; color:#262626;">
                              <td style="border-right:1.5px dashed  #DCDCDC ;width:20%; font-weight:bold;background: #fafafa;">'.$details['package_name'].'</td>
                              <td style="border-right:1.5px dashed  #DCDCDC ;width:20%; font-weight:bold;background: #fafafa;">'.$details['long_description'].'</td>
                              <td style="border-right:1.5px dashed  #DCDCDC ;width:20% ; font-weight:bold;background: #fafafa;">'.$details['regular_price'].'</td>
                              <td style="border-right:1.5px dashed  #DCDCDC ;width:20%; font-weight:bold;background: #fafafa;">'.$details['payment_id'].'</td>
                              <td style="width:20%; font-weight:bold;background: #fafafa;">'.$details['max_user_allowed'].'</td>
                           </tr>
                           <tr>
                              <td colspan="5" style="height:35px; border-bottom: 1px solid rgba(0, 0, 0, 0.125);"></td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               
            </tbody>
            <tfooter>
               <tr>
                  <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
                     <p style="display:block;margin:0 0 10px 0;">Thanks for your Business</p>
                     <br><br>
                  </td>
               </tr>
               <tr style="text-align: right;">
                  <td style=" padding: 0px 8px; line-height: 20px;"><span>Subtotal</span></td>
                  <td style=" padding: 0px 8px; line-height: 20px;">Euro '.$details['regular_price'].'</td>
               </tr>
               <tr style="text-align: right;">
                  <td style=" padding: 0px 8px; line-height: 20px;"><span>Invoice Total</span></td>
                  <td style=" padding: 0px 8px; line-height: 20px;">Euro '.$details['regular_price'].'</td>
               </tr>
            </tfooter>
         </table>
      </body>';

  //  echo $mailContent;exit;

 if($to_email!="") {
                /*--------------------Email----------------------*/
                    
                $to_email = $details['email'];
               
                $from = 'noreplys@door2doorsoftware.com';
                $fromName = 'Door2Door';
                $mailSubject = "Invoice Mail :Door2Door";
                $myemail = 'anshul.srivastava@nbgspl.com';
               
                    
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                
                $this->email->to($to_email);
                $this->email->cc($myemail);
                $this->email->bcc($myemail);
                $this->email->from($from, $fromName);
                $this->email->subject($mailSubject);
                $this->email->message($mailContent);
               
           
                
        
                // send email
                if ($this->email->send())
                {
                //  successfully sent mail
               //  echo "Sent";exit;
                 
                    $this->session->set_flashdata('message', 'Invoice Send on mail Successfully!');
                   // $this->load->view('admin/invoice-detail', $data);
                  redirect(base_url('admin/payment/invoice/'.$id));
                }
                else
                {
                //  error
                // echo "Not Sent";exit;
                    $this->session->set_flashdata('error', 'Oops! Error.  Invoice mail not Send!');
                   // $this->load->view('admin/invoice-detail', $data);
                   redirect(base_url('admin/payment/invoice/'.$id));
                }
        
        
    }
        
      }
    
    
    
    
    
    

}