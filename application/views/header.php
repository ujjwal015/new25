<body>

    <header class="mp-header">

       <div class="brand">

       	<a href="<?= base_url('/')?>" >
						<?php $logoImage = check_row('tbl_setting',array('id'=>1)) ;
						if (!empty($logoImage) && !empty($logoImage->logo_image)) { ?>
							 <img src="<?= base_url($logoImage->image_path.'/'.$logoImage->logo_image) ?>"> 
						<?php 
						}else{ 
						?>
							<img src="assets/img/logoSmart.jpg" alt="">
						<?php } ?>
					</a>

</div>

       <!---->

       <div class="nav">
          <div class="desktop">
             <a class="bln" href="forschool.php">For schools</a>
             <a href="">Teach a course</a>
             <div class="drop_menu main_menu">
              <a href="javascript:void(0)">
                <span>Features</span>
                <i class="fas fa-chevron-down md hydrated"></i>
              </a>
              <div class="list">
                <div>
                  <a href="attendancepage.php">
                    <span>Attendance</span>
                  </a>
                  <a href="bookingpage.php">
                    <span>Booking</span>
                  </a>
                  <a href="communication.php">
                    <span>Communication</span>
                  </a>
                  <a href="learningmanagement.php">
                    <span>Learning Management</span>
                  </a>
                  <a href="live-class.php">
                    <span>Live Class</span>
                  </a>                  
                  <a href="onlinecourse.php">
                    <span>Online Courses</span>
                  </a>   
                  <a href="studentmanagement.php">
                    <span>Student Management</span>
                  </a>
                  <a href="websiteenrollment.php">
                    <span>Website Enrollment</span>
                  </a>
                  <a href="book13.php">
                    <span>Book a Call</span>
                  </a>
                  <a href="join.php">
                    <span>Join</span>
                  </a>
                </div>
              </div>
             </div>
             <div class="drop_menu main_menu">
              <a href="javascript:void(0)">
                <span>Signup</span>
                <i class="fas fa-chevron-down md hydrated"></i>
              </a>
              <div class="list">
                <div>
                  <a href="parent-student-reg.php">
                    <span>Registration parents and school</span>
                  </a>
                  <a href="<?= base_url('register') ?>">
                    <span>Registration</span>
                  </a>
                  <a href="<?= base_url('register') ?>">
                    <span>Academy Registration</span>
                  </a>
                  <a href="registeronline.php">
                    <span>Online Registration</span>
                  </a>
                  <a href="registerpreschool.php">
                    <span>Preschool Registration</span>
                  </a>
                  <a href="instantlyreg.php">
                    <span>Instantly Registration</span>
                  </a>
                  <a href="instantly.php">
                    <span>Instantly</span>
                  </a>
                </div>
              </div>
            </div>

