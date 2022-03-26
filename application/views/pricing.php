 <?php $this->load->view('header') ?>
 <div class="pricingbody">
 	<h3 class="title boldtitle">Pick your Plan</h3>

 	<div class="container">
 	<!--<div class="tab-slider--nav">-->
 	<!--		<ul class="tab-slider--tabs">-->
 	<!--			<li class="tab-slider--trigger active" rel="tab1">Monthly</li>-->
 	<!--			<li class="tab-slider--trigger" rel="tab2">Yearly</li>-->
 	<!--		</ul>-->
 	<!--	</div> -->
 		<div class="tab-slider--container">
 			 <div id="tab1" class="tab-slider--body" style="display: block;">
                        <div class=" homepricing-table">
                           <div class="table">
                                <?php 
                             
                             //print_r($listRecord);
                             
                             if (!empty($listRecord)) {
 							foreach ($listRecord as $key => $item) {
 							    $sendid = base64_encode($item->id);
 							    
 							?>
                             
                              <div class="options border1">
                                 <h2 class="main"><?= $item->title ?></h2>
                                 <h1 class="secondtitle st1-mr text-primary-head"><span class="lh70">£</span><span><?= $item->regular_price ?></span></h1>
                                 <p class="month">Per User / Month</p>
                                 <a href="https://door2doorsoftware.com/register/newuser/<?= $sendid ?>" class="waves-effect waves-light themebtn price3btn">Start Your Free Trial</a>
                                 <div class="border-margin"></div>
                                 <div class="feature-box">
                                    <ul>
                                       <div class="fir-col-box">
                                          
                                          <li class="has-tooltip top-menus">
                                             <i class="fa fa-check text-info li-left"></i>
                                             <span><b><?= $item->max_user ?> </b> No. of Customers</span>
                                          </li>
                                          <li class="has-tooltip top-menus">
                                             <i class="fa fa-check text-info li-left"></i>
                                             <span><b>0 </b> No. of SMS</span>
                                          </li>
                                       </div>
                                       <div class="border-margin"></div>
                                       <br>
                                        <li class="has-tooltip">
                                         <?php
                                         if($item->option_1=='1'){
                                         ?>
                                          <i class="fa fa-check text-warning li-left"></i>
                                         <?php }else{ ?>
                                         <i class="fa fa-times text-danger li-left"></i>
                                         <?php } ?>
                                          <span>Customer CRM</span>
                                       </li>
                                       <li class="has-tooltip">
                                         <?php
                                         if($item->option_2=='1'){
                                         ?>
                                          <i class="fa fa-check text-warning li-left"></i>
                                         <?php }else{ ?>
                                         <i class="fa fa-times text-danger li-left"></i>
                                         <?php } ?>
                                          <span>Bookings</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <?php
                                         if($item->option_3=='1'){
                                         ?>
                                          <i class="fa fa-check text-warning li-left"></i>
                                         <?php }else{ ?>
                                         <i class="fa fa-times text-danger li-left"></i>
                                         <?php } ?>
                                          <span>Driver Database</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <?php
                                         if($item->option_4=='1'){
                                         ?>
                                          <i class="fa fa-check text-warning li-left"></i>
                                         <?php }else{ ?>
                                         <i class="fa fa-times text-danger li-left"></i>
                                         <?php } ?>
                                          <span>Fleet Management</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <?php
                                         if($item->option_5=='1'){
                                         ?>
                                          <i class="fa fa-check text-warning li-left"></i>
                                         <?php }else{ ?>
                                         <i class="fa fa-times text-danger li-left"></i>
                                         <?php } ?>
                                          <span>Invoicing & Billing</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <?php
                                         if($item->option_6=='1'){
                                         ?>
                                          <i class="fa fa-check text-warning li-left"></i>
                                         <?php }else{ ?>
                                         <i class="fa fa-times text-danger li-left"></i>
                                         <?php } ?>
                                          <span>Bill of Laden</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <?php
                                         if($item->option_7=='1'){
                                         ?>
                                          <i class="fa fa-check text-warning li-left"></i>
                                         <?php }else{ ?>
                                         <i class="fa fa-times text-danger li-left"></i>
                                         <?php } ?>
                                          <span> <?php
                                         if($item->allow_van>0){
                                         ?><span style="color:#4dcfe9"><?=$item->allow_van?>  vans</span>
                                         <?php } ?>
                                         Fleet Tracking</span>
                                       </li>                                       
                                       <li class="has-tooltip">
                                          <?php
                                         if($item->option_8=='1'){
                                         ?>
                                          <i class="fa fa-check text-warning li-left"></i>
                                         <?php }else{ ?>
                                         <i class="fa fa-times text-danger li-left"></i>
                                         <?php } ?>
                                          <span>Customer Good Tracking</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <?php
                                         if($item->option_9=='1'){
                                         ?>
                                          <i class="fa fa-check text-warning li-left"></i>
                                         <?php }else{ ?>
                                         <i class="fa fa-times text-danger li-left"></i>
                                         <?php } ?>
                                          <span>Bluetooth Printer</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <?php
                                         if($item->option_10=='1'){
                                         ?>
                                          <i class="fa fa-check text-warning li-left"></i>
                                         <?php }else{ ?>
                                         <i class="fa fa-times text-danger li-left"></i>
                                         <?php } ?>
                                          <span>File Manager</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <?php
                                         if($item->option_11=='1'){
                                         ?>
                                          <i class="fa fa-check text-warning li-left"></i>
                                         <?php }else{ ?>
                                         <i class="fa fa-times text-danger li-left"></i>
                                         <?php } ?>
                                          <span>Accounts</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <?php
                                         if($item->option_12=='1'){
                                         ?>
                                          <i class="fa fa-check text-warning li-left"></i>
                                         <?php }else{ ?>
                                         <i class="fa fa-times text-danger li-left"></i>
                                         <?php } ?>
                                          <span>Reporting</span>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                             <?php } } ?>  
                              
                           </div>
                        </div>
                     </div>
                     <div id="tab2" class="tab-slider--body pricereg" style="display: none;">
                        <div class=" homepricing-table">
                           <div class="table">
                              <div class="options border1">
                                 <h2 class="main">Starter</h2>
                                 <h1 class="secondtitle st1-mr text-primary-head"><span class="lh70">£</span><span>49.99</span></h1>
                                 <p class="month">Per User / Year</p>
                                 <a href="https://cloudcrm.club/package-form/month/1" class="waves-effect waves-light themebtn price3btn">Start Your Free Trial</a>
                                 <div class="border-margin"></div>
                                 <div class="feature-box">
                                    <ul>
                                       <div class="fir-col-box">
                                          <li class="has-tooltip top-menus" style="display:none;">
                                             <i class="fa fa-check text-info li-left"></i>
                                             <span><b>2</b> Customers</span>
                                          </li>
                                          <li class="has-tooltip top-menus">
                                             <i class="fa fa-check text-info li-left"></i>
                                             <span><b>10 </b> No. of Customers</span>
                                          </li>
                                          <li class="has-tooltip top-menus">
                                             <i class="fa fa-check text-info li-left"></i>
                                             <span><b>0 </b> No. of SMS</span>
                                          </li>
                                       </div>
                                       <div class="border-margin"></div>
                                       <br>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Bookings</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Driver Database</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Fleet Management</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>Invoicing & Billing</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>Bill of Laden</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>Fleet Tracking</span>
                                       </li>                                       
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>Customer Good Tracking</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>Bluetooth Printer</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>File Manager</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>Accounts</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>Reporting</span>
                                       </li>
                                       
                                    </ul>
                                 </div>
                              </div>
                              <div class="options border1">
                                 <h2 class="main">Standard</h2>
                                 <h1 class="secondtitle st1-mr text-primary-head"><span class="lh70">£</span><span>99.99</span></h1>
                                 <p class="month">Per User / Year</p>
                                 <a href="https://cloudcrm.club/package-form/month/1" class="waves-effect waves-light themebtn price3btn">Start Your Free Trial</a>
                                 <div class="border-margin"></div>
                                 <div class="feature-box">
                                    <ul>
                                       <div class="fir-col-box">
                                          <li class="has-tooltip top-menus" style="display:none;">
                                             <i class="fa fa-check text-info li-left"></i>
                                             <span><b>2</b> Customers</span>
                                          </li>
                                          <li class="has-tooltip top-menus">
                                             <i class="fa fa-check text-info li-left"></i>
                                             <span><b>50 </b> No. of Customers</span>
                                          </li>
                                          <li class="has-tooltip top-menus">
                                             <i class="fa fa-check text-info li-left"></i>
                                             <span><b>0 </b> No. of SMS</span>
                                          </li>
                                       </div>
                                       <div class="border-margin"></div>
                                       <br>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Bookings</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Driver Database</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Fleet Management</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Invoicing & Billing</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Bill of Laden</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>Fleet Tracking</span>
                                       </li>                                       
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>Customer Good Tracking</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>Bluetooth Printer</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>File Manager</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>Accounts</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>Reporting</span>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                              <div class="options border1">
                                 <h2 class="main">Business</h2>
                                 <h1 class="secondtitle st1-mr text-primary-head"><span class="lh70">£</span><span>199.99</span></h1>
                                 <p class="month">Per User / Year</p>
                                 <a href="https://cloudcrm.club/package-form/month/2" class="waves-effect waves-light themebtn price3btn">Start Your Free Trial</a>
                                 <div class="border-margin"></div>
                                 <div class="feature-box">
                                    <ul>
                                       <div class="fir-col-box">
                                          <li class="has-tooltip top-menus" style="display:none;">
                                             <i class="fa fa-check text-info li-left"></i>
                                             <span><b>2</b> Customers</span>
                                          </li>
                                          <li class="has-tooltip top-menus">
                                             <i class="fa fa-check text-info li-left"></i>
                                             <span><b>100 </b> No. of Customers</span>
                                          </li>
                                          <li class="has-tooltip top-menus">
                                             <i class="fa fa-check text-info li-left"></i>
                                             <span><b>0 </b> No. of SMS</span>
                                          </li>
                                       </div>
                                       <div class="border-margin"></div>
                                       <br>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Bookings</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Driver Database</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Fleet Management</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Invoicing & Billing</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Bill of Laden</span>
                                       </li>
                                       <li class="has-tooltip">
                                          
                                          <span><span style="color:#4dcfe9">2  vans</span> Fleet Tracking</span>
                                       </li>                                       
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Customer Good Tracking</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Bluetooth Printer</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>File Manager</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>Accounts</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-times text-danger li-left"></i>
                                          <span>Reporting</span>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                              <div class="options border1">
                                 <h2 class="main">Business Pro</h2>
                                 <h1 class="secondtitle st1-mr text-primary-head"><span class="lh70">£</span><span>299.99</span></h1>
                                 <p class="month">Per User / Year</p>
                                 <a href="https://cloudcrm.club/package-form/month/3" class="waves-effect waves-light themebtn price3btn">Start Your Free Trial</a>
                                 <div class="border-margin"></div>
                                 <div class="feature-box">
                                   <ul>
                                       <div class="fir-col-box">
                                          <li class="has-tooltip top-menus" style="display:none;">
                                             <i class="fa fa-check text-info li-left"></i>
                                             <span><b>2</b> Customers</span>
                                          </li>
                                          <li class="has-tooltip top-menus">
                                             <i class="fa fa-check text-info li-left"></i>
                                             <span><b>200+ </b> No. of Customers</span>
                                          </li>
                                          <li class="has-tooltip top-menus">
                                             <i class="fa fa-check text-info li-left"></i>
                                             <span><b>0 </b> No. of SMS</span>
                                          </li>
                                       </div>
                                       <div class="border-margin"></div>
                                       <br>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Bookings</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Driver Database</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Fleet Management</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Invoicing & Billing</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Bill of Laden</span>
                                       </li>
                                       <li class="has-tooltip">
                                          
                                          <span><span style="color:#4dcfe9">10  vans</span> Fleet Tracking</span>
                                       </li>                                       
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Customer Good Tracking</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Bluetooth Printer</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>File Manager</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Accounts</span>
                                       </li>
                                       <li class="has-tooltip">
                                          <i class="fa fa-check text-warning li-left"></i>
                                          <span>Reporting</span>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
 		</div>
 	</div> 
 </div> 
 <?php $this->load->view('footer') ?>  
 <style>
		.pricingbody {
		  background-color: #FAF6FF;
		  padding-top: 150px;
		}
		.pricingbody .title {
		  font-size: 48px;
		  text-align: center;
		  color: #29293a;
		  margin-bottom: 40px;
		}
		.pricingtable .table {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  padding: 20px 150px;
  text-align: center;
}
.homepricingbody{
  background-color: #e5ebf1;
    padding-top: 25px;
    padding-bottom: 25px;
    margin-bottom: 50px;

}
.homepricing-table .table {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  padding: 0;
  text-align: center;
}
.homepricing-table .table .options{
  -ms-flex-preferred-size: 45%;
      flex-basis: 45%;
  background-color: #fff;
  border-radius: 10px;
  margin: 10px;
  padding: 20px 10px 30px;
  -webkit-transition: all .35s ease-in-out;
  transition: all .35s ease-in-out;
  position: relative;
}
.homepricing-table .table .border1{
  border-radius: unset;
  border:1px solid #e3e3e3;
}
.homepricing-table .table .border3{
  border:1px dashed  #000;
  position: relative;
}
.homepricing-table .table .border3 .absolute-task{
  background: #c266d0;
    padding: 5px 10px;
    font-size: 12px;
    font-weight: 600;
    color: #000;
    border-radius: 16px;
    border-top-left-radius: 0;
    position: absolute;
    right: -10px;
    top: 6px;
}

