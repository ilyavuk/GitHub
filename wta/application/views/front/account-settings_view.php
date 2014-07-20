<div class="container">
<div class="sixteen columns signup">
<div class="seven columns offset-by-one omega">
<?php if($this->facebook_admin):?>
<h3><a href="<?=base_url()?>facebookAuth/f_logout">Log Out</a>
<?php if($this->venue_admin):?>
<a class="offset-by-one" href="<?=base_url()?>admin/">Admin</a>
<?php endif; ?>
</h3>
<form action="<?=base_url()?>account-settings/" method="post">
<p><label for="selected_cat:">Select Preferred Event Categories:</label></p>
<div class="category-next">
<?php foreach($selected_cat as $category): ?>
<p><input type="checkbox" name="selected_cat[]" value="<?=$category->id?>" <?=($category->is_selected)?'checked':false?> /><?=$category->category?></p>
<?php endforeach; ?>
</div>
<p class="submit"><input type="submit" name="submit_faccount_form" value="Update Account"><span class="clear"></span></p>
</form>
<?php endif; ?>
<?php if($this->twitter_admin):?>
<h3><a href="<?=base_url()?>twitter/t_logout">Log Out</a>
<?php if($this->venue_admin):?>
<a class="offset-by-one" href="<?=base_url()?>admin/">Admin</a>
<?php endif; ?>
</h3>
<form action="<?=base_url()?>account-settings/" method="post">
<p><label for="selected_cat:">Select Preferred Event Categories:</label></p>
<div class="category-next">
<?php foreach($selected_cat as $category): ?>
<p><input type="checkbox" name="selected_cat[]" value="<?=$category->id?>" <?=($category->is_selected)?'checked':false?> /><?=$category->category?></p>
<?php endforeach; ?>
</div>
<p class="submit"><input type="submit" name="submit_taccount_form" value="Update Account"><span class="clear"></span></p>
</form>
<?php endif; ?>
<?php if($this->logged_in):?>
<h3><a href="<?=base_url()?>logout/">Log Out</a><a class="offset-by-one" href="<?=base_url()?>admin/">Admin</a></h3>
   
   <form action="<?=base_url()?>account-settings/" method="post">
   
                        <div class="errors"><?php echo form_error('username'); ?></div>  
						<p><label for="Username">Username:</label>
							<input  type="text" id="username" name="username" value="<?=$user_data->username?>"></p>
                          
                          
                          
                         <div class="errors"><?php echo form_error('sex'); ?></div>    
						<p><label for="sex">I am<em>*</em></label>
							
                             <?php 
							  $options = array(
											  0  => 'Select Sex:',
											  1   => 'Female',
											  2 => 'Male',
											);
							echo form_dropdown('sex', $options, $user_data->sex);                          
                            
                            ?>                           
                            </p>                     
                        <div class="errors"><?php echo form_error('email'); ?></div>   
						<p><label for="email">Email:</label>
							<input  type="text" id="edt_email" name="email" value="<?=$user_data->email?>"></p>
                         <div class="errors"><?php echo form_error('first_name'); ?></div>                          
						<p><label for="first_name">First Name:</label>
							<input  type="text" id="edt_first_name" name="first_name" value="<?=$user_data->first_name?>"></p>
							
                        <div class="errors"><?php echo form_error('last_name'); ?></div>						
						<p><label for="last_name">Last Name:</label>
							<input  type="text" id="edt_last_name" name="last_name" value="<?=$user_data->last_name?>"></p>
                            
                         <div class="errors"><?php echo form_error('birthday'); ?></div>   
						<p><label for="birthday">Birthday:</label>
    				        <input  type="text" id="datepicker" name="birthday" value="<?=$user_data->birthday?>">  
						</p>
                        
                        
	                     <p><label for="timezone">Timezone</label>
                            <?=timezone_menu($user_data->timezones)?>
                         </p> 		
                         				
						<p><label for="mobile">Mobile:</label>
							<input  type="text" id="edt_mobile" name="mobile" value="<?=$user_data->mobile?>"></p>
						
                        <div class="errors"><?php echo form_error('town'); ?></div>	
						<p><label for="town">Town:</label>
							<input  type="text" id="edt_town" name="town" value="<?=$user_data->town?>"></p>

						
                        <div class="errors"><?php echo form_error('country'); ?></div>                     
                        <p><label for="country">Country:</label>
							<input  type="text" id="edt_country" name="country" value="<?=$user_data->country?>"></p>
							<?php
                            $data = array(
										  'id'  => $user_data->id,
										);
							echo form_hidden($data) ?>

							

                        <div class="errors"><?php echo form_error('new_password'); ?></div>
						<p><label for="new_Password">New Password</label>
							<input  type="password" id="new_Password" name="new_password" ></p>
                            
                            
                        <div class="errors"><?php echo form_error('confirm_password'); ?></div>
						<p><label for="confirm_Password:">Confirm Password:</label>
							<input  type="password" id="confirm_Password" name="confirm_password" ></p>
                            
                            
                         <p><label for="selected_cat:">Select Preferred Event Categories:</label></p>
                         <div class="category-next">
                        <?php foreach($selected_cat as $category): ?>
                        <p><input type="checkbox" name="selected_cat[]" value="<?=$category->id?>" <?=($category->is_selected)?'checked':false?> /><?=$category->category?></p>
                        <?php endforeach; ?>
                        </div>
                           

                     <p class="submit"><input type="submit" name="submit_account_form" value="Update Account"><span class="clear"></span></p>
 </form>
<?php endif; ?> 
</div>
<div class="seven columns offset-by-one alpha" >
<?php if($this->logged_in):?>
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
                	 var html = ''; 
					 var upImgNemExt = responseJSON['filename']+'.'+responseJSON['ext'];
					 $('#images_wrapper').html('<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/users_img/'+ upImgNemExt +'&w=150&aoe=1?x='+new Date().getTime()+'" />');
					 html +='<a href="<?=base_url()?>account-settings/" title="Account Settings">';
					 html +='<div class="avatar" style="background-image: url(\'<?=base_url()?>phpThumb/phpThumb.php?src=/assets/users_img/img_1.jpg&amp;w=60&amp;h=65&amp;zc=1&amp;aoe=1?x='+new Date().getTime()+'\');">';
					 html +='</div></a>';
			         $('.info_toggle').html(html);
			   
			    }
            });           
        }
        /* url_title: $('input[name="url_title"]').val() */
        // in your app create uploader as soon as the DOM is ready
        // don't wait for the window to load  
   
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
<?php endif; ?>                
                     
                            
   </div><div class="clear"></div>




</div>
</div>
<?php if($this->logged_in):?>
<script>
$(function() {
 createUploader(); 
});
</script>
<?php endif; ?>