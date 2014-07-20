  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2><?=$user_data->username?></h2>
    <p id="page-intro"><?=$user_data->username?></p>
    
    <div class="content-box"><!-- Start Content Box -->
      
      <div class="content-box-header">
        <h3></h3>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
         
		 <?php if(isset($successfully)):?>
	      <div class="notification success png_bg"> <a href="#" class="close"><img src="<?=base_url()?>assets/img/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div> Successfully updated! </div>
          </div>
		<?php endif;?>
         <?php if(isset($errornotification)):?>
	      <div class="notification error png_bg"> <a href="#" class="close"><img src="<?=base_url()?>assets/img/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div> Error! </div>
          </div>
		<?php endif;?>      
          <form action="<?=base_url()?>admin/users/edit/<?=$user_data->id?>" method="post">
            <fieldset>
              <p>
                <label for="Username">Username: <em>*</em></label>
                <input class="text-input small-input" type="text" id="username" name="username" value="<?=$user_data->username?>" />
                <?php if(form_error('username')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('username')?></span> 
                <?php endif; ?>
              </p>
              <p>
                <label for="email">Email: <em>*</em></label>
                <input class="text-input small-input" type="text" id="email" name="email" value="<?=$user_data->email?>" />
                <?php if(form_error('email')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('email')?></span> 
                <?php endif; ?>
              </p>            
               <p>
                <label for="first_name">First Name: <em>*</em></label>
                <input class="text-input small-input" type="text" id="first_name" name="first_name" value="<?=$user_data->first_name?>" />
                <?php if(form_error('first_name')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('first_name')?></span> 
                <?php endif; ?>
              </p>              
              <p>
                <label for="last_name">Last Name: <em>*</em></label>
                <input class="text-input small-input" type="text" id="last_name" name="last_name" value="<?=$user_data->last_name?>" />
                <?php if(form_error('last_name')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('last_name')?></span> 
                <?php endif; ?>
              </p>   
              <p>
                <label for="birthday">Birthday: <em>*</em></label>
                <input class="text-input small-input" type="text" id="birthday" name="birthday" value="<?=$user_data->birthday?>" />
              </p>                       
               <p>
                <label for="mobile">Mobile:</label>
                <input class="text-input small-input" type="text" id="mobile" name="mobile" value="<?=$user_data->mobile?>" />
              </p>             
               <p>
                <label for="town">Town: <em>*</em></label>
                <input class="text-input small-input" type="text" id="town" name="town" value="<?=$user_data->town?>" />
                <?php if(form_error('town')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('town')?></span> 
                <?php endif; ?>
              </p>     
              <p>
                <label for="country">Country: <em>*</em></label>
                <input class="text-input small-input" type="text" id="country" name="country" value="<?=$user_data->country?>" />
                <?php if(form_error('country')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('country')?></span> 
                <?php endif; ?>
              </p>             
              <p>
                <label for="new_password">New Password: <em>*</em></label>
                <input class="text-input small-input" type="password" id="new_password" name="new_password"  />
                <?php if(form_error('new_password')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('new_password')?></span> 
                <?php endif; ?>
              </p>             
              <p>
                <label for="confirm_password">Confirm Password: <em>*</em></label>
                <input class="text-input small-input" type="password" id="confirm_password" name="confirm_password" />
                <?php if(form_error('confirm_password')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('confirm_password')?></span> 
                <?php endif; ?>
              </p>            
              <p>
                <label for="is_admin">Type of user:</label>
				<?php
                $options = array(
                      0    => 'Website Visitor',
                      1    => 'Registered User',
                      2    => 'Venue Admin',
                      3    => 'Master Admin',
                    );
                 echo form_dropdown('is_admin', $options,$user_data->is_admin,'class="small-input"');
                ?>               
                
              </p> 
				<?php
                $data = array(
                              'id'  => $user_data->id,

                            );
                echo form_hidden($data); 
                  if($user_data->is_admin == 2 ){ 
				    echo '<p><label for="venue_id">Select venue for user:</label>';              
                    $position = array();
                    $position[''] = 'Venue..';
                    foreach($venues as $venue) {
                        $position[$venue->id] = $venue->place;
                    }
                    echo form_dropdown('venue_id', $position ,$user_data->venue_id, 'class="small-input"');
					echo '</p>';
				  }
			   
			   
			    ?>  
               <p><label for="block_users:">Blocked:</label>
				  <input type="checkbox" name="block_users" value="1"  <?=($user_data->block_users != 1)?'checked="checked"':false?> />✔</p>         
               <p>
                <input class="button" name="submit_user_form" type="submit" value="Submit" />
              </p>                                 
            </fieldset>
            <div class="clear"></div>
            <!-- End .clear -->
            
          </form>
        </div>
        <!-- End #tab2 --> 
        

      

 <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->   

<div id="picture_profile">
<div class="content">
	
	<!-- upload form -->
		<form id="property_images_form">
		<b>Image should be JPEG (.jpg)</b><br />
		<i>Firefox and Chrome users can drag & drop image file below</i><br /><br />
		<div id="file-uploader">		
			<noscript>			
				<p>Please enable JavaScript to use file uploader.</p>
			</noscript>         
		</div>
		</form>		
		<script type="text/javascript">
        function createUploader(){            
            var uploader = new qq.FileUploader({
                element: $('#file-uploader')[0],
                action: '<?=base_url('ajax/upload_admin_image')?>',
                debug: false,
                allowedExtensions: ['jpg'],
                onSubmit: function() {
                	uploader.setParams({
                		property_id: <?=$user_data->id?>
                	});
                },
                onComplete: function(id, fileName, responseJSON){
				   var upImgNemExt = responseJSON['filename']+'.'+responseJSON['ext'];
                   $('#images_wrapper').html('<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/users_img/'+ upImgNemExt +'&w=150&aoe=1?x='+new Date().getTime()+ '" />');
                }
            });           
        }
        /* url_title: $('input[name="url_title"]').val() */
        // in your app create uploader as soon as the DOM is ready
        // don't wait for the window to load  
        window.onload = createUploader();     
    </script>  
	
	<div id="images_wrapper">
         <?php if(isset($user_data->img)):?>
                  <img src="<?=base_url().'phpThumb/phpThumb.php?src=/assets/users_img/'. $user_data->img .'&w=150&aoe=1' ?>" />
         <?php else: ?>
                  <img src="<?=base_url().'phpThumb/phpThumb.php?src=/assets/users_img/admin.jpg&w=150&aoe=1'  ?>" />
         <?php endif; ?>
	</div>
<!-- end upload image -->

</div><!-- close content -->


</div>   


  
 <!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->   
   </div>
      <!-- End .content-box-content --> 
   
    </div>

    <!-- End .content-box -->
    
    <div class="clear"></div>
