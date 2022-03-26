<header class="page-topbar" id="header">
   <div class="navbar navbar-fixed">
      <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-light">
         <div class="nav-wrapper">
            <?php $dataRecord =getLoginUser(); ?>
            <ul class="navbar-list right">
              
              <!--  <li><a class="waves-effect waves-block waves-light notification-button"
                  href="javascript:void(0);" data-target="notifications-dropdown"><i
                  class="material-icons">notifications_none<small
                  class="notification-badge">5</small></i></a></li> -->
               <li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);"
                  data-target="profile-dropdown"><span class="avatar-status avatar-online">
               <?php if (!empty($dataRecord->profile_image)) { ?> 
                  <img src="<?= base_url($dataRecord->image_path.'/'.$dataRecord->profile_image) ?>" alt="avatar"> 
               <?php }else{ ?>
                  <img src="<?= base_url('master_assets/admin/') ?>images/avatar/avatar-7.png" alt="avatar">
               <?php } ?>

                  <i></i></span></a>
              
               </li>
               <!-- <li><a class="waves-effect waves-block waves-light sidenav-trigger" href="#"
                  data-target="slide-out-right"><i class="material-icons">format_indent_increase</i></a>
                  </li> -->
            </ul>
            <!-- translation-button-->
            <ul class="dropdown-content" id="translation-dropdown">
               <li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="en"><i
                  class="flag-icon flag-icon-gb"></i> English</a></li>
               <li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="fr"><i
                  class="flag-icon flag-icon-fr"></i> French</a></li>
               <li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="pt"><i
                  class="flag-icon flag-icon-pt"></i> Portuguese</a></li>
               <li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="de"><i
                  class="flag-icon flag-icon-de"></i> German</a></li>
            </ul>
            <!-- notifications-dropdown-->
            <!-- <ul class="dropdown-content" id="notifications-dropdown">
               <li>
                  <h6>NOTIFICATIONS<span class="new badge">5</span></h6>
               </li>
               <li class="divider"></li>
               <li><a class="black-text" href="#!"><span
                  class="material-icons icon-bg-circle cyan small">add_shopping_cart</span> A new
                  order has been placed!</a>
                  <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">2 hours
                  ago</time>
               </li>
               <li><a class="black-text" href="#!"><span
                  class="material-icons icon-bg-circle red small">stars</span> Completed the task</a>
                  <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">3 days
                  ago</time>
               </li>
               <li><a class="black-text" href="#!"><span
                  class="material-icons icon-bg-circle teal small">settings</span> Settings
                  updated</a>
                  <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">4 days
                  ago</time>
               </li>
               <li><a class="black-text" href="#!"><span
                  class="material-icons icon-bg-circle deep-orange small">today</span> Director
                  meeting started</a>
                  <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">6 days
                  ago</time>
               </li>
               <li><a class="black-text" href="#!"><span
                  class="material-icons icon-bg-circle amber small">trending_up</span> Generate
                  monthly report</a>
                  <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">1 week
                  ago</time>
               </li>
            </ul> -->
            <!-- profile-dropdown-->
            <ul class="dropdown-content" id="profile-dropdown">
               <li><a class="grey-text text-darken-1" href="<?= base_url('admin/dashboard/profile') ?>"><i
                  class="material-icons">person_outline</i> Profile</a></li>
               
               <li><a class="grey-text text-darken-1" href="<?= base_url('login/logout') ?>"><i
                  class="material-icons">keyboard_tab</i> Logout</a></li>
            </ul>
         </div>
         
      </nav>
   </div>
</header>