.homepricing-table .table .options .themebtn {
  display: block;
  text-align: center;
  width: -webkit-fit-content;
  width: -moz-fit-content;
  width: fit-content;
}
.homepricing-table .table .options .main {
  color: #2b3238;
  font-family: "Roboto", Sans-serif;
  font-size: 18px;
  font-weight: 600;
  text-transform: uppercase;
  font-style: normal;
  text-decoration: none;
  line-height: 22px;
  letter-spacing: 0.5px;
  margin: 30px 0px 15px;
}
.homepricing-table .table .options .secondtitle {
  font-size: 15px;
  margin: 0px 0px 0px;
}
.homepricing-table .table .options .st1-mr{
  margin-bottom: 51px;
}
.homepricing-table .table .options .text-primary-head{
  color: #38b1d8;
}
.homepricing-table .table .options .secondtitle span {
  font-family: "Roboto", Sans-serif;
  font-size:50px;
  font-weight: bolder;
  text-transform: lowercase;
  font-style: normal;
  text-decoration: none;
  line-height: 55px;
  letter-spacing: 0px;
 
  padding-bottom: 0px;
}
.homepricing-table .table .border-margin{

  height: 1px;
  width: 100%;
  background-color: #e3e3e3;
  margin-top: 20px;
  margin-bottom: 10px;
}
.homepricing-table .table .themebtn{
  font-size: 15px;
  text-transform: uppercase;
  margin: 0px auto;
  margin-bottom: 30px;
}
.price3btn{
      background-image: -webkit-gradient(linear, right top, left top, from(#38b1d8), to(#38b1d8));
    background-image: linear-gradient(-90deg, #38b1d8, #38b1d8);

}
.feature-box{
  text-align: left;
}

.feature-box ul li {
    font-size: 14px;
    padding: 0 4px;
    margin-bottom: 15px;
    position: relative;
}
.feature-box .fir-col-box{
  padding-bottom: 22px;
}

.feature-box ul li .borderdot{
  border-bottom: 1px dotted #e3e3e3;
  cursor: pointer;
}
.pricingbody .title {
    font-size: 48px;
    text-align: center;
    color: #29293a;
    margin-bottom: 40px;
}
.boldtitle {
    font-weight: 700;
    font-size: 40px;
}
.pricingbody .tab-slider--nav {
    width: -webkit-fit-content;
    width: -moz-fit-content;
    width: fit-content;
    margin: 20px auto 50px;
    text-align: center;
}
.pricingbody .tab-slider--tabs {
    display: block;
    margin: 0;
    padding: 0;
    list-style: none;
    position: relative;
    border-radius: 35px;
    overflow: hidden;
    background: #fff;
    height: 35px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.pricingbody .active#month,  .pricingbody .active#year{
    color: #fff;
    background-image: linear-gradient(
120deg, #38b1d8, #CA62D0);
    height: 100%;
    -webkit-transition: all 250ms ease-in-out;
    transition: all 250ms ease-in-out;
    border-radius: 35px;
}
.pricingbody .tab-slider--trigger {
    font-size: 12px;
    line-height: 1;
    font-weight: bold;
    color: #777;
    text-transform: uppercase;
    text-align: center;
    padding: 11px 20px;
    position: relative;
    z-index: 1;
    cursor: pointer;
    display: inline-block;
    -webkit-transition: color 250ms ease-in-out;
    transition: color 250ms ease-in-out;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
/*.pricingbody .active#month:after, .pricingbody .active#year:after {
    content: "";
    width: 100%;
    background-image: linear-gradient(
120deg, #38b1d8, #CA62D0);
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    -webkit-transition: all 250ms ease-in-out;
    transition: all 250ms ease-in-out;
    border-radius: 35px;
}*/
.homepricing-table .table .options .themebtn {
    display: block;
    text-align: center;
    width: -webkit-fit-content;
    width: -moz-fit-content;
    width: fit-content;
}
.homepricing-table .table .themebtn {
    font-size: 15px;
    text-transform: uppercase;
    margin: 0px auto;
    margin-bottom: 30px;
}
.price3btn {
    background-image: -webkit-gradient(linear, right top, left top, from(#38b1d8), to(#38b1d8));
    background-image: linear-gradient(
-90deg, #38b1d8, #38b1d8);
}
.themebtn {
    margin: 40px auto auto;
    background-color: #38b1d8;
    border: 0px solid #38b1d8;
    color: #fff;
    padding: 11px 35px;
    border-radius: 4px;
    -webkit-transition: 0.4s;
    transition: 0.4s;
    font-size: 18px;
    letter-spacing: 0.3px;
    font-weight: 600;
    background-image: -webkit-gradient(linear, left top, right top, from(#38b1d8), to(#CA62D0));
    background-image: linear-gradient(
90deg, #38b1d8, #CA62D0);
}
.text-info, .li-left {
    color: #4dcfe9;
}
.feature-box ul li {
    font-size: 16px;
    padding: 0 4px;
    margin-bottom: 15px;
    position: relative;
}
.feature-box .fir-col-box {
    padding-bottom: 22px;
}
.text-danger{
	color: #ff0000!important;
}
@media (max-width: 720px)
{
	.homepricing-table .table {
    display: -webkit-block;
    display: -ms-block;
    display: block;
}
.pricingbody .title {
    font-size: 22px;
}
}
	</style>
</body>
</html>			
