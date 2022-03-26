<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct(); 
        $this->load->helper('form');
		    $this->load->library('form_validation'); 
        // $this->load->helper('date');
        $this->load->helper('security');
        // $this->load->library('pagination');
        $this->load->helper('captcha');
        // $this->load->library('encrypt');
    }

    public function index() { 
        $data['title'] = "Register ";
       // redirect(base_url('pricing'));
        $this->load->view('register', $data);
        // $this->load->view('footer');
    } 
    
    public function newuser($id) { 
        
        
        if($id==''){
            redirect(base_url('pricing'));
           exit;
            
        }else{
           
       $newid = base64_decode($id);
        
        $data['package_id'] = $newid;
        $data['title'] = "Register ";
        $this->load->view('register', $data);
        // $this->load->view('footer');
        }
    }

  private function sendForgotPasswordEmail(array $userDetails)
  {
    $this->load->library('email'); 
    //SMTP & mail configuration
    if (empty($smatpDetails)) {
      $smatpDetails = $this->db->get('tbl_setting')->row();
    } 
    $details =json_decode($smatpDetails->smtp_details); 
    $this->email->set_mailtype("html");
    $this->email->set_newline("\r\n"); 
    //Email content
    // $htmlContent = '<h1>Sending email via SMTP server</h1>';
    $name = $userDetails['name'] ?? ""; 
    $newPassword = $userDetails['password'] ?? ""; 
    $htmlContent .= '<table style="background-color: #ffffff; width: 540px; margin: 0 auto; padding: 40px;">
    
                  <tr> <td style="text-align: center; font-size: 30px; font-weight: 600;line-height: 40px; font-family: rubik !important;" >Door2Door</td> </tr>   
                  <tr> 
                  <td style="font-size: 20px; color: #333333; margin-bottom: 10px; font-family: rubik !important;">Hello, '.$name.'</td> 
                  </tr>
                  <tr> <td style="font-family: rubik !important; margin-bottom: 30px;"><b>Forgot Password?</b> Do not worry we all forgot sometime !.</td> </tr>
                  <tr> 
                    <td style="font-family: rubik !important;  line-height: 40px;">Login in your account by using new password !
                    </td> 
                  </tr>
                  <tr> 
                    <td style="font-family: rubik !important;  line-height: 40px;"><h3>Your new password is : '.$newPassword.'</h3>   
                    </td> 
                  </tr>
                  <tr> 
                    <td style="text-align: center;  line-height: 40px;">
                    <a href="'.base_url('login').'" style="font-family: rubik !important; margin: 20px auto; border-radius: 4px; text-decoration: none; text-transform: uppercase; padding: 10px 20px 10px 20px; background-color: #ff6f00; color: #fff;">Login in your account</a>
                    </td> 
                  </tr>

                  <tr> 
                    <td style="font-family: rubik !important; line-height: 40px;">Questions about CRM?</td> 
                  </tr>
                  <tr> 
                    <td style="font-family: rubik !important; line-height: 20px;">We will be in touch with you, but should you need to reach our team sooner, feel free to contact us at: <a href="mailto:support@smartschool.one" style="text-decoration: none; font-weight: 500; color: #ff6f00;">support@smartschool.one</a>
                    </td>
                  </tr>
                  <tr>
                    <td style="font-family: rubik !important; line-height: 40px;">We are happy to help!</td>
                  </tr>
                  <tr>
                    <td style="font-family: rubik !important; line-height: 50px;">Cheers</td>
                  </tr>
                  <tr>
                    <td style="font-size: 20px; font-weight: 600; font-family: rubik !important;">Door2Door CRM Team</td>
                  </tr>
                </table>'; 
    $this->email->from('noreply@smartschool.one', 'Door2Door Software'); 
    $this->email->to($userDetails['email'] ?? 'support@smartschool.one');
    $this->email->subject('Forgot Password'); 
    $this->email->message($htmlContent); 
    //Send email
    if ($this->email->send()) {
      // echo "email sent";
      // echo $this->email->print_debugger();die();
    }
    
  }
  
  
    public function forgot_password() { 
      if (!empty($this->input->post()) && !empty($this->input->post('email'))) {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email'); 
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_message('required', ' %s field is required');

        if ($this->form_validation->run() === FALSE) {  
            $this->session->set_flashdata('error',validation_errors());
           redirect($_SERVER['HTTP_REFERER']);
        } else {   
            $data = array(
               'email' => $this->input->post('email'),  
             );

            $check = $this->db->where(array('email'=>$this->input->post('email')))->get('users')->row();
           
           if(empty($check)) {
               $this->session->set_flashdata('error',"OPPS! Seems Email does not exist !");  
            }else{
              if ($check->role=='admin') {
                $mailDetail['password'] = rand(); 
                $mailDetail['name'] = $mailDetail['email'] =$whereData['email'] = $this->input->post('email');
                $updateData['password']= md5($mailDetail['password']); 
                $updateData['password_original']=  $mailDetail['password']; 
                $this->sendForgotPasswordEmail($mailDetail);
                $this->common_model->update_data('users',$updateData,$whereData);
                $this->session->set_flashdata('message','Please check you Email !'); 
              }elseif (!empty($check->subdomain_name)) {
                  // die('sa');
                  
                  $mailDetail['password'] = $check->password_original; 
                $mailDetail['name'] = $mailDetail['email'] =$whereData['email'] = $this->input->post('email');
                $updateData['password']= md5($mailDetail['password']); 
                $updateData['password_original']=  $mailDetail['password']; 
                $this->sendForgotPasswordEmail($mailDetail);
                $this->common_model->update_data('users',$updateData,$whereData);
                $this->session->set_flashdata('message','Password has been send on your mail, Please check !');
                  redirect($_SERVER['HTTP_REFERER']);
                  //redirect('https://'.$check->subdomain_name.'.smartschool.one/auth/forgot_password?token='.urlencode(base64_encode($this->input->post('email'))));
                  // redirect_subdomain($check->subdomain_name,'?token='.urlencode(base64_encode($data['email'])));
              } 
            }
             redirect($_SERVER['HTTP_REFERER']); 
          }
        # code...
      }
        $data['title'] = "Forgot Password ";
        $this->load->view('forgot_password', $data);
        // $this->load->view('footer');
    } 

  private function sendWelcomeEmail($smatpDetails='',array $userDetails)
  {
    $this->load->library('email'); 
    //SMTP & mail configuration
    if (empty($smatpDetails)) {
      $smatpDetails = $this->db->get('tbl_setting')->row();
    } 
    $details =json_decode($smatpDetails->smtp_details); 
    $this->email->set_mailtype("html");
    $this->email->set_newline("\r\n"); 
    //Email content
    // $htmlContent = '<h1>Sending email via SMTP server</h1>';
    $name = $userDetails['name'] ?? "";
    $email = $userDetails['email'] ?? "";
    $password = $userDetails['password'] ?? "";
    $crmLink = $userDetails['subdomain'] ?? "";
    $htmlContent .= '<table style="background-color: #ffffff; width: 540px; margin: 0 auto; padding: 40px;">
    
                  <tr> <td style="text-align: center; font-size: 30px; font-weight: 600; line-height: 40px; font-family: rubik !important;" >Cloud Academy</td> </tr>   
                  <tr> 
                  <td style="font-size: 20px; color: #333333; margin-bottom: 10px; font-family: rubik !important;">Hello, '.$name.'</td> 
                  </tr>
                  <tr><td style="font-size: 16px; color: #333333; margin-bottom: 10px; font-family: rubik !important;">Your Login Url, '.$crmLink.'</td> </tr>
                  <tr> <td style="font-family: rubik !important;  line-height: 40px;"><h3>Your Email is : '.$email.'</h3></tr>
                  
                  <tr><td style="font-family: rubik !important;  line-height: 40px;"><h3>Your Password is : '.$password.'</h3></tr>
                  <tr> <td style="font-family: rubik !important; margin-bottom: 30px;">Welcome to Cloud Academy CRM! We are so happy you are here.</td> </tr>
                  <tr> 
                    <td style="font-family: rubik !important;  line-height: 40px;">Login in your account by clicking the link below</td> 
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
                    <td style="font-family: rubik !important; line-height: 20px;">We will be in touch with you, but should you need to reach our team sooner, feel free to contact us at: <a href="mailto:support@smartschool.one" style="text-decoration: none; font-weight: 500; color: #ff6f00;">support@smartschool.one</a>
                    </td>
                  </tr>
                  <tr>
                    <td style="font-family: rubik !important; line-height: 40px;">We are happy to help!</td>
                  </tr>
                  <tr>
                    <td style="font-family: rubik !important; line-height: 50px;">Cheers</td>
                  </tr>
                  <tr>
                    <td style="font-size: 20px; font-weight: 600; font-family: rubik !important;">Cloud Academy CRM Team</td>
                  </tr>
                </table>'; 
          //   echo $htmlContent;

  
$mail_config['smtp_host'] = 'smtp.gmail.com';
$mail_config['smtp_port'] = '587';
$mail_config['smtp_user'] = 'myschool.oncloud@gmail.com';
$mail_config['_smtp_auth'] = TRUE;
$mail_config['smtp_pass'] = 'abcd1234efgh5678';
$mail_config['smtp_crypto'] = 'tls';
$mail_config['protocol'] = 'smtp';
$mail_config['mailtype'] = 'html';
$mail_config['send_multipart'] = FALSE;
$mail_config['charset'] = 'utf-8';
$mail_config['wordwrap'] = TRUE;
$this->email->initialize($mail_config);

$this->email->set_newline("\r\n");  
  
  
           
            
    $this->email->from('myschool.oncloud@gmail.com', 'CloudAcademy'); 
    $this->email->to($email);
    $this->email->subject('Welcome Email'); 
    $this->email->message($htmlContent); 
    //Send email
    if ($this->email->send()) {
   //   echo "email sent";
     // echo $this->email->print_debugger();die();
    }
    
  }


