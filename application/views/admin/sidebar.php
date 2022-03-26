<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-dark sidenav-active-rounded">
   <div class="brand-sidebar">
      <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="<?= base_url('admin') ?>"> 
          <?php $logoImage = check_row('tbl_setting',array('id'=>1)) ;
            if (!empty($logoImage) && !empty($logoImage->logo_image)) { ?>
                 <img src="<?= base_url($logoImage->image_path.'/'.$logoImage->logo_image) ?>" height="70" width="100"> 
            <?php 
            }else{ 
            ?>
              <img src="<?= base_url('assets/admin/images/logo.png') ?>"><span class="logo-text hide-on-med-and-down">Door2Door CRM</span>
            <?php } ?> 
       
        </a><a class="navbar-toggler" href="#"><i
         class="material-icons">radio_button_checked</i></a></h1>
   </div>
   
   <?php
$urls = $this->uri->uri_string();
$newurl = explode('/', $urls);
$active_url1 = $newurl[1];


$active_url2 = $newurl[2];

if($active_url2==''){
 $active_url = $newurl[1];   
}else{
 $active_url = $newurl[2];   
}


?>
   
   <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out"
      data-menu="menu-navigation" data-collapsible="accordion">
      <li class="<?php if($active_url == 'dashboard') { echo 'active'; } ?> bold"><a class="waves-effect waves-cyan " href="<?= base_url('admin') ?>">
        <i class="fas fa-home"></i>
        <span class="menu-title"
         data-i18n="Dashboard">Dashboard</span></a>
      </li>

      <li class="<?php if($active_url == 'packages') { echo 'active'; } ?> bold"><a class="waves-effect waves-cyan " href="<?= base_url('admin/packages')?>">
        <i class="fas fa-book"></i>
        <span class="menu-title"
         data-i18n="Dashboard">Packages</span></a>
      </li>

      <li class="<?php if($active_url == 'companies') { echo 'active'; } ?> bold"><a class="waves-effect waves-cyan " href="<?= base_url('admin/companies')?>">
        <i class="fas fa-building"></i>
        <span class="menu-title"
         data-i18n="Dashboard">Companies </span></a>
      </li>
      
      <li class="<?php if($active_url == 'drivers') { echo 'active'; } ?> bold"><a class="waves-effect waves-cyan " href="<?= base_url('admin/drivers')?>">
        <i class="fas fa-car"></i>
        <span class="menu-title"
         data-i18n="Dashboard">Drivers </span></a>
      </li>

      <li class="bold"><a class="waves-effect waves-cyan " href="<?= base_url('admin/payment/invoice')?>">
        <i class="fas fa-file"></i>
        <span class="menu-title"
         data-i18n="Dashboard">Invoices</span></a>
      </li>

      <li class="<?php if($active_url == 'payment') { echo 'active'; } ?> bold"><a class="waves-effect waves-cyan " href="<?= base_url('admin/payment')?>">
        <i class="fas fa-dollar-sign"></i>
        <span class="menu-title"
         data-i18n="Dashboard">Payment Gateway</span></a>
      </li>
      <!--<li class="<?php if($active_url == 'wallet') { echo 'active'; } ?> bold"><a class="waves-effect waves-cyan " href="<?= base_url('admin/wallet')?>">
        <i class="fas fa-credit-card"></i>
        <span class="menu-title"
         data-i18n="Dashboard">Wallet</span></a>
      </li>-->

      <li class="<?php if($active_url == 'setting') { echo 'active'; } ?> bold"><a class="waves-effect waves-cyan " href="<?= base_url('admin/setting')?>">
        <i class="fas fa-cog"></i>
        <span class="menu-title"
         data-i18n="Dashboard">Settings</span></a>
      </li>


   </ul>
   <div class="navigation-background"></div>
   <a
      class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only"
      href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>