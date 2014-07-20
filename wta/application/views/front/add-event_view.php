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

   <div class="top"><h2>Add event</h2>
   </div>
   <div class="form_user_left">
    <form name='add_event' action="<?=base_url()?>control-panel/add-event/" method="post">
	 <?php  
       $data = array(
                  'user_id'  => $user_id,
                  'username'  => $username,
	
                );
    
      echo form_hidden($data);
     ?>    
   
                       <div class="errors"><?php echo form_error('venue'); ?></div> 
                           <p> <label for="venues_id">Venue <em>*</em></label>
                                <?php
                           		$position = array();
                                $position['0'] = 'Venue..';
                                foreach($venues as $venue) {
                                    $position[$venue->id] = $venue->place;
                                }
								echo form_dropdown('venues_id', $position);
								?>
                           </p>
                        <div class="errors"><?=form_error('title')?></div>
						<p><label for="title">Title: <em>*</em></label>
							<input  type="text" id="title" name="title" value="<?=set_value('title')?>"></p>
                        
                        <div class="errors"><?=form_error('description')?></div>   
						<p><label for="description">Description:</label>
                          <textarea rows="5" cols="20" name="description"><?=set_value('description')?></textarea></p>
                         <div class="errors"></div>
                         
                        <div class="errors"><?=form_error('category')?></div>
                        <p><label for="category">Category:</label>
							<input  type="text" id="category" name="category" value="<?=set_value('category')?>"></p>    
                         
 						<div class="errors"><?=form_error('theme')?></div>
                        <p><label for="theme">Theme:</label>
							<input  type="text" id="theme" name="theme" value="<?=set_value('theme')?>"></p>                        
                                                
						<div class="errors"><?=form_error('start_date')?></div>
                        <p><label for="date">Date and Time event starts: <em>*</em></label>
    				        <input  type="text" class="timepicker" name="start_date" value="<?=set_value('start_date')?>">  
						</p>
                        
						<div class="errors"><?=form_error('end_date')?></div>
                        <p><label for="time">Date and Time event ends: <em>*</em></label>
    				        <input  type="text" class="timepicker" name="end_date" value="<?=set_value('end_date')?>">  
						</p>	
                        						
						<p><label for="youtube">Youtube:</label>
    				        <input  type="text" id="youtube" name="youtube" value="<?=set_value('youtube')?>">  
						</p>

						<p><label for="vimeo">Vimeo:</label>
    				        <input  type="text" id="vimeo" name="vimeo" value="<?=set_value('vimeo')?>"> 
						</p>
                        <p><label for="banner">Banner:</label>
                          <textarea rows="5" cols="20" name="banner"><?=set_value('banner')?></textarea></p> 
                          
  <p class="submit"><input type="submit" name="add_event_form" value="Add Event"><span class="clear"></span></p>
 </form>                       
                        						
   </div>
   <div class="form_user_right">
   </div>
   <div class="clear"></div> 
  
</div>
</div>
