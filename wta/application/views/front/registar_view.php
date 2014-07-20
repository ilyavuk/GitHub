<script>	
    $(function() {

		$( "#datepicker" ).datepicker({

			changeMonth: true,

			changeYear: true,

			yearRange: "1900:2012" 

		});

	});
</script>
<div class="container">
<?php if(!isset($next)): ?>
 <div class="sixteen columns signup">
    <div class="seven columns offset-by-one omega decorative-left">
       <div class="login">
           <h2>Login</h2>
           <?php
           if($this->session->userdata('error_loggin')){
			   echo '<p class="error">Incorrect combination email/password</p>';		
		      }
		     ?>
           <form action="<?=base_url()?>login/" method="post">
           <p><label for="usernameLog">Email:</label>
           <input  type="text" id="edt_first_name" name="usernameLog" /></p>
           <p><label for="usernameLog">Password:</label>
           <input  type="password" id="edt_first_name" name="passwordLog" /></p>
           <p class="submit"><input type="submit" name="submit_register_form" value="Login">
         
           <p><a href="<?=base_url()?>reset-account/">Can't access your account?</a>
           </p>           
                            
           </form>

       </div>
       <div class="facebookLogin">
       <a href="<?=base_url()?>facebookAuth/">
          Login using facebook account
       </a>
       </div>
       <div class="twitterLogin">
       <a href="<?=base_url()?>twitter/">
         Login using twitter account
       </a>
       </div>
    </div>
    <div class="seven columns offset-by-one alpha decorative-right">
    <h2>Sign Up</h2>
    <!--++++++++++++++++++-->
       <form action="<?=base_url()?>register/" method="post">
       
                             <div class="errors"><?php echo form_error('first_name'); ?></div>                          
                            <p><label for="first_name">First Name:  <em>*</em></label>
                                <input  type="text" id="edt_first_name" name="first_name" value="<?=set_value('first_name')?>"></p>
                                
                            <div class="errors"><?php echo form_error('last_name'); ?></div>
                            <p><label for="last_name">Last Name:  <em>*</em></label>
                                <input  type="text" id="edt_last_name" name="last_name" value="<?=set_value('last_name')?>"></p>
    
                            <div class="errors"><?php echo form_error('username'); ?></div> 
                            <p><label for="Username">Username: <em>*</em></label>
                                <input  type="text" id="username" name="username" value="<?=set_value('username')?>"></p>
                           
                            <div class="errors"><?php echo form_error('email'); ?></div>   
                            <p><label for="email">Email:  <em>*</em></label>
                                <input  type="text" id="edt_email" name="email" value="<?=set_value('email')?>"></p>
                             
                              
                              
                              <div class="errors"><?php echo form_error('sex'); ?></div> 
                               <p> <label for="sex">I am<em>*</em></label>
                                <select id="sex" name="sex" class="select">
                                <option value="0">Select Sex:</option>
                                <option value="1">Female</option>
                                <option value="2">Male</option>
                                </select></p>
                                
                                
                            <div class="errors"><?php echo form_error('birthday'); ?></div> 
                            <p><label for="birthday">Birthday:<em>*</em></label>
                                <input  type="text" id="datepicker" name="birthday" value="<?=set_value('birthday')?>">  
                            </p>
                                
                                
                                 <p> <label for="timezone">Timezone</label>
                                <?=timezone_menu('UM8')?>
                                </p>                          
                            
                            <div class="errors"><?php echo form_error('town'); ?></div>
                            <p><label for="town">Town:  <em>*</em></label>
                                <input  type="text" id="edt_town" name="town" value="<?=set_value('town')?>"></p>
                            
                            
                            <div class="errors"><?php echo form_error('country'); ?></div>
                            <p><label for="country">Country:  <em>*</em></label>
                                <input  type="text" id="edt_country" name="country" value="<?=set_value('country')?>"></p>
    
    
    
                            <div class="errors"><?php echo form_error('password'); ?></div>
                            <p><label for="password">Password  <em>*</em></label>
                            
                                <input  type="password" id="password" name="password" ></p>
                            <div class="errors"><?php echo form_error('confirm_password'); ?></div>
                            <p><label for="confirm_Password:">Confirm Password:<em>*</em></label>
                            
                                <input  type="password" id="confirm_Password" name="confirm_password" ></p>
                         <p class="submit"><input type="submit" name="submit_register_form" value="Register"><span class="clear"></span></p>
     
     
       </form>

       </div><div class="clear"></div>
<?php else: ?>
<div class="sixteen columns reg-next">
	<h4>Select Preferred Event Categories</h4>
    <div class="category-next">
    <form action="<?=base_url()?>register/next/" method="post">
    <?php foreach($categories as $category): ?>
    <p><input type="checkbox" name="selected_cat[]" value="<?=$category->id?>" /><?=$category->category?></p>
    <?php endforeach; ?>
    <p class="submit"><input type="submit" name="sub_selected_cat" value="Finish Registration"></p>
    </div>
</div>
<?php endif; ?>    
    </div><!--end->sixteen columns event-->
</div>