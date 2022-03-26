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

                <div class="section section-data-tables"> 

                    <!-- Page Length Options -->

                    <div class="row">

                        <div class="col s12">

                            <div class="card">

                                <div class="row">

                                   <div class="card-content">

                                      <div class="col s12"> 

                                         <div class="listing-header">

                                            <h4 class="admin-heading">Drivers</h4>

                                            <div class="action-btns"> 

                                            <!--   <a href="<?= base_url('admin/companies/add') ?>" class="waves-effect waves-light btn"><span><i class="fa fa-plus"></i>Add Company</span></a> -->



                                          </div>

                                      </div>

                                  </div>

                              </div>

                          </div>

                          <div class="card-content"> 

                            <div class="row">

                                <div class="col s12">

                                    <table id="page-length-option" class="display">

                                        <thead>

                                            <tr>
                                                <td>Sr.No.</td>
                                                <th>Name</th> 
                                                <!--<th>BusinessName</th>-->
                                                <th>Subdomain</th> 
                                                <th>Email</th> 
                                                <th>Phone</th> 
                                                <th>Driver Type</th>  
                                                <th>Created At</th>
                                                <!--<th>Status</th> -->
                                                <!-- <th>Action</th> --> 
                                            </tr> 
                                        </thead>

                                        <tbody>

                                             <?php

                                              if (!empty($listRecord)) { 
                                                foreach ($listRecord as $key => $row) {  
                                                  ?> 
                                            <tr>  
                                              <td><?= $key + 1 ?></td>
                                                <td> 
                                                    <?= $row->firstname.' '.$row->lastname ?>
                                                </td>  
                                                <!--<td><?= $row->username ?? '-' ?></td>-->
                                                <td><?= $row->subdomain_name ?? '-' ?></td> 
                                                <td><?= $row->email ?? '-' ?></td>
                                               
                                                <td><?= $row->mobile_no ?? '-' ?></td>
                                                <td><?= $row->driver_type ?? '-' ?></td>

                                                <td><?= changeDateFormat('d-M-Y',$row->created_at) ?></td> 

                                               <!--  <td class="center-align"><a href="<?= admin_url('companies/delete/'.$row->id) ?>" onclick='return confirm("Are you sure? this action can not be reserved !")'><i class="material-icons pink-text">clear</i></a></td> -->
                                             
                                            </tr>

                                        <?php } } ?> 

                                        </tbody> 

                                    </table>

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