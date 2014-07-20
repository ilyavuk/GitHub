 <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2>Log in</h2>
    <p id="page-intro"></p>
    
    <div class="content-box"><!-- Start Content Box -->
      
      <div class="content-box-header">
        <h3>Content box</h3>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">	
		
         <?php if(isset($error_loggin)):?>
	      <div class="notification error png_bg"> <a href="#" class="close"><img src="<?=base_url()?>assets/img/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div> Incorrect combination email/password </div>
          </div>
	   	<?php endif;?>          
        
			<form action="<?=base_url()?>admin" method="post" name="form" >
			<p><label for="name">Username</label>
			<input  class="text-input small-input" name="username" type="text" /></p>
			<p><label for="password">Password</label>
			<input class="text-input small-input" name="password" type="password" /></p>
			<p><input  class="button" name="submit" class="button" type="submit" value="Submit" /></p>
			</form>        

        </div>
        <!-- End #tab2 --> 
        
      </div>
      <!-- End .content-box-content --> 
      
    </div>
    <!-- End .content-box -->
    

    

    <!-- End .content-box -->
    
    <div class="clear"></div>