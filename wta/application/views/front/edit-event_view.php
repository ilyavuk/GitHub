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

   <div class="top"><h2>Edit event</h2>
   </div>
   <div class="form_user_left">
    <form name='edit_event' action="<?=base_url()?>control-panel/my-events/edit/<?=$event->id?>" method="post">
	 <?php  
       $data = array(
                  'id'  => $event->id,
				  'logo_event'=> $event->logo,
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
								echo form_dropdown('venues_id', $position, $event->venues_id);
								?>
                           </p>  
   
                        <div class="errors"><?=form_error('title')?></div>
						<p><label for="title">Title: <em>*</em></label>
							<input  type="text" id="title" name="title" value="<?=$event->title?>" /></p>
                        
                        <div class="errors"><?=form_error('description')?></div>   
						<p><label for="description">Description:</label>
                          <textarea rows="5" cols="20" name="description"><?=$event->description?></textarea></p>
                         <div class="errors"></div> 
                         
                       <div class="errors"><?=form_error('category')?></div>
                        <p><label for="category">Category:</label>
							<input  type="text" id="category" name="category" value="<?=$event->category?>" /></p>    
                         
 						<div class="errors"><?=form_error('theme')?></div>
                        <p><label for="theme">Theme:</label>
							<input  type="text" id="Country" name="theme" value="<?=$event->theme?>" /></p>                        
                                                
						<div class="errors"><?=form_error('start_date')?></div>
                        <p><label for="date">Date and Time event starts: <em>*</em></label>
    				        <input  type="text" class="timepicker" name="start_date" value="<?=date("m/d/Y H:i",$event->start_date)?>" />  
						</p>
                        
						<div class="errors"><?=form_error('end_date')?></div>
                        <p><label for="time">Date and Time event ends: <em>*</em></label>
    				        <input  type="text" class="timepicker" name="end_date" value="<?=date("m/d/Y H:i",$event->end_date)?>" />  
						</p>	
                        						
						<p><label for="youtube">Youtube:</label>
    				        <input  type="text" id="youtube" name="youtube" value="<?=$event->youtube?>" />  
						</p>

						<p><label for="vimeo">Vimeo:</label>
    				        <input  type="text" id="vimeo" name="vimeo" value="<?=$event->vimeo?>" />  
						</p>
                        <p><label for="banner">Banner:</label>
                          <textarea rows="5" cols="20" name="banner"><?=$event->banner?></textarea></p> 
                                                  
  <p class="submit"><input type="submit" name="edit_event_form" value="Edit Event"><span class="clear"></span></p>
 </form>                       
                        						
   </div>
   <div class="form_user_right">

                    
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
       <form id="">
		<b>Image should be JPEG (.jpg)</b><br />
		<i>Firefox and Chrome users can drag & drop image file below</i><br /><br />
		<div id="file-uploaderZ">		
			<noscript>			
				<p>Please enable JavaScript to use file uploader.</p>
			</noscript>         
		</div>
		</form>			
		<script type="text/javascript">
		

        function createUploader(){            
            var uploader = new qq.FileUploader({
                element: $('#file-uploader')[0],
                action: '<?=base_url('ajax/upload_event_image')?>',
                debug: false,
                allowedExtensions: ['jpg'],
                onSubmit: function() {
                	uploader.setParams({
                		property_id: <?=$event->id?>
                	});
                },
                onComplete: function(id, fileName, responseJSON){
                	get_images();
                }
            });           
        }
		
        function createUploaderZ(){            
            var uploader = new qq.FileUploader({
                element: $('#file-uploaderZ')[0],
                action: '<?=base_url('ajax/upload_event_image')?>',
                debug: false,
                allowedExtensions: ['jpg'],
                onSubmit: function() {
                	uploader.setParams({
                		property_id: <?=$event->id?>
                	});
                },
                onComplete: function(id, fileName, responseJSON){
                	get_images();
                }
            });           
        }
        /* url_title: $('input[name="url_title"]').val() */
        // in your app create uploader as soon as the DOM is ready
        // don't wait for the window to load  
            
    </script>  
	
	<div id="images_wrapper">
	<?php foreach($event_imgs as $event_img): ?>
    <div class="img_shell"><div class="close"><a class="delete_event_img" href="" rel="<?=$event_img->id?>">delete X</a></div>
    <div class="of_img">
    <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/evt_logo_img/<?=$event_img->img_name?>&amp;w=150&amp;aoe=1">
    </div>
    <div class="of_input">
    <p>
    <label for="img_title">Image title</label>
    <input class="img_imp" type="text" name="img_title" value="<?=$event_img->img_title?>" /></p>
    <p>
    <label for="img_decription">Image decription</label>
    <textarea class="img_textarea" name="img_decription" rows="2" cols="20"><?=$event_img->img_description?></textarea></p>
    <p>
    <label for="logo">Select if you want to be logo</label>
    <input type="radio" name="logo" class="radiobutton" value="<?=$event_img->img_name?>"  <?=($event_img->img_name==$event->logo)?'checked="checked"':false?> /></p>
    </div><div class="clear"></div>
    </div>
    <?php endforeach; ?>  
	</div>
<!-- end upload image -->

</div><!-- close content -->

</div>                      
<script>

function get_images(){
			$.ajax({
			type: "POST",
			dataType: "json",
			url: '<?=base_url('ajax/get_images')?>',
			data: "property_id="+<?=$event->id?>,
			success: function(obj){
             var html = '';
              if(obj){
				  $(obj).each(function(i, d){
			  
						if(d.img_title === null){
							d.img_title = '';
						}
						if(d.img_description === null){
							d.img_description = '';
						}
						if(d.img_name === '<?=$event->logo?>'){
							var checkedB = 'checked="checked" ';
						}else{
							var checkedB = '';
						}
						 html += '<div class="img_shell"><div class="close"><a class="delete_event_img" href=""  rel="'+d.id+'">delete X</a></div>';
						 html += '<div class="of_img">';
						 html += '<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/evt_logo_img/'+d.img_name+'&amp;w=150&amp;aoe=1"></div>';
						html += '<div class="of_input"><p>';
						
						html += '<label for="img_title">Image title</label>';
						html += '<input class="img_imp" type="text" name="img_title" value="'+d.img_title+'"></p><p>';
						
						html += '<label for="img_decription">Image decription</label>';
						html += '<textarea class="img_textarea" name="img_decription" rows="3" cols="20">'+d.img_description+'</textarea></p>';
						html +='<p><label for="logo">Select if you want to be logo</label>';
						html +='<input type="radio" name="logo" class="radiobutton" value="'+d.img_name+'"';
						html +=' '+checkedB+' /></p>';
						html += '</div><div class="clear"></div></div>';


					 
				  });
				   $('#images_wrapper').html(html);
				  
				  
			  }else{
				  $('#images_wrapper').html('No images');
			  }
			}
			});
}
function delete_images(id) {
			$.ajax({
			type: "POST",
			dataType: "json",
			url: '<?=base_url('ajax/delete_images')?>',
			data: "img_id="+id,
			success: function(obj){

              if(obj['result'] == 1){
                 get_images();
			  }else{
				  return false;
			  }
			}
			});
}
function change_title(id, title) {
	
	        data =  '&title=' + title;
			data +=  '&id=' + id;
			$.ajax({
			type: "POST",
			dataType: "json",
			url: '<?=base_url('ajax/change_title')?>',
			data: data,
			success: function(obj){

              if(obj['result'] == 1){
//                 get_images();
                   alert('Good');
			  }else{
				  return false;
			  }
			}
			});
}
function change_textarea(id, textarea) {
	
	        data =  '&textarea=' + textarea;
			data +=  '&id=' + id;
			$.ajax({
			type: "POST",
			dataType: "json",
			url: '<?=base_url('ajax/change_textarea')?>',
			data: data,
			success: function(obj){

              if(obj['result'] == 1){
//                 get_images();
                   alert('Good');
			  }else{
				  return false;
			  }
			}
			});
}

$(function() {
	
  createUploader(); 
  createUploaderZ();
 $('.close a').live('click', function(e){
	e.preventDefault();
	var is_logo = $(this).parents(".img_shell").find('.radiobutton').attr('checked');
	if(is_logo == 'checked'){
		alert('You cannot delete logo image');
	}else{
	  delete_images($(this).attr('rel'));
	}
  });
  
  $('.img_imp').live('change', function(e){
	e.preventDefault();
	var title = $(this).val();
	var id = $(this).parents(".img_shell").find('.close a').attr('rel');
    change_title(id, title);
  });
  
    $('.img_textarea').live('change', function(e){
		e.preventDefault();
		var textarea = $(this).val();
		var id = $(this).parents(".img_shell").find('.close a').attr('rel');
		change_textarea(id, textarea);
  });
  
      $('.radiobutton').live('change', function(){
		var logo = $(this).val();
		$('input[name="logo_event"]').attr('value',logo);
		
      });
  
});
</script>              
                     
                            
   </div>

   
   <div class="clear"></div> 
  
</div>
</div>
