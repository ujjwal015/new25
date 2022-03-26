<?php include 'head.php' ?>

<!-- END: Head-->
<style type="text/css">
 table.a {
  table-layout: auto;
  width: 180px !important;  
}

table.b {
  table-layout: fixed;
  width: 180px !important;  
}
</style>
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

                    <h4 class="admin-heading">Package Listing</h4>

                    <div class="action-btns"> 

                      <a href="<?= base_url('admin/packages/add') ?>" class="waves-effect waves-light btn"><span><i class="fa fa-plus"></i>Add Package</span></a> 



                    </div>

                  </div>

                </div>

              </div>

            </div>

            <div class="card-content">



              <div class="row">

                <div class="col s12">

                  <table id="page-length-option" class="responsive-table">

                    <thead>

                      <tr>

                        <th>Sr.No.</th>
                        <th>Package Name</th>

                       
                        <th>Created At</th>

                        <!-- <th>Status</th> -->

                        <th>Price(In £)</th>

                        
                        <th>Max User</th>
                        <th>Valid For</th>

                        <th>Action</th>

                      </tr>

                    </thead>

                    <tbody>

                      <?php

                      if (!empty($listRecord)) {

                        foreach ($listRecord as $key => $row) { 

                          ?>

                          <tr>

                           <td><?= $key + 1 ?></td>
                           <td><?= $row->title ?></td>

                           

                           <td><?= changeDateFormat('d-M-Y',$row->created_at) ?></td>

                           <!-- <td><span class="badge pink lighten-5 pink-text text-accent-2">Close</span></td> -->

                           <td><?= $row->regular_price ?></td>

                          
                           <td><?= $row->max_user ?></td>
                           <td><?= $row->valid_for_days.' Days' ?></td>  
                           <td>
                           <!-- <a href=""></a><i class="fa fa-eye"></i></a> /  -->
                           <!-- <a href=""><i class="fa fa-edit"></i></a> /  -->
                           <a href="<?= admin_url('packages/add/'.$row->id) ?>"><i class="fa fa-edit pink-text"></i></a> |
                           <a href="<?= admin_url('packages/delete/'.$row->id) ?>" onclick='return confirm("Are you sure?  this action can not be reserved !")'><i class="fa fa-trash pink-text"></i></a></td>

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