<?php include 'head.php' ?>
<!-- END: Head-->
<body
   class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 2-columns   "
   data-open="click" data-menu="vertical-dark-menu" data-col="2-columns">
   <!-- BEGIN: Header-->
   <?php  include 'header.php' ?>
   <!-- END: Header-->
   <!-- BEGIN: SideNav-->
   <?php include 'sidebar.php'; ?>
   <!-- END: SideNav-->
   <!-- BEGIN: Page Main-->  
   <!-- BEGIN: Page Main-->
   <div id="main">
   <div class="row">
      <div class="col s12">
         <div class="container">
            <div class="section section-data-tables">
               <!-- Page Length Options -->
               <div class="row">
                  <div class="col s12">
                     <?php if($this->session->flashdata('message')): ?>
                       <div class="alert alert-success" style="color: grey">
                         <?php echo $this->session->flashdata('message');?>
                       </div>
                       <?php endif; 
                        if($this->session->flashdata('error')): ?>
                           <div class="alert alert-danger" style="color: grey">
                             <?php echo $this->session->flashdata('error');?>
                           </div>
                       <?php endif;
                       $record = json_decode($record->smtp_details);
                       // echo "<pre>";
                       // print_r($record);die();

                       ?>
                     <div class="card">
                        <div class="row">
                           <div class="card-content pb-2">
                              <div class="col s12">
                                  <!--<h4 class="admin-heading">Twilio Setting</h4>-->
                                   
                                 <?= form_open_multipart(admin_url('setting/save')) ?>
                                 <h4 class="admin-heading">Click Send SMS Gateway Setting</h4>
                                    <div class="row">
                                     
                                       
                                       
                                       <div class="input-field col s12 m6">
                                          <label for="">Username</label>
                                          <input type="text" name="clicksend_username" id="clicksend_username" placeholder="Enter Click Send Username...." value="<?= $record->clicksend_username ?? '1' ?>" required />                                                                       
                                       </div>
                                        
                                       <div class="input-field col s12 m6">
                                          <label for="">Sender ID</label>
                                          <input type="text" name="clicksend_senderid" id="clicksend_senderid" placeholder="Enter Click Send Sender Id...." value="<?= $record->clicksend_senderid ?? '1' ?>" required />                                                                       
                                       </div>
                                       <div class="input-field col s12 m12">
                                          <label for="">Key</label>
                                          <input type="text" name="clicksend_key" id="clicksend_key" placeholder="Enter Click Send Key...." value="<?= $record->clicksend_key ?? '1' ?>" required />                                                                       
                                       </div>
                                       
                                       
                                       
                                       </div>
                                       
                                       <hr/>
                                       <h4 class="admin-heading">SMTP Setting</h4>
                                        <div class="row">
                                      <div class="input-field col s12 m6">
                                          <label for="">Email Encryption</label>
                                          <select class="form-group" name="smtp_encryption" required>
                                             <option <?= ($record->smtp_encryption =='ssl' ? 'selected':'') ?> value="ssl">SSL</option>
                                             <option <?= ($record->smtp_encryption =='tls' ? 'selected':'') ?> value="tls">TLS</option>
                                          </select>                        
                                       </div>
                                       <div class="input-field col s12 m6">
                                          <label for="">SMTP Protocol</label>
                                          <input type="text" name="smtp_protocol" id="smtp_protocol" placeholder="Enter SMTP Protocol...." value="<?= $record->smtp_protocol ?? 'smtp' ?>" required />                                                                       
                                       </div>
                                       <div class="input-field col s12 m6">
                                          <label for="">SMTP Host</label>
                                          <input type="text" name="smtp_host" id="smtp_host" placeholder="Enter SMTP Host...." value="<?= $record->smtp_host ?? '' ?>" required />                                                                       
                                       </div>
                                       <div class="input-field col s12 m6">
                                          <label for="">SMTP Port</label>
                                          <input type="text" name="smtp_port" id="smtp_port" placeholder="Enter SMTP Port...." value="<?= $record->smtp_port ?? '' ?>" required />                        
                                       </div>
                                       <div class="input-field col s12 m6">
                                          <label for="">Email</label>
                                          <input type="email" name="smtp_email" id="smtp_email" placeholder="Enter email...." value="<?= $record->smtp_email ?? '' ?>" required />                                                                       
                                       </div>
                                       <div class="input-field col s12 m6">
                                          <label for="">SMTP Password</label>
                                          <input type="text" name="smtp_password" id="smtp_password" placeholder="Enter SMTP Password...." value="<?= $record->smtp_password ?? '' ?>" required />                        
                                       </div>
                                       <div class="input-field col s12 m6">
                                          <label for="">Logo</label>
                                          <input type="file" name="logo_image" id="logo_image" title="Select logo"  />                        
                                       </div>
                                        <?php $logoImage = check_row('tbl_setting',array('id'=>1)) ;
                                          if (!empty($logoImage) && !empty($logoImage->logo_image)) { ?>
                                            <h5>Current Logo</h5>
                                               <img src="<?= base_url($logoImage->image_path.'/'.$logoImage->logo_image) ?>" height="70" width="100"> 
                                          <?php } ?>
                                       <!-- <div class="input-field col s12 m6">
                                          <label for="">Email ID</label>
                                          <input type="text" />                        
                                       </div>

                                       <div class="input-field col s12 m6">
                                          <label for="">Phone</label>
                                          <input type="text" />                        
                                       </div> -->
                                    </div>
                                    <div class="form-submit pb-4 pt-2">
                                       <button class="btn">Save</button>
                                       <button class="btn">Cancel</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- END: Page Main-->
   <!-- END: Page Main-->
   <!-- BEGIN: Footer-->
   <?php include 'footer.php'; ?>