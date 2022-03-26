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

                                <div class="card">

                                    <div class="row">

                                         <div class="card-content">

                                            <div class="col s12">

                                               <h4 class="admin-heading">Invoices</h4>

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

                                                           <th>Max User</th>
                                                           <th>Type</th>
                                                           <th>Action</th>

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
                                                           <td><?= $item->subdomain ?? '-' ?></td> 

                                                           <td><?= changeDateFormat('M-d-Y',$item->created_at) ?></td>

                                                           <!-- <td><span class="badge pink lighten-5 pink-text text-accent-2">Close</span></td> --> 
                                                           <td><?= $item->payment_id ?></td>
                                                           <td><?= RAZORCURRENCY.' '.$item->total_amount ?></td>
                                                           <td><?= $item->max_user_allowed ?></td>
                                                           <td><?= strtoupper($item->payment_type) ?></td>
<?php

if($item->payment_status=='pending'){
    $icom_class = 'fa fa-times';
    $title = 'Inactive';
    $myclass='danger';
}else{
    $icom_class = 'fa fa-check';
    $title = 'Active'; 
     $myclass='success';
    
}


?>



                                                           <td class="center-align">
                                                               <a target="_blank" href="<?= admin_url('payment/invoice/'.$item->pay_id) ?>" title="View Invoice"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?= admin_url('payment/invoiceEdit/'.$item->pay_id) ?>" title="Edit Invoice"><i class="fa fa-edit"></i></a>&nbsp;&nbsp; <a target="_blank" class="<?=$myclass?>" href="<?= admin_url('payment/invoice/'.$item->pay_id) ?>" title="<?=$title?>"><i class="<?=$icom_class?>"></i></a></td>
                                                            
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
<style>
    .danger{
        color:red;
    }
    
    .success{
        color:green;
    }
</style>



   <?php include 'footer.php'; ?>