<!DOCTYPE html>

<html>

   <head>

      <title>Register Page</title>

      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- Latest compiled and minified CSS -->

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/proall.css') ?>">
      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>">

      <!-- jQuery library -->

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

      <script type="text/javascript" src="engine1/jquery.js"></script>

      <!-- Latest compiled JavaScript -->

      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <style>
         body{background:#f4f6fd;}
         .rights {
             position: absolute;
             bottom: 20px;
             text-align: center;
             width: 100%;
         }

         .rightfix {
    position: absolute;
    right: 130px;
    bottom: 27px;
    background-color: transparent !important;
    border: none;
}
      </style>
   </head>

   <body>


      <div class="container">
         <div class="posRel">
            <div class="wrapper" id="posAbs" style="background:#ffffff;">
                <div class="bc-btn">
               <a href="<?= base_url('') ?>"><i class="fas fa-arrow-left"></i></a>
                    </div>
               <div class="row text-center">

                  <h3>Register</h3>

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
              <form action="<?= base_url('register/save/') ?>" method="post" class="form text-left" id="signupform">

                     <div class="row">

                        <div class="col-md-6 col-xs-12">

                           <div class="form-group">

                              <label style="margin-bottom:0px">First Name</label>

                              <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                              <?php echo form_error('first_name', '<div class="error">', '</div>'); ?>

                           </div>

                           <div class="form-group">        

                              <label style="margin-bottom:0px">Mobile Number</label>

                              <div class="input-group">

                                <!-- <div class="input-group-prepend">

                    <span class="input-group-text">+91</span>

                  </div> -->
                <input type="text" pattern="\d*" maxlength="15" name="phone" class="form-control" placeholder="Mobile  ">
                  <?php echo form_error('phone', '<div class="error">', '</div>'); ?>

                           </div>
                             <div id="errmsg"></div>

                           </div>

                           <div class="form-group">

                              <label style="margin-bottom:0px">Password</label>

                              <input type="password" name="password" class="form-control" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                  <?php echo form_error('password', '<div class="error">', '</div>'); ?>

                           </div>


                           <div class="form-group">
                <label class="stylelable active" for="example-text">URL </label>                                         
                <span class="input-group-addon rightfix">.smartschool.one</span>
                <input type="text" name="username" class="form-control slug-output compnystyle" placeholder="Enter subdomain" id="username" required="required">
                <div id="msg"></div>
              </div>

                          <!--  <div class="form-group">

                              <label style="margin-bottom:0px">Academy type</label>

                              <select class="form-control">

                                <option selected disabled>School Type</option>

                                <option value="School">School One</option>

                                <option value="School">School Two</option>

                                <option value="School">School Three</option>

                                <option value="School">School Four</option>

                              </select>

                           </div> -->

                        </div>

                        <div class="col-md-6 col-xs-12">

                           <div class="form-group">

                              <label style="margin-bottom:0px">Last Name</label>

                              <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                      <?php echo form_error('last_name', '<div class="error">', '</div>'); ?>

                           </div>

                           <div class="form-group">        

                              <label style="margin-bottom:0px">Email Address</label>

                              <input type="email" name="email" class="form-control" placeholder="Email address">
                  <?php echo form_error('email', '<div class="error">', '</div>'); ?>

                           </div>

                           <div class="form-group">

                              <label style="margin-bottom:0px">School Full Name</label>

                              
                              <input type="text" name="school_name" id="school_name" class="form-control" placeholder="School Full Name..." pattern="[^()/><\][\\\x22,;|]+">
                  
                  <?php echo form_error('school_name', '<div class="error">', '</div>'); ?>
                           </div> 
<input type="hidden" name="role" class="form-control" value="school">
                          <!--  <div class="form-group">

                              <label style="margin-bottom:0px">Academy Sub type</label>

                              <select class="form-control">

                                <option selected disabled>School Name</option>

                                <option value="School">School One</option>

                                <option value="School">School Two</option>

                                <option value="School">School Three</option>

                                <option value="School">School Four</option>

                              </select>

                           </div> -->

                        </div>

                        <div class="col-md-12 col-xs-12">

                         <div class="section">

                            <p>Signingup in India. Currency:INR Time zone : Asia/Kolkata</p>

                            <p>Language:English</p>

                         </div>

                         <div class="form-group" id="ch">

                            <input type="checkbox" id="rem" name="accept" value="1" required>

                            <label for="rem" style="font-size: 12px;">I agree to the Term and Privacy policy</label>

                         </div>

                     </div>

                        <div class="col-md-12 text-center">

                           <button type="submit" id="login-button">Register</button>

                           <div class="btn-section">

                              <p>Already have an account ?</p>

                              <a href="<?= base_url('login') ?>">Login</a><br/>

                           </div>

                        </div>

                     </div>

                  </form>

               </div>

            </div>
         <div class="rights"> Copyright&nbsp;<span id="cur_year"><?=date('Y')?></span>&nbsp;© Smart School Pvt Ltd. </div>
         </div>
      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script>
         $(function(){
            $("#phone").keypress(function (e) {
              if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
               $("#errmsg").html("Number Only").stop().show().fadeOut("slow");
               return false;
             }
            });
         });
      </script>


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
 <script type="text/javascript">
  $(document).ready(function() {
    $("#username").on("input", function(e) {
      $('#msg').hide();
      if ($('#username').val() == null || $('#username').val() == "") {
        $('#msg').show();
        $("#msg").html("Username is required field.").css("color", "red");
      } else {
        $.ajax({
          type: "POST",
          url: "<?= base_url('register/get_username_availability') ?>",
          data: $('#signupform').serialize(),
          dataType: "html",
          cache: false,
          success: function(msg) {
            $('#msg').show();
            $("#msg").html(msg);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $('#msg').show();
            $("#msg").html(textStatus + " " + errorThrown);
          }
        });
      }
    });
  });
</script>
   </body>
</html>