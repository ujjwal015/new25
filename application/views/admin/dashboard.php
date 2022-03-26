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
   <div id="main">
      <div class="row">
         <div class="admin-header">
            <div class="col s12">
               <h4 class="admin-heading">Dashboard</h4>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col s12">
            <div class="section">
               <!--card stats start-->
               <div id="card-stats" class="pt-0">
                  <div class="row">
                     <div class="col s12 m6 l6 xl3">
                        <div class="card min-height-100 animate fadeLeft">
                           <div class="">
                              <div class="row">
                                 <div class="col s7 m7">
                                    <i class="fas fa-box background-round mt-5"></i>
                                    <p>Package</p>
                                 </div>
                                 <div class="col s5 m5 right-align">
                                    <h5 class="mb-0 "><?= count($totalPacakage) ?? '0'  ?></h5>
                                    <p class="no-margin">Total</p>
                                    <!-- <p>6,00,00</p> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col s12 m6 l6 xl3">
                        <div class="card min-height-100 animate fadeLeft">
                           <div class="">
                              <div class="row">
                                 <div class="col s7 m7">
                                    <i class="fas fa-building background-round mt-5"></i>
                                    <p>Companies</p>
                                 </div>
                                 <div class="col s5 m5 right-align">
                                    <h5 class="mb-0 "><?= count($listRecord) ?></h5>
                                    <p class="no-margin">Total</p>
                                    <!-- <p>1,12,900</p> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col s12 m6 l6 xl3">
                        <div class="card min-height-100 animate fadeRight">
                           <div class="">
                              <div class="row">
                                 <div class="col s7 m7">
                                     <i class="fas fa-car background-round mt-5"></i>
                                    <!-- <i class="material-icons background-round mt-5">perm_identity</i> -->
                                    <p>Total Drivers</p>
                                 </div>
                                 <div class="col s5 m5 right-align">
                                    <h5 class="mb-0 "><?= count($listDriver) ?></h5>
                                    <p class="no-margin">Total</p>
                                    <!-- <p>3,42,230</p> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col s12 m6 l6 xl3">
                        <div class="card min-height-100 animate fadeRight">
                           <div class="">
                              <div class="row">
                                 <div class="col s7 m7">
                                    <i class="fas fa-euro-sign background-round mt-5"></i>
                                    <!-- <i class="material-icons background-round mt-5">perm_identity</i> -->
                                    <p>Sales</p>
                                 </div>
                                 <div class="col s5 m5 right-align">
                                    <h5 class="mb-0 "><?= RAZORCURRENCY.' '.$totalGet->total ?></h5>
                                    <p class="no-margin">Total</p>
                                    <!-- <p>$25,000</p> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!--card stats end-->
            </div>
         </div>
      </div>
      <div class="row">
           
            <div class="col s12">
                <div class="container">
                    <div class="section section-data-tables"> 
                        <!-- Page Length Options -->
                        <div class="row">
                            <div class="col s12">
                                <div class="card">
                                   
                                    <div class="card-content">
                                        <h4 class="admin-heading">Companies</h4>
                                        <div class="row">
                                            <div class="col s12">
                                                <table id="page-length-option" class="display">
                                                    <thead>
                                                        <tr>
                                                           <th>Sr.No.</th>
                                                           <th>Name</th>
                                                           <th>BusinessName</th>
                                                           <th>Email</th>
                                                           <th>Created at</th>
                                                           <th>Status</th>
                                                           <th>Max User</th>
                                                           <th>Expire Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php
                                                        if (!empty($listRecord)) {
                                                          foreach ($listRecord as $key => $item) {
                                                            $sqlMonth = "SELECT SUM(`total_amount`) AS total,COUNT(`pay_id`) AS total_count FROM tbl_payment_history";
                                                            $query = $this->db->query($sqlMonth); 
                                                            $data['totalGet'] = $query->row();
                                                        ?>
                                                        <tr>
                                                           <td><?= $key + 1 ?></td>
                                                           <td><?= $item->first_name.' '.$item->last_name ?></td>
                                                           <td><?= $item->username ?></td>
                                                           <td><?= $item->email ?></td>
                                                           <td><?= changeDateFormat('M-d-Y',$item->created_at) ?></td>
                                                           <td>
                                                            <?php if ($item->active) { 
                                                              $st = 0;
                                                              ?>
                                                            <a onclick="return confirm('Are you sure ?')" href="<?= admin_url('dashboard/user_status/'.$st.'/'.$item->id) ?>"> <span class="badge green lighten-5 green-text text-accent-2">Active</span>
                                                            </a>
                                                          <?php }else{
                                                           $st = 1; 
                                                            ?>
                                                            <a onclick="return confirm('Are you sure ?')"href="<?= admin_url('dashboard/user_status/'.$st.'/'.$item->id) ?>"><span class="badge pink lighten-5 pink-text text-accent-2">In Active</span>
                                                            </a>
                                                          <?php } ?>
                                                          </td>
                                                           <td><?= $item->max_user_allowed ?></td>
                                                           <td><?= changeDateFormat('M-d-Y',$item->expire_date) ?></td>
                                                           <!-- <td class="center-align"><a href="#"><i class="material-icons pink-text">clear</i></a></td> -->
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
   <!-- BEGIN: Footer-->
   <?php include 'footer.php'; ?>