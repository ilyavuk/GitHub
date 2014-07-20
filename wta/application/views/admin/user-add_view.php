  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2>Add new user</h2>
    <p id="page-intro">Users</p>
    
    <div class="content-box"><!-- Start Content Box -->
      
      <div class="content-box-header">
        <h3></h3>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
        <?php if(isset($adding_user_error)):?>
	      <div class="notification error png_bg"> <a href="#" class="close"><img src="<?=base_url()?>assets/img/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div> The following errors occurred! </div>
          </div>
		<?php endif;?>
          <form action="<?=base_url()?>admin/users/insert/" method="post">
            <fieldset>
              <p>
                <label for="Username">Username: <em>*</em></label>
                <input class="text-input small-input" type="text" id="username" name="username" value="<?=set_value('username')?>" />
                <?php if(form_error('username')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('username')?></span> 
                <?php endif; ?>
              </p>
              <p>
                <label for="email">Email: <em>*</em></label>
                <input class="text-input small-input" type="text" id="email" name="email" value="<?=set_value('email')?>" />
                <?php if(form_error('email')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('email')?></span> 
                <?php endif; ?>
              </p>            
               <p>
                <label for="first_name">First Name: <em>*</em></label>
                <input class="text-input small-input" type="text" id="first_name" name="first_name" value="<?=set_value('first_name')?>" />
                <?php if(form_error('first_name')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('first_name')?></span> 
                <?php endif; ?>
              </p>              
              <p>
                <label for="last_name">Last Name: <em>*</em></label>
                <input class="text-input small-input" type="text" id="last_name" name="last_name" value="<?=set_value('last_name')?>" />
                <?php if(form_error('last_name')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('last_name')?></span> 
                <?php endif; ?>
              </p>             
               <p>
                <label for="mobile">Mobile:</label>
                <input class="text-input small-input" type="text" id="mobile" name="mobile" value="<?=set_value('mobile')?>" />
              </p>             

               <p>
                <label for="town">Town: <em>*</em></label>
                <input class="text-input small-input" type="text" id="town" name="town" value="<?=set_value('town')?>" />
                <?php if(form_error('town')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('town')?></span> 
                <?php endif; ?>
              </p>     
              <p>
                <label for="country">Country: <em>*</em></label>
                <input class="text-input small-input" type="text" id="country" name="country" value="<?=set_value('country')?>" />
                <?php if(form_error('country')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('country')?></span> 
                <?php endif; ?>
              </p>             
              <p>
                <label for="password">Password: <em>*</em></label>
                <input class="text-input small-input" type="password" id="password" name="password"  />
                <?php if(form_error('password')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('password')?></span> 
                <?php endif; ?>
              </p>             
              <p>
                <label for="confirm_Password">Confirm Password: <em>*</em></label>
                <input class="text-input small-input" type="password" id="confirm_Password" name="confirm_password" />
                <?php if(form_error('confirm_Password')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('confirm_Password')?></span> 
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
                 echo form_dropdown('is_admin', $options,1,'class="small-input"');
                ?>               
                
              </p>           
              <p>
                <input class="button" name="submit_user_form" type="submit" value="Submit" />
              </p>                                 
            </fieldset>
            <div class="clear"></div>
            <!-- End .clear -->
            
          </form>
        </div>
        <!-- End #tab2 --> 
        
      </div>
      <!-- End .content-box-content --> 
      
    </div>
    <!-- End .content-box -->
    

    

    <!-- End .content-box -->
    
    <div class="clear"></div>
    

