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
                    <?php endif;?>
                     <div class="card">
                        <div class="row">
                           <div class="card-content pb-2">
                              <div class="col s12">
                                 <h4 class="admin-heading">Add Company</h4> 
                                    <?php echo form_open_multipart(base_url('admin/companies/save'),'id="add_edit_form"'); ?>
                                    <div class="row">
                                       <div class="input-field col s12 m6">
                                          <label for="">Name</label>
                                          <input type="text" id="name" name="name" placeholder="Enter name..." required />                                                                       
                                       </div> 
                                       <div class="input-field col s12 m6">
                                          <label for="">Logo</label>
                                          <input type="file" name="logo_image" id="logo_image" title="select company logo" />      
                                       </div> 
                                        <div class="input-field col s12 ">
                                          <label for="">Description</label>
                                          <textarea style="height: 100px;" id="description" name="description" placeholder="Description..."></textarea> 
                                       </div> 
                                    </div>
                                    <div class="form-submit pb-4 pt-2">
                                       <button class="btn">Save</button>
                                       <a href="<?= base_url('admin/companies') ?>" class="btn">Cancel</a>
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