<?php if ($this->session->userdata('is_admin')) { ?>
							<a href="<?= base_url('admin') ?>">Dashboard</a>
							<a href="<?= base_url('login/logout') ?>" >Logout</a>
						<?php }else{ ?>
							<a href="<?= base_url('login') ?>">Login</a>
							
						<?php } ?>



             <div class="drop_menu main_menu">

                <button class="trigger">

                    <i class="fas fa-bars md hydrated"></i>

                </button>

                <div class="list">

                   <div>

                      <a href="#">

                         <i class="fas fa-arrow-circle-down md hydrated"></i>

                         <span>Download app</span>

                      </a>

                      <a href="contact.php">

                         <i class="fas fa-user-friends md hydrated"></i>

                         <span>Contact support</span>

                      </a>

                      <button>

                          <i class="fas fa-language md hydrated"></i>

                         <span>English</span>

                      </button>

                   </div>

                </div>

             </div>

          </div>

          <div class="mobile">

             <button class="nav_trigger">

                <i class="fas fa-bars md hydrated"></i>

             </button>

             <div class="nav_list">

                <div class="header">

                     <a class="bln" href="forschool.php">For schools</a>

                     <button class="mob-nav-close">

                        <i class="fas fa-times"></i>

                     </button>

                  </div>

                <div class="wrapper">

                   <div class="links">

                      <a href="">Teach a course</a>
                       <div class="drop_menu main_menu">
                        <a href="javascript:void(0)">
                          <span>Features</span>
                          <i class="fas fa-chevron-down md hydrated"></i>
                        </a>
                        <div class="list">
                          <div>
                            <a href="attendancepage.php">
                              <span>Attendance</span>
                            </a>
                            <a href="bookingpage.php">
                              <span>Booking</span>
                            </a>
                            <a href="communication.php">
                              <span>Communication</span>
                            </a>
                            <a href="learningmanagement.php">
                              <span>Learning Management</span>
                            </a>
                            <a href="live-class.php">
                              <span>Live Class</span>
                            </a>                  
                            <a href="onlinecourse.php">
                              <span>Online Courses</span>
                            </a>   
                            <a href="studentmanagement.php">
                              <span>Student Management</span>
                            </a>
                            <a href="websiteenrollment.php">
                              <span>Website Enrollment</span>
                            </a>
                            <a href="book13.php">
                              <span>Book a Call</span>
                            </a>
                            <a href="join.php">
                              <span>Join</span>
                            </a>
                          </div>
                        </div>
                       </div>
                       <div class="drop_menu main_menu">
                        <a href="javascript:void(0)">
                          <span>Signup</span>
                          <i class="fas fa-chevron-down md hydrated"></i>
                        </a>
                        <div class="list">
                          <div>
                            <a href="parent-student-reg.php">
                              <span>Registration parents and school</span>
                            </a>
                            <a href="<?= base_url('register') ?>">
                              <span>Registration</span>
                            </a>
                            <a href="<?= base_url('register') ?>">
                              <span>Academy Registration</span>
                            </a>
                            <a href="registeronline.php">
                              <span>Online Registration</span>
                            </a>
                            <a href="registerpreschool.php">
                              <span>Preschool Registration</span>
                            </a>
                            <a href="instantlyreg.php">
                              <span>Instantly Registration</span>
                            </a>
                            <a href="instantly.php">
                              <span>Instantly</span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <?php if ($this->session->userdata('is_admin')) { ?>
                        <a href="<?= base_url('admin') ?>">Dashboard</a>
                        <a href="<?= base_url('login/logout') ?>" >Logout</a>
                      <?php }else{ ?>
                        <a href="<?= base_url('login') ?>">Login</a>
                        
                      <?php } ?>
                      <div class="drop_menu main_menu">

                <button class="trigger">

                    <i class="fas fa-bars md hydrated"></i>

                </button>

                <div class="list">

                   <div>

                      <a href="#">

                         <i class="fas fa-arrow-circle-down md hydrated"></i>

                         <span>Download app</span>

                      </a>

                      <a href="contact.php">

                         <i class="fas fa-user-friends md hydrated"></i>

                         <span>Contact support</span>

                      </a>

                      <button>

                          <i class="fas fa-language md hydrated"></i>

                         <span>English</span>

                      </button>

                   </div>

                </div>

             </div>

                   </div>

                   <div class="social">

                      <a href="" target="_blank">

                         <ion-icon name="logo-facebook" role="img" class="md hydrated" aria-label="logo facebook"></ion-icon>

                      </a>

                      <a href="h" target="_blank">

                         <ion-icon name="logo-twitter" role="img" class="md hydrated" aria-label="logo twitter"></ion-icon>

                      </a>

                      <a href="" target="_blank">

                         <ion-icon name="logo-youtube" role="img" class="md hydrated" aria-label="logo youtube"></ion-icon>

                      </a>

                   </div>

                </div>

             </div>

          </div>

          <!----><!---->

       </div>

       <!----><!----><!----><!----><!----><!----><!----><!---->

    </header>