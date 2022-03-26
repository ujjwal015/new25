<?php include 'head.php' ?>

<!-- END: Head-->

<body

class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 2-columns   "

data-open="click" data-menu="vertical-dark-menu" data-col="2-columns">

<!-- BEGIN: Header-->

<?php  include 'header.php' ?>



<?php include 'sidebar.php'; ?>

<!-- END: SideNav-->

<!-- BEGIN: Page Main-->

<div id="main">

   <div class="row">

      <div class="admin-header user-header">

         <?php $dataRecord =getLoginUser(); ?>

         <div class="col s12">

            <h4 class="admin-heading username-head"><?= $dataRecord->first_name.' '. $dataRecord->last_name ?></h4>

         </div>

      </div>

      <div class="col s12">

         <div class="container">

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

            <div class="section"> 

               <div class="profile-tab-section"> 

                  <div class="card">



                   <form method="post" enctype="multipart/form-data" action="<?= base_url('admin/dashboard/save_profile') ?>" >

                     <div class="card-content">

                        <div class="row">

                           <div class="col s12"> 
                              <div class="input-field col s12"> 
                                 <label for="" class="">First Name</label> 
                                 <p><?= $dataRecord->first_name ?></p> 
                                 <input type="text" name="first_name" value="<?= $dataRecord->first_name ?>" placeholder="First Name.." />

                              </div>

                              <div class="input-field col s12">

                                 <label for="" class="">Last Name</label>

                                 <p><?= $dataRecord->last_name ?></p>

                                 <input type="text" name="last_name" value="<?= $dataRecord->last_name ?>" placeholder="Last name.." />

                              </div>

                              <div class="input-field col s12">

                                 <label for="" class="">Email</label>

                                 <p><?= $dataRecord->email ?></p>

                                 <input type="email" name="email" value="<?= $dataRecord->email ?>" placeholder="Email.." />

                              </div>

                              <div class="input-field col s12">

                                 <label for="" class="">Mobile</label>

                                 <p><?= $dataRecord->phone ?></p>

                                 <input type="text" name="phone" value="<?= $dataRecord->phone ?>" placeholder="Number.." />

                              </div> 

                              <div class="input-field col s12">

                                 <label for="" class="">Password</label>

                                 <p>***********</p>

                                 <input type="password" name="password" value="<?= $dataRecord->password_original ?>" placeholder="Change your password.." />

                              </div>
                              <div class="input-field col s12"> 
                                 <label for="" class="">Full Address</label> 
                                 <p><?= $dataRecord->full_address ?? '-' ?></p> 
                                 <input type="text" name="full_address" id="full_address"  placeholder="Enter your address.." value="<?= $dataRecord->full_address ?? '-' ?>" />
                              </div>

                              <div class="input-field col s12"> 
                                 <label for="" class="">Profile Image</label> 
                                 <p style="border:none;"> 
                                    <?php if (!empty($dataRecord->profile_image)) { ?> 
                                       <img src="<?= base_url($dataRecord->image_path.'/'.$dataRecord->profile_image) ?>" width="100"> 
                                    <?php }else{ ?> 
                                       <img src="<?= base_url('assets/admin/images/avatar/avatar-7.png') ?>" width="100"> 
                                    <?php } ?> 
                                 </p> 
                                 <input type="file" name="profile_image" placeholder="Number.." />

                              </div>

                                       <!-- <div class="input-field col s12">

                                          <label for="" class="">Telephone</label>

                                          <p>9876554566</p>

                                          <input type="text" />

                                       </div>

                                       <div class="input-field col s12">

                                          <label for="" class="">Address</label>

                                          <p>Company name</p>

                                          <input type="text" />

                                          <p>Area</p>

                                          <input type="text" />

                                          <p>City</p>

                                          <input type="text" />

                                          <p>Country</p>

                                          <input type="text" />

                                          <p>Zip code</p>

                                          <input type="text" />

                                       </div> -->



                                    </div>

                                 </div>

                                 

                              </div>

                              <div class="card-head"> 

                                 <div class="right-head">

                                    <span><button type="button" class="btn edit-it"><i class="fa fa-edit"></i>Edit</button></span>

                                    <span><button type="submit" class="btn save-it">Save</button></span>

                                    <span><button type="button" class="btn cancel-it">Cancel</button></span>

                                 </div>

                              </div>

                           </form>

                        </div>

                     </div>

                  </div>

               </div>



            </div>

         </div>

      </div>

      <!-- END: Page Main-->

      <!-- BEGIN: Footer-->

      <?php include 'footer.php'; ?>