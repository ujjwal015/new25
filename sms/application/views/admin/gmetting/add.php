
<style type="text/css">
  .d-none{
    display: none;
  }
 
  .liststaff {
    padding: 0;
    margin: 0;
    list-style: none;
    max-height: 265px;
    overflow: auto;
}
.list-group-item:first-child {
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}

::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}

</style>

<div class="content-wrapper" style="min-height: 946px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-calendar-check-o"></i> <?php echo $this->lang->line('attendance'); ?> <small> <?php echo $this->lang->line('by_date1'); ?> </small>
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
  <div class="row">


    <div class="col-sm-12"> <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                            <?php } ?></div>
                            <div class="col-md-12">
                              <a href="<?php echo base_url()?>admin/Googlemetting/list" class="btn btn-primary" style="float:right;"><i class="fa fa-list"></i> List</a>
                            </div>

    <div class="col-sm-10 col-md-10 col-lg-10">

  

          <div class="box box-primary add-classroom-box" >
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Google Metting</h3>
                    </div>
                    <form id="form1" action="<?php echo site_url('admin/Googlemetting/create') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                        <div class="box-body">
                           
                                
                            <?php echo $this->customlib->getCSRF(); ?> 
                                              
                              <div class="row">
                                <div class="col-md-7">
                                   <div class="form-group">
                                <label for="exampleInputEmail1">Metting Title</label><small class="req"> *</small>
                                <input autofocus="" id="name" name="metting_title" placeholder="Class title" type="text" class="form-control"  value="<?php echo set_value('year'); ?>" />
                                <span class="text-danger"><?php echo form_error('metting_title'); ?></span>
                            </div>
                             <div class="row">
                               <div class="col-md-6">
                                 <div class="form-group">
                                <label for="exampleInputEmail1">Metting Date</label><small class="req"> *</small>
                                <input autofocus="" id="metting_date" name="date" placeholder="Date" type="text" class="form-control date"  value="<?php echo set_value('date'); ?>" />
                                <span class="text-danger"><?php echo form_error('date'); ?></span>
                            </div>
                               </div>
                               <div class="col-md-6">
                                 <div class="form-group">
                                <label for="exampleInputEmail1">Duration</label><small class="req"> *</small>
                                <input autofocus="" id="duration" name="duration" placeholder="Duration" type="text" class="form-control"  value="<?php echo set_value('duration'); ?>" />
                                <span class="text-danger"><?php echo form_error('duration'); ?></span>
                            </div>
                               </div>
                             </div>

                              
                           
                           

                           

                            <div class="form-group">
                                <label for="exampleInputEmail1">Gmeet URL</label><small class="req"> *</small>
                                <input autofocus=""  name="url" placeholder="Gmeet URL" type="text" class="form-control"  value="<?php echo set_value('url'); ?>" />
                                <span class="text-danger"><?php echo form_error('url'); ?></span>
                            </div>

                           
                             <div class="form-group">
                                <label for="exampleInputEmail1">Description</label><small class="req"> *</small>
                               <textarea class="form-control" name="description">
                              
                               </textarea>
                                <span class="text-danger"><?php echo form_error('description'); ?></span>
                            </div>

                                </div>
                                <div class="col-md-5">
                                 <label>Staff List</label>
                                 <div class="staff-list">
                                  <ul class="liststaff">
                                    <?php foreach($stafflist as $list){?>
                                    <li class="list-group-item">
                                      <div class="checkbox">
                                                <label for="staff_2">
                                                    <input type="checkbox" id="staff_2" value="<?php echo $list['id']?>" name="staff[]">
                                                    <?php echo $list['name']?> (<?php echo $list['designation']  ?>)                                                </label>
                                            </div>
                                    </li>
                                  <?php }?>
                                      
                                    
                                    
                                    
                                    
                                   
                                    
                                   
                                  </ul>
                                   <?php echo form_error('description'); ?>
                                 </div>
                                </div>
                              </div>



                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                    </form>
                </div>

              
 
    </div>
     
  </div>
  </section>
</div>
<div id="delete-modal" class="modal fade">
  <div class="modal-dialog modal-confirm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header flex-column">
        <div class="icon-box">
          <i class="material-icons">&#xE5CD;</i>
        </div>            
        <h4 class="modal-title w-100">Are you sure?</h4>  
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <p>Do you really want to delete these Classroom ? </p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger delete-confirm-btn">Delete</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">






// with a title
 

  $(document).ready(function(){


     $("input").each(function(){
      $(this).on("input",function(){
       
        if($(this).next("span").html()!=""){
          $(this).next().remove();
        }
      });
     });



  
  });
<?php if($this->session->flashdata("success")){?>

  toastr.success("Successfully Added",{
  positionClass:'toast-bottom-right',
   progressBar:true


});

<?php } else {?>

toastr.warning(<?php echo $this->session->flashdata("warning")?>,{
  positionClass:'toast-bottom-right',
   progressBar:true


});
<?php }?>


  
</script>
