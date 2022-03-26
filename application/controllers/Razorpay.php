<?php  
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Razorpay extends CI_Controller {
    // construct
  
  public function __construct() {
      parent::__construct();        
      $this->load->helper('form');
      $this->load->library('form_validation'); 
  }

  private function sendWelcomeEmail($smatpDetails='',array $userDetails)
  {
    $this->load->library('email'); 
    //SMTP & mail configuration
    if (empty($smatpDetails)) {
      $smatpDetails = $this->db->get('tbl_setting')->row();
    } 
    $details =json_decode($smatpDetails->smtp_details);
    // $config = array(
    //     'protocol'  => $details->smtp_protocol,
    //     'smtp_host' => $details->smtp_encryption.'://'.$details->smtp_host,
    //     'smtp_port' => $details->smtp_port,
    //     'smtp_user' => $details->smtp_email,
    //     'smtp_pass' => $details->smtp_password,
    //     'mailtype'  => 'html',
    //     'charset'   => 'utf-8'
    // );
    // $this->email->initialize($config);
    $this->email->set_mailtype("html");
    $this->email->set_newline("\r\n");
   
    //Email content
    // $htmlContent = '<h1>Sending email via SMTP server</h1>';
    $name = $userDetails['name'] ?? "";
    $crmLink = $userDetails['subdomain'] ?? "";
    $htmlContent .= '<table style="background-color: #ffffff; width: 540px; margin: 0 auto; padding: 40px;">
    
                  <tr> <td style="text-align: center; font-size: 30px; font-weight: 600;     line-height: 40px; font-family: rubik !important;" >TeamifyMe</td> </tr>   
                  <tr> 
                  <td style="font-size: 20px; color: #333333; margin-bottom: 10px; font-family: rubik !important;">Hello, '.$name.'</td> 
                  </tr>
                  <tr> <td style="font-family: rubik !important; margin-bottom: 30px;">Welcome to TeamifyMe CRM! We are so happy you are here.</td> </tr>
                  <tr> 
                    <td style="font-family: rubik !important;  line-height: 40px;">Login in your account by clicking the link below
                    </td> 
                  </tr>
                  <tr> 
                    <td style="text-align: center;  line-height: 40px;">
                    <a href="'.$crmLink.'" style="font-family: rubik !important; margin: 20px auto; border-radius: 4px; text-decoration: none; text-transform: uppercase; padding: 10px 20px 10px 20px; background-color: #ff6f00; color: #fff;">Login in your account</a>
                    </td> 
                  </tr>

                  <tr> 
                    <td style="font-family: rubik !important; line-height: 40px;">Questions about CRM?</td> 
                  </tr>
                  <tr> 
                    <td style="font-family: rubik !important; line-height: 20px;">We will be in touch with you, but should you need to reach our team sooner, feel free to contact us at: <a href="mailto:support@teamifyme.com" style="text-decoration: none; font-weight: 500; color: #ff6f00;">support@teamifyme.com</a>
                    </td>
                  </tr>
                  <tr>
                    <td style="font-family: rubik !important; line-height: 40px;">We are happy to help!</td>
                  </tr>
                  <tr>
                    <td style="font-family: rubik !important; line-height: 50px;">Cheers</td>
                  </tr>
                  <tr>
                    <td style="font-size: 20px; font-weight: 600; font-family: rubik !important;">TeamifyMe CRM Team</td>
                  </tr>
                </table>';

    // $this->email->to('dheerendra@younggeeks.in');
    // $this->email->from($details->smtp_email,'Welcome Email');
    // $this->email->subject('How to send email via SMTP server in CodeIgniter');
    // $this->email->message($htmlContent); 
    $this->email->from('noreply@teamifyme.com', 'TeamifyMe'); 
    $this->email->to($userDetails['email'] ?? 'dheerendra@younggeeks.in');
    $this->email->subject('Welcome Email'); 
    $this->email->message($htmlContent); 
    //Send email
    if ($this->email->send()) {
      // echo "email sent";
      // echo $this->email->print_debugger();die();
    }
    
  }
    // index page
    public function index() { 
        $data['title'] = 'Razorpay | Payment';  
        // $emailData['name']      = 'Dheerendra Yadav';
        // $emailData['subdomain'] = 'http://crm.ygcrm.xyz/admin/authentication/';
        // $emailData['email']     = 'dheerendra@younggeeks.in';
        // $this->sendWelcomeEmail('',$emailData);           
        $this->load->view('razorpay/index', $data);
    }
    
    // checkout page
    public function checkout($id='') {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric|min_length[10]|max_length[15]');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_message('required', ' %s field is required');

        if ($this->form_validation->run() === FALSE) {  
            $this->session->set_flashdata('error',validation_errors());
           redirect($_SERVER['HTTP_REFERER']);
        }
        $setData=$this->input->post();
        $id=base64_decode(urldecode($setData['package__ID']));
        // die($id);
        $resRow = $this->db->where('id',$id)->get('tbl_packages')->row();
        if (empty($setData['package__ID']) || empty($resRow)) {
           $this->session->set_flashdata('error','OPPS! There was an error');
           redirect($_SERVER['HTTP_REFERER']);
        }
        $data['title'] = 'Checkout payment | Payment';   
        $data['item'] = $resRow;   
        $data['userDetails'] = $setData;   
        $data['return_url'] = base_url().'razorpay/callback';
        $data['surl'] = base_url().'razorpay/success';;
        $data['furl'] = base_url().'razorpay/failed';;
        $data['currency_code'] = RAZOR_CURENCY_CODE;
        $this->load->view('razorpay/checkout', $data);
    }

    // initialized cURL Request
    private function get_curl_handle($payment_id, $amount)  {
        $url = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
        $key_id = RAZOR_KEY_ID;
        $key_secret = RAZOR_KEY_SECRET;
        $fields_string = "amount=$amount";
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/ca-bundle.crt');
        return $ch;
    }   
        
    // callback method
    public function callback() {        
        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {
            $razorpay_payment_id = $this->input->post('razorpay_payment_id');
            $merchant_order_id = $this->input->post('merchant_order_id');
            $currency_code = 'INR';
            $amount = $this->input->post('merchant_total');
            $success = false;
            $error = '';
            try {                
                $ch = $this->get_curl_handle($razorpay_payment_id, $amount);
                //execute post
                $result = curl_exec($ch);
                
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($result === false) {
                    $success = false;
                    $error = 'Curl error: '.curl_error($ch); 
                }else{
                  $response_array = json_decode($result, true);
                  // echo "<pre>"; 
                  // print_r($response_array); 
                  // print_r($this->input->post());die();
                  $dataSet = $dataArray['paymentInfo'] = $this->input->post();
                      //Check success response
                  if (!empty($response_array) && !empty($dataSet)) {
                      $success = true;
                      $where['email'] = $dataSet['merchant_email'];
                      $or_where['phone'] = $dataSet['merchant_phone'];
                      $userDataRec = $this->db->where($where)->or_where($or_where)->get("users")->row();
                      // echo $this->db->last_query();die;
                     $userFullName = explode(' ', $dataSet['merchant_fullname']);
                     $pkg = getPackageDetails(array('id'=>$dataSet['merchant_order_id']));
                     $updateDataSet['email']             = $userEmail = $dataSet['merchant_email'];
                     $updateDataSet['phone']             = $dataSet['merchant_phone']; 
                     $updateDataSet['password']          = md5($dataSet['merchant_password']);
                     $updateDataSet['password_original'] = $userPass =  $dataSet['merchant_password'];
                     $updateDataSet['subdomain_name']    = $updateDataSet['username'] =  $dataSet['merchant_username'];
                     $updateDataSet['first_name']        = $userFullName[0] ?? '';
                     $updateDataSet['last_name']         = $userFullName[1] ?? '';
                     $updateDataSet['package_id']        = $pkg->id ?? '1';
                     $updateDataSet['max_user_allowed']  = $pkg->max_user ?? '1';
                     $validDay                           = $pkg->valid_for_days ?? '30';
                     $updateDataSet['role']              = 'seller';

                    // Date & Days Calculation

                    $daysValid = $validDay.' days';
                    $exDate=date_create(date('Y-m-d'));
                    date_add($exDate,date_interval_create_from_date_string($daysValid));
                    $dateValid = date_format($exDate,"Y-m-d"); 
                    $updateDataSet['expire_date']  = $dateValid;
                    $updateDataSet['expire_days']  = $daysValid;
                      
                    // Date & Days Calculation

                    $paymentSet['payment_id']       = $dataSet['razorpay_payment_id'];
                    $paymentSet['package_id']       = $pkg->id;
                    $paymentSet['max_user_allowed'] = $pkg->max_user;
                    $paymentSet['total_amount']     = $dataSet['merchant_amount'];
                    $userEmail = urlencode(base64_encode($userEmail));
                    $userPass  = urlencode(base64_encode($userPass));
                    $param     = "?p=$userPass&token=$userEmail";
                    $addCount  = checkSubdomain('users',array('username'=>$dataSet['merchant_username']));
                      if (!$userDataRec) { 
                         $res = $this->common_model->insert_data('users',$updateDataSet);
                         $paymentSet['user_id'] = $res;
                         $user['id'] =$res;

                         $updateData['subdomain_name'] = $updateDataSet['subdomain_name'] = $userSubdomain = $dataSet['merchant_username'].$addCount;
                         $update = $this->common_model->updateItem($updateData,$user,'users');
                         $res = $this->common_model->insert_data('tbl_payment_history',$paymentSet);
                         
                         createUserDb($userSubdomain,$updateDataSet);
                         $sendEmail = check_row('tbl_setting',array('id'=>1));
                         if (!empty($sendEmail)) {
                          $emailData['name']      = $dataSet['merchant_fullname'];
                          $emailData['subdomain'] = 'http://'.$userSubdomain.'.ygcrm.xyz/admin/authentication/';
                          $emailData['email']     = $userEmail;
                           $this->sendWelcomeEmail($sendEmail,$emailData);
                         }
                         
                         redirect('http://'.$userSubdomain.'.ygcrm.xyz/admin/authentication/'.$param);
                         subdomain_url($updateDataSet['username'],$param);
                         
                      }else{ 
                        if (empty($userDataRec->subdomain_name)) { 
                          $insertDataSet['password']          = md5($dataSet['merchant_password']);
                          $insertDataSet['password_original'] = $dataSet['merchant_password'];
                          $insertDataSet['subdomain_name']    = $userSubdomain = $dataSet['username'] ;
                          $insertDataSet['first_name']        = $userFullName[0] ?? '';
                          $insertDataSet['last_name']         = $userFullName[1] ?? '';
                          $insertDataSet['package_id']        = $pkg->id ?? '1';
                          $insertDataSet['max_user_allowed']  = $pkg->max_user ?? '1';

                          // Save Payment userDetails
                          $paymentSet['payment_id']       = $dataSet['razorpay_payment_id'];
                          $paymentSet['package_id']       = $pkg->id;
                          $paymentSet['max_user_allowed'] = $pkg->max_user;
                          $paymentSet['total_amount']     = $dataSet['merchant_amount'];
                          $paymentSet['user_id']          = $userDataRec->id;

                            $this->db->where($where)->update("users",$insertDataSet);
                            $res = $this->common_model->insert_data('tbl_payment_history',$paymentSet);
                            createUserDb($userSubdomain,$updateDataSet);
                            redirect('http://'.$updateDataSet['username'].'.ygcrm.xyz/admin/authentication/'.$param);
                            subdomain_url($updateDataSet['username'],$param);
                            redirect('http://'.$updateDataSet['username'].'.ygcrm.xyz/admin/');
                            // redirect('http://'.$updateDataSet['username'].'.ygcrm.xyz/admin/');
                        }else{ 
                          $updateData['password'] = md5($dataSet['merchant_password']);
                          $updateData['password_original'] =  $dataSet['merchant_password']; 
                          $updateData['first_name'] = $userFullName[0] ?? '';
                          $updateData['last_name'] =  $userFullName[1] ?? '';
                          $updateData['package_id'] = $pkg->id ?? '1';
                          $updateData['max_user_allowed'] =   $pkg->max_user ?? '1'; 
                          $updateData['expire_date']  = $dateValid;
                          $updateData['expire_days']  = $daysValid;

                          $paymentSet['payment_id'] =$dataSet['razorpay_payment_id'];
                          $paymentSet['package_id'] =$pkg->id;
                          $paymentSet['max_user_allowed'] =$pkg->max_user;
                          $paymentSet['total_amount'] =$dataSet['merchant_amount'];
                          $paymentSet['user_id'] =$userDataRec->id; 
                          $userSubdomain = $userDataRec->subdomain_name;
                          $payment = $this->common_model->insert_data('tbl_payment_history',$paymentSet);
                          $this->db->where($where)->update("users",$updateData); 
                          updateCrmUser($userSubdomain,$updateData);
                          redirect('http://'.$userSubdomain.'.ygcrm.xyz/admin/authentication/'.$param);
                        }
                      }
                      
                  } else {
                      $success = false; 
                      $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result; 
                  }
                }
                //close connection
                curl_close($ch);
            } catch (Exception $e) { 
                $success = false;
                $error = 'OPENCART_ERROR:Request to Razorpay Failed';
            }
            if ($success === true) {
                if(!empty($this->session->userdata('ci_subscription_keys'))) {
                    $this->session->unset_userdata('ci_subscription_keys');
                 }
                if (!$dataSet['razorpay_payment_id']) {
                    redirect($this->input->post('merchant_surl_id'),$dataArray);
                } else {
                    redirect($this->input->post('merchant_surl_id'),$dataArray);
                }

            } else {
                redirect($this->input->post('merchant_furl_id'));
            }
        } else {
            echo 'An error occured. Contact site administrator, please!';
        }
    } 
    public function success() {
        $data['title'] = 'Razorpay Success | Payment';  
        $this->load->view('razorpay/success', $data);
    }  
    public function failed() {
        
        $data['title'] = 'Razorpay Failed | Payment';            
        $this->load->view('razorpay/failed', $data);
    } 
}
?>