function get_username_availability() {

  
    if (isset($_POST['username'])) {
      $username = $_POST['username'];

      $query = $this->db->select("*");
            $this->db->from('users');
            $this->db->where('subdomain_name', $username);
            $this->db->limit(1);
            $query=$this->db->get();

    if ($query->num_rows() == 1) {
      echo '<span style="color:red;"> Domain unavailable</span>';
    }else{
      echo '<span style="color:green;"> Domain available</span>';
    }
   
    } else {
      echo '<span style="color:red;"> Domain is required field.</span>';
    }
  }






    public function save($id='') {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
      //  $this->form_validation->set_rules('country_id', 'Country Name', 'required');
        $this->form_validation->set_rules('username',  'The School Name is already taken', 'trim|required|is_unique[users.subdomain_name]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric|min_length[10]|max_length[15]');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_message('required', ' %s field is required');

        if ($this->form_validation->run() === FALSE) {  
            $this->session->set_flashdata('error',validation_errors());
           redirect($_SERVER['HTTP_REFERER']);
        } else {   
            $data = array(
               'email' => $this->input->post('email'),
               'password' => md5($this->input->post('password')), 
             );

            $check = $this->common_model->auth_check_email($data);
            $setData = $this->input->post();
            
            $rand = mt_rand(2000,9000);
            $prefix = "CLA#";
            
            $setData['password_original'] = $setData['password'];
            $setData['password'] = md5($setData['password']);
             $setData['package_id'] = '';
            $setData['role'] = $setData['role'];
            $setData['max_user_allowed'] = '';
            $daysValid = '90 days';
            $exDate=date_create(date('Y-m-d'));
            date_add($exDate,date_interval_create_from_date_string($daysValid));
            $dateValid = date_format($exDate,"Y-m-d");
            
            $setData['expire_date'] = $dateValid;
            $setData['expire_days'] = $daysValid;
            $setData['unique_id'] = $prefix.$rand;
            if($check == FALSE) {

                $ex = explode(' ', $setData['username']);  
                $setData['subdomain_name'] = $setData['ref_domain'] = strtolower($setData['username']);
                $this->session->set_flashdata('message','Your account has been created');
                $addCount  = checkSubdomain('users',array('ref_domain'=>$setData['ref_domain']));
                $res = $this->common_model->insert_data('users',$setData);
                $setData['ref_user_id']= $res;
                $updateData['subdomain_name']= $subdomainName = $setData['subdomain_name'].$addCount;
                 createUserDb($subdomainName,$setData);
                $sendEmail = check_row('tbl_setting',array('id'=>1));
                 if (!empty($sendEmail)) {
                  $emailData['name']      = $setData['first_name'].' '.$setData['last_name'];
                  $emailData['password']      = $setData['password_original'];
                  $emailData['subdomain'] = 'http://'.$subdomainName.'.smartschool.one/site/login/';
                  $emailData['email']     = $setData['email'];
                   $this->sendWelcomeEmail($sendEmail,$emailData);
                 }
                 
                $whereData['id']= $res;
                
                $ress = $this->common_model->update_data('users',$updateData,$whereData);
                $userEmail=urlencode(base64_encode($setData['email']));
                $userPass=urlencode(base64_encode($setData['password_original']));
                //$param = "admin/authentication?p=$userPass&token=$userEmail";
                $param = "site/login?token=".$userEmail;
               // redirect('https://'.$check->subdomain_name.'.smartschool.one/auth/login?token='.urlencode(base64_encode($data['email'])));   
                
                subdomain_url($subdomainName,$param);
                // redirect(base_url('login'));
                // redirect_subdomain('','login');
            }else{
                $this->session->set_flashdata('error',"OPPS! You're already register with us! Login Please !"); 
                redirect($_SERVER['HTTP_REFERER']); 
            }

        }
    }
    
    
    
    public function sndemail(){
        echo "Welcome";
        //exit;
        
        $this->load->library('email');
 //$this->load->library('encrypt');


$mail_config['smtp_host'] = 'smtp.gmail.com';
$mail_config['smtp_port'] = '587';
$mail_config['smtp_user'] = 'myschool.oncloud@gmail.com';
$mail_config['_smtp_auth'] = TRUE;
$mail_config['smtp_pass'] = 'abcd1234efgh5678';
$mail_config['smtp_crypto'] = 'tls';
$mail_config['protocol'] = 'smtp';
$mail_config['mailtype'] = 'html';
$mail_config['send_multipart'] = FALSE;
$mail_config['charset'] = 'utf-8';
$mail_config['wordwrap'] = TRUE;
$this->email->initialize($mail_config);

$this->email->set_newline("\r\n");


//Email content
$htmlContent = '<h1>Sending email via SMTP server</h1>';
$htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';

$this->email->to('sranshulj2002019@gmail.com');
$this->email->from('myschool.oncloud@gmail.com','MyWebsite');
$this->email->subject('How to send email via SMTP server in CodeIgniter');
$this->email->message($htmlContent);
$this->email->set_newline("\r\n");
//Send email
  if (! $this->email->send())
  {
    echo 'Failed';
echo $this->email->print_debugger();
    
  }
  else {
    echo 'Sent';
}

}

}