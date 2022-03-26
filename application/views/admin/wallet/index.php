<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('admin/head', $data); ?>

<!-- END: Head-->

<body

   class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 2-columns   "

   data-open="click" data-menu="vertical-dark-menu" data-col="2-columns">

   <!-- BEGIN: Header-->

   <?php $this->load->view('admin/header', $data); ?>


   <!-- END: Header-->

   <!-- BEGIN: SideNav-->
  <?php $this->load->view('admin/sidebar', $data); ?> 

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

                                <div class="card">

                                    <div class="row">

                                         <div class="card-content">

                                            <div class="col s12">

                                               <h4 class="admin-heading">Wallet history</h4>

                                            </div>

                                         </div>

                                      </div>

                                    <div class="card-content">

                                        

                                        <div class="row">

                                            <div class="col s12">

                                                <table id="page-length-option" class="display">

                                                    <thead>

                                                        <tr>

                                                            <th>Sr.No.</th>
                                                            <th>User Name</th> 
                                                           <th>BusinessName</th> 
                                                           <th>Created Date</th> 
                                                           <!-- <th>Status</th> --> 
                                                           <th>TransactionId</th>
                                                           <th>Amount</th>

                                                           <th>PaymentBy</th>
                                                           <th>Email</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>
                                                      <?php
                                                        if (!empty($listRecord)) {
                                                           foreach ($listRecord as $key => $item) {
                                                      ?>
                                                        <tr>
                                                          <td><?= $key + 1 ?></td>
                                                           <td><?= $item->first_name.' '.$item->last_name ?? '-' ?></td> 
                                                           <td><?= $item->username ?? '-' ?></td> 

                                                           <td><?= changeDateFormat('M-d-Y',$item->created_at) ?></td>

                                                           <!-- <td><span class="badge pink lighten-5 pink-text text-accent-2">Close</span></td> --> 
                                                           <td><?= $item->tx_id ?></td>
                                                           <td><?= ($item->price_unit=='usd' ? "$":"Rs.").$item->total_amount ?></td>
                                                           <td><?=  ucfirst($item->payment_by) ?></td>
                                                           <td><?= $item->email ?></td>
                                                          <!--  <td class="center-align"><a target="_blank" href="<?= admin_url('payment/invoice/'.$item->id) ?>" title="View Details"><i class="fa fa-eye"></i></a></td> -->
                                                           <!-- <a href=""><i class="fa fa-edit"></i></a> /  -->
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
  <?php $this->load->view('admin/footer', $data); ?> 