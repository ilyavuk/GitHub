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

   <div class="top"><h2>Edit venue</h2>
   </div>
   <div class="form_user_left">
    <form name='add_event' action="<?=base_url()?>control-panel/my-venues/edit/<?=$venue->id?>" method="post">
	 <?php  
       $data = array(
	              'id'  => $venue->id,
				  'logo_venue'=> $venue->logo,

                );
    
      echo form_hidden($data);
     ?>    
   
                         <div class="errors"><?=form_error('place')?></div>
						<p><label for="title">Place: <em>*</em></label>
							<input  type="text" id="place" name="place" value="<?=$venue->place?>"></p>
                            
                              
                        <div class="errors"><?=form_error('title')?></div>
						<p><label for="title">Title: <em>*</em></label>
							<input  type="text" id="title" name="title" value="<?=$venue->title?>"></p>
                        
                        <div class="errors"><?=form_error('description')?></div>   
						<p><label for="description">Description:</label>
                          <textarea rows="5" cols="20" name="description"><?=$venue->description?></textarea></p>
                          
                        <div class="errors"><?=form_error('site_url')?></div>   
						<p><label for="site_url">Site url:</label>
                        <input  type="text"  name="site_url" value="<?=$venue->site_url?>"></p>                        
                       
                         
						<div class="errors"><?=form_error('country')?></div>
                        <p><label for="country">Country: <em>*</em></label>
							<input  type="text" id="Country" name="country" value="<?=$venue->country?>"></p>
							
						<div class="errors"><?=form_error('city')?></div>
                        <p><label for="city">City: <em>*</em></label>
							<input  type="text" id="city" name="city" value="<?=$venue->city?>"></p>
                     
                            
 						<div class="errors"><?=form_error('address')?></div>
                        <p><label for="address">Address: <em>*</em></label>
							<input  type="text" id="edt_address" name="address" value="<?=$venue->address?>"></p>                           
                            
						<p><label for="youtube">Youtube:</label>
    				        <input  type="text" id="youtube" name="youtube" value="<?=$venue->youtube?>">  
						</p>

						<p><label for="vimeo">Vimeo:</label>
    				        <input  type="text" id="vimeo" name="vimeo" value="<?=$venue->vimeo?>">  
						</p>
                        <p><label for="banner">Banner:</label>
                          <textarea rows="5" cols="20" name="banner"><?=$venue->banner?></textarea></p>    
                                               
   						<p class="submit"><input type="submit" name="edit_venue_form" value="Edit Venue"><span class="clear"></span></p>
                          
                        
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
		<script type="text/javascript">
		

        function createUploader(){            
            var uploader = new qq.FileUploader({
                element: $('#file-uploader')[0],
                action: '<?=base_url('ajax/upload_venue_image')?>',
                debug: false,
                allowedExtensions: ['jpg'],
                onSubmit: function() {
                	uploader.setParams({
                		property_id: <?=$venue->id?>
                	});
                },
                onComplete: function(id, fileName, responseJSON){
                	get_images();
//                 alert('done');
                }
            });           
        }
		

        /* url_title: $('input[name="url_title"]').val() */
        // in your app create uploader as soon as the DOM is ready
        // don't wait for the window to load  
            
    </script>  
	
	<div id="images_wrapper">
<?php if(isset($venue_imgs)): ?>    
<?php foreach($venue_imgs as $venue_img): ?>
<div class="img_shell"><div class="close"><a class="delete_event_img" href="" rel="<?=$venue_img->id?>">delete X</a></div>
<div class="of_img">
<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/venues_img/<?=$venue_img->img_name?>&amp;w=150&amp;aoe=1">
</div>
<div class="of_input">
<p>
<label for="img_title">Image title</label>
<input class="img_imp" type="text" name="img_title" value="<?=$venue_img->img_title?>"></p>
<p>
<label for="img_decription">Image decription</label>
<textarea class="img_textarea" name="img_decription" rows="3" cols="20"><?=$venue_img->img_description?></textarea></p>
<p>
<label for="logo">Select if you want to be logo</label>
<input type="radio" name="logo" class="radiobutton" value="<?=$venue_img->img_name?>"  <?=($venue_img->img_name==$venue->logo)?'checked="checked"':false?>/></p>
</div><div class="clear"></div>
</div>
<?php endforeach; ?>  
<?php endif; ?>  



	</div>
<!-- end upload image -->

</div><!-- close content -->

</div>                      
<script>

function get_images(){
			$.ajax({
			type: "POST",
			dataType: "json",
			url: '<?=base_url('ajax/get_venues_images')?>',
			data: "property_id="+<?=$venue->id?>,
			success: function(obj){
             var html = '';
              if(obj){
				  $(obj).each(function(i, d){
 /*  html += '<div class="img_shell">';              
html += '<img src="http://wall2all.cp-dev.com/phpThumb/phpThumb.php?src=/assets/evt_logo_img/'+d.img_name+'&w=150&aoe=1" />';
	  html +='</div>';	*/			  
if(d.img_title === null){
	d.img_title = '';
}
if(d.img_description === null){
	d.img_description = '';
}
if(d.img_name === '<?=$venue->logo?>'){
	var checkedB = 'checked="checked" ';
}else{
	var checkedB = '';
}
 html += '<div class="img_shell"><div class="close"><a class="delete_event_img" href=""  rel="'+d.id+'">delete X</a></div>';
 html += '<div class="of_img">';
 html += '<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/venues_img/'+d.img_name+'&amp;w=150&amp;aoe=1"></div>';
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
			url: '<?=base_url('ajax/delete_venues_images')?>',
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
			url: '<?=base_url('ajax/change_venue_title')?>',
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
			url: '<?=base_url('ajax/change_venue_textarea')?>',
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
		$('input[name="logo_venue"]').attr('value',logo);
		
         });


});
</script>              
                     
                            
   </div>

   
   <div class="clear"></div> 
  
</div>
</div>
