

<footer class="mp-footer">
<div class="container">
   <div class="info">

      <div class="section brand">

         <div class="brand-logo"><img src="assets/img/logoSmart.jpg" alt=""></div>

       <p>

         smart school educated and leaner<br>

         enables easy collabration to<br>

         achieves their best which is why<br>

         trusted by thousand school.<br>

       </p>

      </div>

      <div class="section about">

         <div class="title">About</div>

         <div class="item"><a href="contact.php">Customer Support</a></div>

      </div>

      <div class="section business">

         <div class="title">For Schools &amp; Businesses</div>

         <div class="item"><a href="forschool.php">For schools</a></div>

         <div class="item"><a href="pricing.php">Pricing</a></div>

         <div class="item"><a href="contact.php">For partners</a></div>

         <div class="item"><a href="book13.php">Schedule a Demo</a></div>

      </div>

      <div class="section legal">

         <div class="title">Legal</div>

         <div class="item"><a href="terms.php">Terms of Service</a></div>

         <div class="item"><a href="privacy.php">Privacy policy</a></div>

      </div>

      <div class="section apps">

         <div class="title">Mobile app</div>

         <div class="item">

            <a href="" target="_blank" rel="noopener">

               <img src="assets/img/apple (1).png" alt="icon-apple">

               <div>

                  <div class="sub-text">Download on the</div>

                  <div class="text">App Store</div>

               </div>

            </a>

            <a href="" target="_blank" rel="noopener">

               <img src="assets/img/playstore.png" alt="icon-playstore">

               <div>

                  <div class="sub-text">Get it on</div>

                  <div class="text">Play Store</div>

               </div>

            </a>

         </div>

      </div>

   </div>
</div>
</footer>
<footer class="bt-footer">
   <div class="conatiner">
   	<div class="rights"> Copyright&nbsp;<span id="cur_year">2021</span>&nbsp;© Cloud Academy. All Rights Reserved. </div>
   </div>
</footer>

	

      <!-- jQuery library -->

      <script src="assets/js/jquery.min.js"></script>

      <!-- <script type="text/javascript" src="engine1/jquery.js"></script> -->

      <!-- Latest compiled JavaScript -->

      <script src="assets/js/bootstrap.min.js"></script>

	<script>

		$(window).scroll(function() {    

		    var scroll = $(window).scrollTop();



		    if (scroll >= 200) {

		        $(".mp-header").addClass("default");

		    } else {

		        $(".mp-header").removeClass("default");

		    }

		});

	</script>

	<script>

		$('.drop_menu').click(function(){

			$(this).toggleClass('active');

		});



		$('.nav_trigger').click(function(){

			$('.mobile .nav_list').addClass('active');

		});



		$('.mob-nav-close').click(function(){

			$('.mobile .nav_list').removeClass('active');

		});

	</script>
   <script>     
      $('.mt-md-0').click(function(){
         $(this).addClass('active').siblings().removeClass('active'); 
      });
   </script>

   </body>

</html>
				  