<?php $this->load->view('head.php'); ?>
<?php// include('includes/header.php'); ?>
<style>
   .mp-home{margin-top: 0;}
</style>
<main id="main">
   <div class="container">
      <div class="posRel">
         <div class="signBg">
            <div class="d-flex justify-content aligns-center">
               <div class="leftW">
                  <h1><u>Lorem</u> ispum</h1>
                  <p>Lorem Ipsum is simply dummy text of the printing<br/> and typesetting industry. Lorem Ipsum has<br/> been the industry's standard dummy text ever<br/> since the 1500s, when an unknown printer. </p>
               </div>
               <div class="rightW">
                  <div class="login-form">
                    <?php if($this->session->flashdata('message')): ?>
                <div class="alert alert-success" style="color: grey">
                  <?php echo $this->session->flashdata('message');?>
                </div>
              <?php endif;?>
                <?php if($this->session->flashdata('error')): ?>
                  <div class="alert alert-danger" style="color: grey">
                    <?php echo $this->session->flashdata('error');?>
                  </div>
              <?php endif;?>
              <?php
              $emailVal='';
              $loginURL =base_url('login/login_auth'); 
              if (!empty($_GET['token'])) {
                $emailVal = base64_decode(urldecode($_GET['token']));
                $dataCheck = array(
                   'email' => $emailVal, 
                 );
                $check = $this->common_model->auth_check_email($dataCheck);

                if($check == FALSE) {
                    $this->session->set_flashdata('error','Email is not exists');
                    redirect(base_url('login'));
                    // redirect_subdomain('','login');
                }
                $loginURL=base_url('login/login_check'); 
                ?>


                  
                <?php  }  ?> 



                        <form action="<?= $loginURL; ?>" method="post">
                           <div class="avatar"><i class="far fa-user"></i></div>

<?php
if (!empty($_GET['token'])) {
?>
<p style="color: black;">Login as <span style="color: blue;"><?= $emailVal ?></span> <a href="<?= base_url('login') ?>">Not you? Change</a></p>
<?php }
?>



                           <div class="form-group">
                              <label>Email Address</label>
                              <div class="inpsection">
                                 <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email address" required value="<?= $emailVal ?>">
                  <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                                 <i class="far fa-user pos-abs"></i>
                              </div>
                           </div>
                           <div class="form-group" <?= (!empty($_GET['token']) ? 'password' : 'style="display:none;"') ?>>
                  <label >Password</label>
                  <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" <?= (!empty($_GET['token']) ? 'required' : '') ?>>
                  <?php echo form_error('password', '<div class="error">', '</div>'); ?> 
                </div>




                <button type="submit" class="btn btn-primary btn-block btn-lg" value="Login">Next<i class="fa fa-arrow-right"></i></button>
                               
                           <div class="text-center small">Don't have an account? <a style="color:red!important;" href="forgot-password">Forgot password</a></div>
                     
                     <div class="sign2 text-center">
                     <p style="margin-top:10px"><b><a href="<?= base_url('register') ?>">Sign up</a></b></p>
                     <p>or</p>
                     <a href="register/users">Register as learner,parent,student</a>
                     </div>            
                     </form>  
                 </div> 
               </div>
            </div>
         </div>
      </div>
   </div>
</main>




