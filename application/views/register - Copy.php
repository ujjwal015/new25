<!DOCTYPE html>
<html>
   <head>
      <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontent/') ?>css/style.css" >
      <link rel="icon" href="logo/favicon.png" type="image/png" sizes="16x16">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
      <link href="<?= base_url('assets/frontent/css/reg.css') ?>" rel="stylesheet" />
      <title>Register</title>
     
   </head>
   <body>
      <section class="container">
         <?php $logoImage = check_row('tbl_setting',array('id'=>1)) ;
          if (!empty($logoImage) && !empty($logoImage->logo_image)) { ?>
          <a href="<?= base_url('/')?>">
            <img src="<?= base_url($logoImage->image_path.'/'.$logoImage->logo_image) ?>" width="100">
          </a>
          <?php 
          }else{ 
          ?>
            <a href="<?= base_url() ?>" class="brand-logo">Door2Door</a>
          <?php } ?>
         <span class="rig5"><a href="<?= base_url('pricing') ?>" class="link2">Try it Free</a></span>
         <span class="rig5">
            <p class="para3">Not a Door2Door user?</p>
         </span>
      </section>
      <section class="container">
   <div class="cont">
      <div class="form-right">
       
            
            <div class="card-body">
              <h2 class="text-center">Sign Up</h2>
              <p class="text-center"><small>Please enter your details to sign up and be part of our great community</small></p>
              <br>
              <?php if($this->session->flashdata('message')): ?>
                   <div class="alert alert-success" style="color: grey">
                     <?php echo $this->session->flashdata('message');?>
                   </div>
                <?php endif; 
                 if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger" style="color: grey">
                      <?php echo $this->session->flashdata('error');?>
                    </div>
                <?php endif;
                $countyList = $this->db->get('countries')->result();
                ?>
              <form action="<?= base_url('register/save/') ?>" method="post">
                <div class="form-group mb-50">
                  <label class="text-bold-600">Country Name</label>
                 <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="country_id" required>
                  <option value="">Select Country</option>
                  <?php if (!empty($countyList)) {
                    foreach ($countyList as $key => $c) { ?>
                    <option value="<?= $c->id ?>" > <?= $c->nicename ?></option>
                  <?php } } ?> 
                </select>
                  <?php echo form_error('username', '<div class="error">', '</div>'); ?>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-sm-6 col-12">
                    <div class="form-group mb-50">
                      <label class="text-bold-600">First Name</label>
                      <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                      <input type="hidden" name="package_id" class="form-control" placeholder="First Name" value="<?= $package_id; ?>">
                      <?php echo form_error('first_name', '<div class="error">', '</div>'); ?>
                    </div>
                  </div>

                  <div class="col-lg-6 col-sm-6 col-12">
                    <div class="form-group mb-50">
                      <label class="text-bold-600">Last Name</label>
                      <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                      <?php echo form_error('last_name', '<div class="error">', '</div>'); ?>
                    </div>
                  </div>
                </div>
                <div class="form-group mb-50">
                  <label class="text-bold-600">Business Name</label>
                  <input type="text" name="username" id="username" class="form-control" placeholder="Business Name..." pattern="[^()/><\][\\\x22,;|]+">
                  <span style="display: none;" class="error" id="username__error">The Business Name field may only contain alpha-numeric characters.</span>
                  <?php echo form_error('username', '<div class="error">', '</div>'); ?>
                </div>
                <div class="form-group mb-50">
                  <label class="text-bold-600">Phone <span style="color: red;">(Only number allowed)</span></label>
                  <input type="text" pattern="\d*" maxlength="15" name="phone" class="form-control" placeholder="Mobile  ">
                  <?php echo form_error('phone', '<div class="error">', '</div>'); ?>
                </div>
                <div class="form-group mb-50">
                  <label class="text-bold-600">Email address</label>
                  <input type="email" name="email" class="form-control" placeholder="Email address">
                  <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                </div>

                <div class="form-group mb-50">
                  <label class="text-bold-600">PassWord</label>
                  <input type="password" name="password" class="form-control" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                  <?php echo form_error('password', '<div class="error">', '</div>'); ?>
                  <small>Password Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters</small>
                </div>
              <button type="submit" id="login__btn" class="btn btn-login">SIGN UP<i class="fa fa-arrow-right"></i></button>
            </form>
            <hr>
            <div class="text-center"><small class="mr-25">Already have an account?</small><a href="<?= base_url('login') ?>"><small>Sign in</small></a></div>
          </div>
        
      </div>
      <div class="form-left">
        <img src="<?= base_url('assets/frontent/') ?>assets/image/registertop.png" class="img-responsive">
      </div>
   </div>
</section>
 <script type="text/javascript">
     $(document).ready(function() {
        var alphanumers = /^[a-zA-Z0-9]+$/;
        // $('#username').keyup(function(){
        //   if(!alphanumers.test($("#username").val())){
        //     $('#username__error').css('display','block');
        //     $('#login__btn').attr('disabled',true);
        //   }else{
        //     $('#username__error').css('display','none');
        //     $('#login__btn').attr('disabled',false);
        //   }
        // })
         
        $("input").attr("required", true); 
     });
     function formatState (state) {
        if (!state.id) {
          return state.text;
        }
        var baseUrl = "<?= base_url('assets/frontent/flags') ?>";
        var thumb = $(state.element).data('thumb');
        var $state = $(
          '<span>' + state.text + '</span>'
        );
        return $state;
      };
     $(document).ready(function() {
        $('.select2').select2({
        closeOnSelect: true,
        templateResult: formatState
        });
      });
 </script>
   </body>
</html>