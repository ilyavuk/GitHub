  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2>New venue</h2>
    <p id="page-intro"></p>
    
    <div class="content-box"><!-- Start Content Box -->
      
      <div class="content-box-header">
        <h3></h3>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
        <?php if($venues_limit != 1): ?>
        
          <form action="<?=base_url()?>admin/venues/insert" method="post">
            <fieldset>
				 <?php  
                   $data = array(
                              'user_id'  => $this->session->userdata('id'),
                              'username'  => $this->session->userdata('username'),
                              'logo_venue'=> ($venue->logo != '')?$venue->logo:'admin.jpg',
                            );
                  echo form_hidden($data);
                 ?>   
                 
                 
						<p><label for="title">Place: <em>*</em></label>
							<input class="text-input small-input" type="text" id="name" name="place" value="<?=set_value('place')?>">
					   <?php if(form_error('place')!= ''): ?>
                        <span class="input-notification error png_bg"><?=form_error('place')?></span> 
                       <?php endif; ?>                         
                        </p>
                            
						<p><label for="title">Title: <em>*</em></label>
							<input class="text-input small-input" type="text" id="title" name="title" value="<?=set_value('title')?>">
 					   <?php if(form_error('title')!= ''): ?>
                        <span class="input-notification error png_bg"><?=form_error('title')?></span> 
                       <?php endif; ?>                         
                        </p>
                        
                        <script>$(function(){CKEDITOR.replace( 'description' );});</script>
						<p><label for="description">Description:</label>
                          <textarea class="text-input text area wysiwyg" rows="5" cols="20" name="description"><?=set_value('description')?></textarea>
                        </p>
                         
                           
						<p><label for="site_url">Site url:</label>
                        <input class="text-input small-input" type="text"  name="site_url" value="<?=set_value('site_url')?>"></p>                         
                         
						
                        <p><label for="country">Country: <em>*</em></label>
							<input class="text-input small-input" type="text" id="Country" name="country" value="<?=set_value('country')?>">
    				   <?php if(form_error('country')!= ''): ?>
                        <span class="input-notification error png_bg"><?=form_error('country')?></span> 
                       <?php endif; ?>                         
                        </p>
                            
					    
                        <p><label for="city">City: <em>*</em></label>
							<?php
							$position = array();
							$position[''] = 'City';
							foreach($cities as $city) {
								$position[$city->city] = $city->city;
							}
							echo form_dropdown('city', $position, set_value('city'),'class="small-input"');
							?>
						   <?php if(form_error('city')!= ''): ?>
                            <span class="input-notification error png_bg"><?=form_error('city')?></span> 
                           <?php endif; ?>                         
                         </p>   
                                                 
                        <p><label for="address">Address: <em>*</em></label>
							<input class="text-input small-input" type="text" id="edt_address" name="address" value="<?=set_value('address')?>">
      				   <?php if(form_error('address')!= ''): ?>
                        <span class="input-notification error png_bg"><?=form_error('address')?></span> 
                       <?php endif; ?>                        
                        </p>                           
                            
						<p><label for="youtube">Youtube:</label>
    				        <input  class="text-input small-input" type="text" id="youtube" name="youtube" value="<?=set_value('youtube')?>">  
						</p>

						<p><label for="vimeo">Vimeo:</label>
    				        <input class="text-input small-input" type="text" id="vimeo" name="vimeo" value="<?=set_value('vimeo')?>">  
						</p>

                       <p>
                         <input class="button" name="insert_venue_form" type="submit" value="Submit" />
                       </p>
            </fieldset>
            <div class="clear"></div>
            <!-- End .clear -->
            
          </form>
        </div>
        <!-- End #tab2 --> 
<div id="picture_profile">
<div class="content">

<hr/>

    <h3>Background image</h3>
    <div class="banner">
        <form>
        <div class="tip">Recommended Background image size 1280x1024 px</div>
            <div id="file-uploaderBImg">		
            </div>
          </form>
           <p class="background-img" id="insertBack" > 
             <?php if($venue->background_image != ''):?>
             <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/background/<?=$venue->background_image?>&w=280&h=280&zc=1&aoe=1" />
             <a href="#" class="delBackground" >Delete X</a>
             <?php else: ?>
               Background image is not set
             <?php endif;?>
           </p>                 
    </div> 	

<h3>Images & Logo image</h3>
<div class="tip">Recommended cover image size 600x250 px</div>
	
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
<div id="images_wrapper">
<?php if(isset($venue_imgs)): ?>    
<?php foreach($venue_imgs as $venue_img): ?>
<div class="img_shell">
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
</div>
<div class="closeLL"><a class="delete_event_img" href="" rel="<?=$venue_img->id?>">delete X</a></div>
</div>
<?php endforeach; ?>  
<?php endif; ?>  
</div>


</div><!-- close content -->

</div> 
        
      <?php else: ?>
      <p>You have created one venue, and you don't have option to created another one!</p>
      <?php endif; ?>  
      </div>
      <!-- End .content-box-content --> 
      
    </div>
    <!-- End .content-box -->
    

    

    <!-- End .content-box -->
    
    <div class="clear"></div>
<script>

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

		}
	});           
}
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


html += '<div class="img_shell">';
html += '<div class="of_img">';
html += '<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/venues_img/'+d.img_name+'&amp;w=180&amp;h=180&amp;zc=1&amp;aoe=1"></div>';
html += '<div class="of_input"><p>';

html += '<label for="img_title">Image title</label>';
html += '<input class="img_imp" type="text" name="img_title" value="'+d.img_title+'"></p><p>';

html += '<label for="img_decription">Image decription</label>';
html += '<textarea class="img_textarea" name="img_decription" rows="3" cols="20">'+d.img_description+'</textarea></p>';
html +='<p><label for="logo">Select if you want to be logo</label>';
html +='<input type="radio" name="logo" class="radiobutton" value="'+d.img_name+'"';
html +=' '+checkedB+' /></p>';
html += '</div><div class="closeLL"><a class="delete_event_img" href=""  rel="'+d.id+'">delete X</a></div></div>';


					 
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
  manageBackground(<?=$venue->id?>,'venues');
  
  $('.delBackground').live('click', function(e){
    e.preventDefault();
    deleteBackground(<?=$venue->id?>,'venues');
  });
	
 $('.delBan').live('click', function(e){
    e.preventDefault();
    deleteBanner($(this).attr('rel'),$(this).parent());
 });
 
 $('.closeLL a').live('click', function(e){
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
	var id = $(this).parents(".img_shell").find('.closeLL a').attr('rel');
    change_title(id, title);
  });
  
   $('.img_textarea').live('change', function(e){
		e.preventDefault();
		var textarea = $(this).val();
		var id = $(this).parents(".img_shell").find('.closeLL a').attr('rel');
		change_textarea(id, textarea);
  });
  
   $('.radiobutton').live('change', function(){
	var logo = $(this).val();
	$('input[name="logo_venue"]').attr('value',logo);
	
  }); 
  
});
</script>              
   

