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

                    <?php endif;?>

                      <?php if($this->session->flashdata('error')): ?>

                        <div class="alert alert-danger" style="color: grey">

                          <?php echo $this->session->flashdata('error');?>

                        </div>

                    <?php endif; 
// print_r($details);
                    ?>

                     <div class="card">

                        <div class="row">

                           <div class="card-content pb-2">

                              <div class="col s12">

                                 <h4 class="admin-heading"><?= (!empty($details) ? 'Edit':'Add') ?> Package</h4> <span>With <small style="color: red">*</small> are required field</span>

                                    <?php echo form_open(base_url('admin/packages/save/'.(!empty($details) ? $details->id:'')),'id="add_edit_form"'); ?>

                                    <div class="row">

                                       <div class="input-field col s12 m6">

                                          <label for="">Package Name</label> <small style="color: red">*</small> 

                                          <input type="text" id="title" name="title" placeholder="Enter Package Name..." value="<?= (!empty($details) ? $details->title:'') ?>" />  
                                       </div>

                                       
                                       
                                        <div class="input-field col s12 m6"> 
                                          <label for="">Package Duration</label><small style="color: red">*</small> 
                                          <select class="form-control" name="package_type" id="package__type">
                                            <option value="">Select package duration</option>
                                            <option value="1"<?= ($details->package_type=='1' ? 'selected':'') ?>>Monthly</option>
                                            <option value="2" <?= ($details->package_type=='2' ? 'selected':'') ?>>Yearly</option>
                                          </select> 

                                        </div>
                                         <div class="input-field col s12 m6"> 
                                          <label for="">Package Validity(In Days)</label><small style="color: red">*</small> 
                                          <input type="text" name="valid_for_days" id="valid_for_days" placeholder="Enter Package Validity(In Days).." value="<?= (!empty($details) ? $details->valid_for_days:'') ?>" readonly />   
                                        </div>   
                                        <div id="yearly__price__section" style="display:<?= ($details->package_type=='2' ? 'block !important':'none !important') ?>">
                                          

                                           
                                        </div>
                                        
                                        <div class="input-field col s12 m6">

                                          <label for="">Price(In £)</label><small style="color: red">*</small>

                                          <input type="text" name="regular_price" id="regular_price" placeholder="Enter Regular price..." value="<?= (!empty($details) ? $details->regular_price:'') ?>"/>                                                                       

                                       </div>

                                       
                                         <div class="input-field col s12 m6">

                                          <label for="">Number of Customer Allowed</label> <small style="color: red">*</small> 

                                          <input type="text" id="max_user" name="max_user" placeholder="Number of Customer Allowed..." value="<?= (!empty($details) ? $details->max_user:'') ?>" />  
                                       </div>
                                       
                                        
                                       <div class="input-field col s12 m6">

                                          <label for="">Number of Van Allowed</label> <small style="color: red">*</small> 

                                          <input type="text" id="allow_van" name="allow_van" placeholder="Number of Van Allowed..." value="<?= (!empty($details) ? $details->allow_van:'') ?>" />  
                                       </div>



                                         
                                          
                        <div class="input-field col s12 m12"> 
                                            <label for="">Packages Features:</label> <small style="color: red">*</small>
                                          </div>                  
                                           <div class="input-field col s12 m12 switch mb-1">
                                               <div class="input-field col s12 m4">
              <label>
                
                <input checked type="checkbox" name="option_1" value="1" required>
                <span class="lever"></span>
                Customer CRM
              </label>
              </div>
              <div class="input-field col s12 m4">
              <label>
                
                <input  checked type="checkbox" name="option_2" value="1" required>
                <span class="lever"></span>
                Bookings
              </label>
              </div>
              <div class="input-field col s12 m4">
              <label>
                
                <input checked type="checkbox" name="option_3" value="1" required>
                <span class="lever"></span>
                Driver Database
              </label>
              </div>
              <div class="input-field col s12 m4">
              <label>
                
                <input checked type="checkbox" name="option_4" value="1" required>
                <span class="lever"></span>
                Fleet Management
              </label>
              </div>
              <div class="input-field col s12 m4">
              <label>
                
                <input  type="checkbox" name="option_5" value="1">
                <span class="lever"></span>
                Invoicing & Billing
              </label>
              </div>
              <div class="input-field col s12 m4">
              <label>
                
                <input  type="checkbox" name="option_6" value="1">
                <span class="lever"></span>
                Bill of Laden
              </label>
              </div>
              <div class="input-field col s12 m4">
              <label>
                
                <input  type="checkbox" name="option_7" value="1">
                <span class="lever"></span>
                Fleet Tracking
              </label>
              </div>
              <div class="input-field col s12 m4">
              <label>
                
                <input  type="checkbox" name="option_8" value="1">
                <span class="lever"></span>
                Customer Goods Tracking
              </label>
              </div>
              <div class="input-field col s12 m4">
              <label>
                
                <input  type="checkbox" name="option_9" value="1">
                <span class="lever"></span>
                Bluetooth Printer
              </label>
              </div>
              <div class="input-field col s12 m4" >
              <label>
                
                <input  type="checkbox" name="option_10" value="1">
                <span class="lever"></span>
                File Manager
              </label>
              </div>
              <div class="input-field col s12 m4" >
              <label>
                
                <input  type="checkbox" name="option_11" value="1">
                <span class="lever"></span>
                Accounts
              </label>
              </div>
              <div class="input-field col s12 m4" >
              <label>
                
                <input  type="checkbox" name="option_12" value="1">
                <span class="lever"></span>
                Reporting
              </label>
              </div>
              <div class="input-field col s12 m4" >
              <label>
                
                <input checked type="checkbox" name="option_13" value="1" required>
                <span class="lever"></span>
                SMS Counting
              </label>
              </div>
            </div>
                       <div class="input-field col s12 m12"> 
                                            <label for="">Long Description</label> <small style="color: red">*</small>
                                            <textarea style="height: 100px;" id="long_description" name="long_description" placeholder="Description..."><?= (!empty($details) ? $details->long_description:'') ?></textarea> 
                                          </div>                     
                                        
                                    </div>
                                    
                                    

                                    <div class="form-submit pb-4 pt-2">

                                       <button class="btn">Save</button>

                                       <a href="<?= base_url('admin/packages') ?>" class="btn">Cancel</a>

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

   <script type="text/javascript">

       $(document).ready(function() { 
        $('#package__type').prop('required',true);

         $("input[type=text], textarea, select").attr("required", true);

           $('input[required]').css("border-color", "red");

           $('input[required="true"]').css("border-color", "red");

           $('input[required="required"]').css("border-color", "red"); 

           // Desimal Number Allowed start

           $(function () {
              $('#regular_price,#offer_price,#max_user,#valid_for_days').on('input', function(e) {
                  if (/^(\d+(\.\d{0,2})?)?$/.test($(this).val())) {
                      // Input is OK. Remember this value
                      $(this).data('prevValue', $(this).val());
                  } else {
                      // Input is not OK. Restore previous value
                      $(this).val($(this).data('prevValue') || '');
                  }
              }).trigger('input'); // Initialise the `prevValue` data properties
          });
            // Desimal Number Allowed End
          $(document).on('change','#package__type',function(){
            var pt = $(this).val(); 
            if (pt=='') {
              $('#package__type').after('<div id="error" style="color:red">This is required</div>');
            }else if (pt=='1') {
              $('#error').remove();
              $('#valid_for_days').val('30');
              $('#yearly__price__section').hide();
            }else if (pt=='2') {
              $('#error').remove();
              $('#valid_for_days').val('365');
              $('#yearly__price__section').show();
            }
          }) ;
       });
 
      var pt = $('#package__type').val();  
      if (pt=='1') {
        $('#yearly__price__section').remove(); 
      } 

   </script>


   <?php include 'footer.php'; ?>