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
                       <?php endif;?>
                     <div class="card">
                        <div class="row">
                           <div class="card-content pb-2">
                              <div class="col s12">
                               
                                 <?= form_open_multipart(admin_url('payment/save')) ?>
                                   
                                    <h4 class="admin-heading">Paypal Payment Gateway</h4>
                                    <div class="row">
                                       <div class="input-field col s12 m6">
                                          <label for="">Business Email</label>
                                          <input type="text" name="business_email" id="business_email" placeholder="Enter Business Email...." value="<?= $record->business_email ?? '' ?>" required />                                                                       
                                       </div>
                                       <div class="input-field col s12 m6">
                                          <label for="">Live Key</label>
                                          <input type="text" name="paypal_live" id="paypal_live" placeholder="Enter Live key...." value="<?= $record->paypal_live ?? '' ?>" required />                        
                                       </div>
                                       <div class="input-field col s12 m6">
                                          <label for="">Test Key</label>
                                          <input type="text" name="test_key" id="test_key" placeholder="Enter Test key...." value="<?= $record->test_key ?? '' ?>" required />                        
                                       </div>
                                       <div class="input-field col s12 m6">
                                          <label for="">Currency Code</label>
                                          <input type="text" name="paypal_currency" id="paypal_currency" placeholder="Enter Currency Code USD/GBP...."  value="<?= $record->paypal_currency ?? '' ?>" >
                                        <!--   <select class="form-group" name="stripe_currency" id="stripe_currency" required>
                                             <option <?= ($record->currency_code =='INR' ? 'selected':'') ?> value="INR">INR</option>
                                             <option <?= ($record->currency_code =='USD' ? 'selected':'') ?> value="USD">USD</option>
                                          </select>   -->                      
                                       </div> 
                                       <div class="input-field col s12 m6">
                                          <label for="">Payment Mode</label>
                                         
                                       <select class="form-group" name="paypal_mode" id="paypal_mode" required>
                                           <option value="">Select</option>
                                             <option <?= ($record->paypal_mode =='FALSE' ? 'selected':'') ?> value="FALSE">LIVE</option>
                                             <option <?= ($record->paypal_mode =='TRUE' ? 'selected':'') ?> value="TRUE">TEST</option>
                                          </select>               
                                       </div> 
                                    </div>
                                    <hr>
                                    <h4 class="admin-heading">Bank Transfer</h4>
                                    <div class="row">
                                       <div class="input-field col s12 m6">
                                          <label for="">Bank Name</label>
                                          <input type="text" name="bank_name" id="bank_name" placeholder="Enter Bank Name...." value="<?= $record->bank_name ?? '' ?>" required />                                                                       
                                       </div>
                                       <div class="input-field col s12 m6">
                                          <label for="">Branch Name</label>
                                          <input type="text" name="branch_name" id="branch_name" placeholder="Enter Branch Name...." value="<?= $record->branch_name ?? '' ?>" required />                                                                       
                                       </div>
                                       <div class="input-field col s12 m6">
                                          <label for="">Account Number</label>
                                          <input type="text" name="account_number" id="account_number" placeholder="Enter Account Number...." value="<?= $record->account_number ?? '' ?>" required />                                                                       
                                       </div>
                                       <div class="input-field col s12 m6">
                                          <label for="">Swift/IFSC code</label>
                                          <input type="text" name="ifsc_code" id="ifsc_code" placeholder="Enter Swift/Ifsc code...." value="<?= $record->ifsc_code ?? '' ?>" required />                                                                       
                                       </div>
                                       
                                      
                                      
                                    </div>
                                    <hr>
                                    <h4 class="admin-heading">Google Pay Payment Gateway</h4> 
                                    <div class="row">
                                       <div class="input-field col s12 m6">
                                          <label for="">Google UPI ID</label>
                                          <input type="text" name="gclient_key" id="gclient_key" placeholder="Enter client ID...." value="<?= $record->gclient_key ?? '' ?>"  />                                                                       
                                       </div>
                                       <div class="input-field col s12 m6">
                                          <label for="">Google UPI Number</label>
                                          <input type="text" name="gclient_secret" id="gclient_secret" placeholder="Enter client Secret...." value="<?= $record->gclient_secret ?? '' ?>"  />                        
                                       </div>
                                       <div class="input-field col s12 m6">
                                          <label for="">QR Image</label>
                                          <input type="file" name="qr_image" id="logo_image" title="Select QR Image"  />                        
                                       </div>
                                        <?php $logoImage = check_row('tbl_payment_details',array('id'=>1)) ;
                                          if (!empty($logoImage) && !empty($logoImage->qr_image)) { ?>
                                            <h6>Current QR Image</h6>
                                               <img src="<?= base_url($logoImage->image_path.'/'.$logoImage->qr_image) ?>" height="70" width="100"> 
                                          <?php } ?> 
                                    </div>
                                    
                                    
                                    
                                    <div class="form-submit pb-4 pt-2">
                                       <button class="btn">Save</button>
                                       <a href="<?= admin_url() ?>" class="btn">Cancel</a>
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