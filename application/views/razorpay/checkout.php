 <?php $this->load->view('header') ;
$userDetasils = getLoginUser();
$productinfo =  $item->short_description;
$txnid = time();
$surl = $surl;
$furl = $furl;        
$key_id = RAZOR_KEY_ID;
$RAZOR_CURENCY_CODE = RAZOR_CURENCY_CODE;
$currency_code = $currency_code;            
$total = ( $item->offer_price* 100); 
$amount =  $item->offer_price;
$merchant_order_id =  $item->id;
$card_holder_name = $userDetails['first_name'].' '.$userDetails['last_name'];
$password = $userDetails['password'];
$email = $userDetails['email'];
$phone = $userDetails['phone'];
$username = $userDetails['username'];
$name = APPLICATION_NAME;
$return_url = site_url().'razorpay/callback';
 ?>
 <div class="pricingbody">
 	<h3 class="title boldtitle">Payment Confirmation</h3>

 	<div class="container">
 		<form name="razorpay-form" id="razorpay-form" action="<?php echo $return_url; ?>" method="POST">
		    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
		    <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>"/>
        <input type="hidden" name="merchant_password" id="merchant_password" value="<?php echo $password; ?>"/>
        <input type="hidden" name="merchant_phone" id="merchant_phone" value="<?php echo $phone; ?>"/>
        <input type="hidden" name="merchant_email" id="merchant_email" value="<?php echo $email; ?>"/>
        <input type="hidden" name="merchant_username" id="merchant_username" value="<?php echo $username; ?>"/>
        <input type="hidden" name="merchant_fullname" id="merchant_fullname" value="<?php echo $card_holder_name; ?>"/>
		    <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>
		    <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="<?php echo $productinfo; ?>"/>
		    <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>
		    <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl; ?>"/>
		    <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="<?php echo $card_holder_name; ?>"/>
		    <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>"/>
		    <input type="hidden" name="merchant_amount" id="merchant_amount" value="<?php echo $amount; ?>"/>
		</form>
 		<!-- <div class="tab-slider--nav">
 			<ul class="tab-slider--tabs">
 				<li class="tab-slider--trigger active" rel="tab1">Billed Annually</li>
 				<li class="tab-slider--trigger" rel="tab2">Billed Monthly</li>
 			</ul>
 		</div> -->

 		<div class="tab-slider--container">
 			<div id="tab1" class="tab-slider--body"> 
 				<div class="pricingtable">
 					<div class="table container"> 
						<center>
							<div class="options z-depth-6">
							<h2 class="main"><?= $item->title ?></h2>
							<p><?= $item->short_description ?></p>
							<h1 class="secondtitle">Amount to pay: <span class="lh70"><?= ucfirst(RAZORCURRENCY) ?></span><span><?= $item->offer_price ?></span></h1>
							<p class="month">Maximum User allowed : <?= $item->max_user ?></p>
							<div class="row">
						        <div class="col-lg-12 text-right">
						            <a href="<?= base_url('pricing');?>" name="reset_add_emp" id="re-submit-emp" class="btn btn-warning"><i class="fa fa-mail-reply"></i> Back</a>
						            <input  id="submit-pay" type="button" onclick="razorpaySubmit(this);" value="Pay Now" class="btn btn-primary" />
						        </div>
						    </div>
							</div>
						</center> 
 					</div>
 				</div>
 			</div> 
 		</div>
 	</div> 
 </div> 
 <?php $this->load->view('footer') ?>  
 <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  var razorpay_options = {
    key: "<?php echo $key_id; ?>",
    amount: "<?php echo $total; ?>",
    name: "<?php echo $name; ?>",
    description: "Order # <?php echo $merchant_order_id; ?>",
    netbanking: true,
    currency: "<?php echo $currency_code; ?>",
    prefill: {
      name:"<?php echo $card_holder_name; ?>",
      email: "<?php echo $email; ?>",
      contact: "<?php echo $phone; ?>"
    },
    notes: {
      soolegal_order_id: "<?php echo $merchant_order_id; ?>",
    },
    handler: function (transaction) {
        document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
        document.getElementById('razorpay-form').submit();
    },
    "modal": {
        "ondismiss": function(){
            window.location.href="<?= base_url('pricing') ?>"
        }
    }
  };
  var razorpay_submit_btn, razorpay_instance;
 
  function razorpaySubmit(el){
    if(typeof Razorpay == 'undefined'){
      setTimeout(razorpaySubmit, 200);
      if(!razorpay_submit_btn && el){
        razorpay_submit_btn = el;
        el.disabled = true;
        el.value = 'Please wait...';  
      }
    } else {
      if(!razorpay_instance){
        razorpay_instance = new Razorpay(razorpay_options);
        if(razorpay_submit_btn){
          razorpay_submit_btn.disabled = false;
          razorpay_submit_btn.value = "Pay Now";
        }
      }
      razorpay_instance.open();
    }
  }  
</script>
</body>
</html>			
