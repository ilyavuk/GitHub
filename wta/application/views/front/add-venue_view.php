<script>	
    $(function() {

		$( "#datepicker" ).datepicker({

			changeMonth: true,

			changeYear: true,

			yearRange: "1900:2012" 

		});
       
	   $('.timepicker').timepicker();
	   
	});
</script>

<div id="add-event-panel">

   <div class="top"><h2>Add venue</h2>
   </div>
   <div class="form_user_left">
    <form name='add_event' action="<?=base_url()?>control-panel/add-venue/" method="post">
	 <?php  
       $data = array(
                  'user_id'  => $user_id,
                  'username'  => $username,
                );
    
      echo form_hidden($data);
     ?>    
   
                         <div class="errors"><?=form_error('place')?></div>
						<p><label for="title">Place: <em>*</em></label>
							<input  type="text" id="name" name="place" value="<?=set_value('place')?>"></p>
                            
                              
                        <div class="errors"><?=form_error('title')?></div>
						<p><label for="title">Title: <em>*</em></label>
							<input  type="text" id="title" name="title" value="<?=set_value('title')?>"></p>
                        
                        <div class="errors"><?=form_error('description')?></div>   
						<p><label for="description">Description:</label>
                          <textarea rows="5" cols="20" name="description"><?=set_value('description')?></textarea></p>
                           
                         
                         <div class="errors"><?=form_error('site_url')?></div>   
						<p><label for="site_url">Site url:</label>
                        <input  type="text"  name="site_url" value="<?=set_value('site_url')?>"></p>
                                                   
                         
						<div class="errors"><?=form_error('country')?></div>
                        <p><label for="country">Country: <em>*</em></label>
							<input  type="text" id="Country" name="country" value="<?=set_value('country')?>"></p>
							
						<div class="errors"><?=form_error('city')?></div>
                        <p><label for="city">City: <em>*</em></label>
							<input  type="text" id="city" name="city" value="<?=set_value('city')?>"></p>
                     
                            
 						<div class="errors"><?=form_error('address')?></div>
                        <p><label for="address">Address: <em>*</em></label>
							<input  type="text" id="edt_address" name="address" value="<?=set_value('address')?>"></p>                           
                            
						<p><label for="youtube">Youtube:</label>
    				        <input  type="text" id="youtube" name="youtube" value="<?=set_value('youtube')?>">  
						</p>

						<p><label for="vimeo">Vimeo:</label>
    				        <input  type="text" id="vimeo" name="vimeo" value="<?=set_value('vimeo')?>">  
						</p>
                        
  						<p><label for="banner">Banner:</label>
                          <textarea rows="5" cols="20" name="banner"><?=set_value('banner')?></textarea></p>                       
                        
                        <p class="submit"><input type="submit" name="add_venue_form" value="Add Venue"><span class="clear"></span></p>                    
                        

 </form>                       
                        						
   </div>
   <div class="form_user_right">
   </div>
   <div class="clear"></div> 
  
</div>
</div>
