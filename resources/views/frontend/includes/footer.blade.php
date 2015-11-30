<?php
$about_us = $return_policy = $terms = $privacy ='';

  if($getHelper->getCmsLink(1) !='')
  {
    $getcms_about_us = $getHelper->getCmsLink(1);
    $about_us = $getcms_about_us->slug;
  }
  if($getHelper->getCmsLink(2) !='')
  {
    $getcms_ret_policy = $getHelper->getCmsLink(2);
    $return_policy = $getcms_ret_policy->slug;
  }
  if($getHelper->getCmsLink(3) !='' && (!Session::has('brand_userid')))
  {
    $getcms_terms = $getHelper->getCmsLink(3);
    $terms = $getcms_terms->slug;
  }
  if($getHelper->getCmsLink(4) !='')
  {
    $getcms_privacy = $getHelper->getCmsLink(4);
    $privacy = $getcms_privacy->slug;
  }
  
  if(Session::has('brand_userid'))
  {
    $terms = url().'/miramixTc.pdf';
  }

?>

<!-- Start Footer Section -->    
    <footer>
      <div class="container">
        
        <!-- .row -->
		<div class="row top_footer">
        	<h2>Join Us</h2>
            <ul class="social-icons">
            	<li><a href="<?php echo  $all_sitesetting['facebook_link']; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <li><a href="<?php echo  $all_sitesetting['twitter_link']; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <li><a href="<?php echo  $all_sitesetting['instagram_link']; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
            </ul>
        </div>
        <div class="row bottom_footer">
        	<ul>
            	<li><a href="<?php echo url()?>/inventory">Inventory </a></li>
                <li><a href="<?php echo url();?>/brand">Brands</a></li>
                <li><a href="<?php echo url();?>/faq-list">FAQs</a></li>
                <li><a href="<?php echo url().($about_us!='')?$about_us:'#'?>">About Us</a></li>
                <li><a href="<?php echo url().($return_policy!='')?$return_policy:'#'?>">Return Policy</a></li> 
                <li><a href="<?php echo url()?>/contact-us">Contact Us</a></li>
		<?php if(!(Session::has('brand_userid')))
		{
		?>
                <li><a href="<?php echo url().($terms!='')?$terms:'#'?>">Terms And Conditions </a></li>
		<?php
		}
		else
		{
		
		?>
		<li><a href="<?php echo ($terms!='')?$terms:'#'?>" target="_blank">Terms And Conditions </a></li>
		<?php
		}
		?>
                <li><a href="<?php echo url().($privacy!='')?$privacy:'#'?>">Privacy Policy</a></li>
            </ul>
            <ul>
                <li>Copyright <?php echo date('Y', strtotime('-1 year')).'-'.date('Y');?> Miramix Incorporated.</li>
            </ul>
		</div>
      </div>
    </footer>
    <!-- End Footer Section -->


  </div>
  <!-- End Full Body Container -->

  <!-- Go To Top Link -->
  <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

  <div id="loader">
    <div class="spinner">
      <div class="dot1"></div>
      <div class="dot2"></div>
    </div>
  </div>


    <script type="text/javascript">
                (function () {
                    var head = document.getElementsByTagName("head").item(0);
                    var script = document.createElement("script");
                    var src = (document.location.protocol == 'https:' ?'https://www.formilla.com/scripts/feedback.js' : 'http://www.formilla.com/scripts/feedback.js');
                    script.setAttribute("type", "text/javascript"); script.setAttribute("src", src); script.setAttribute("async", true);
                    var complete = false;
                    script.onload = script.onreadystatechange = function () {
                        if (!complete && (!this.readyState || this.readyState == 'loaded' || 

this.readyState == 'complete')) {
                            complete = true;
                            Formilla.guid = '8c4509df-5d68-498b-ac52-dca67dcc74c8';
                            Formilla.loadFormillaChatButton();
                        }
                    };

                    head.appendChild(script);
                })();
            </script>


  <script type="text/javascript" src="<?php echo url();?>/public/frontend/js/script.js"></script>
    <script src="<?php echo url();?>/public/frontend/js/wow.min.js"></script>
    <script src="<?php echo url();?>/public/frontend/js/main.js"></script>

</body>

</html>

