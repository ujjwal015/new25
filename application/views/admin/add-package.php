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
                                          <label for="">Max. User</label> <small style="color: red">*</small>
                                           <input type="text" name="max_user" id="max_user" placeholder="Enter User Limit..." value="<?= (!empty($details) ? $details->max_user:'') ?>"/>                       

                                       </div>

                                       <div class="input-field col s12 m6">

                                          <label for="">Price(In $)</label><small style="color: red">*</small>

                                          <input type="text" name="regular_price" id="regular_price" placeholder="Enter Regular price..." value="<?= (!empty($details) ? $details->regular_price:'') ?>"/>                                                                       

                                       </div>

                                       <div class="input-field col s12 m6"> 
                                          <label for="">Price(In रु)</label><small style="color: red">*</small> 
                                          <input type="text" name="offer_price" id="offer_price" placeholder="Enter offer price..." value="<?= (!empty($details) ? $details->offer_price:'') ?>"/>   
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
                                          <div class="input-field col s12 m6"> 
                                          <label for="">Price Yearly(In $)</label><small style="color: red">*</small> 
                                          <input type="text" name="regular_price_yearly" id="regular_price_yearly" placeholder="Enter Regular price Yearly..." value="<?= (!empty($details) ? $details->regular_price_yearly:'') ?>"/> 
                                         </div>

                                           <div class="input-field col s12 m6"> 
                                              <label for="">Price Yearly(In रु)</label><small style="color: red">*</small> 
                                              <input type="text" name="offer_price_yearly" id="offer_price_yearly" placeholder="Enter offer price Yearly..." value="<?= (!empty($details) ? $details->offer_price_yearly:'') ?>"/>   
                                           </div>
                                        </div>
                                         <div class="input-field col s12 m6"> 
                                            <label for="">Short Description</label> <small style="color: red">*</small>
                                            <textarea  style="height: 100px;" id="short_description" name="short_description" placeholder="Short Description..."><?= (!empty($details) ? $details->short_description:'') ?></textarea> 
                                         </div>



                                          <div class="input-field col s12 m6"> 
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

         $("input, textarea, select").attr("required", true);

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