  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2>Edit venue</h2>
    <p id="page-intro"><a href="<?=base_url()?>venues/detail/<?=$venue->id?>">View Venue</a></p>
    
    <div class="content-box"><!-- Start Content Box -->
      
      <div class="content-box-header">
        <h3></h3>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
          <form action="<?=base_url()?>admin/venues/edit/<?=$venue->id?>" method="post">
            <fieldset>
					 <?php  
                       $data = array(
					              'user_id'  => $this->session->userdata('id'),
                                  'username'  => $this->session->userdata('username'),
                                  'id'  => $venue->id,
                                  'logo_venue'=> $venue->logo,
                                );
                    
                      echo form_hidden($data);
                     ?>  
                 
                 
						<p><label for="title">Place: <em>*</em></label>
							<input class="text-input small-input" type="text" id="name" name="place" value="<?=$venue->place?>">
					   <?php if(form_error('place')!= ''): ?>
                        <span class="input-notification error png_bg"><?=form_error('place')?></span> 
                       <?php endif; ?>                         
                        </p>
                            
						<p><label for="title">Title: <em>*</em></label>
							<input class="text-input small-input" type="text" id="title" name="title" value="<?=$venue->title?>">
 					   <?php if(form_error('title')!= ''): ?>
                        <span class="input-notification error png_bg"><?=form_error('title')?></span> 
                       <?php endif; ?>                         
                        </p>
                        
                        <script>$(function(){CKEDITOR.replace( 'description' );});</script>
						<p><label for="description">Description:</label>
                          <textarea class="text-input text area wysiwyg" rows="5" cols="20" name="description" ><?=$venue->description?></textarea>
                        </p>
                         
                           
						<p><label for="site_url">Site url:</label>
                        <input class="text-input small-input" type="text"  name="site_url" value="<?=$venue->site_url?>"></p>                         
                         
						
                        <p><label for="country">Country: <em>*</em></label>
							<input class="text-input small-input" type="text" id="Country" name="country" value="<?=$venue->country?>">
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
							echo form_dropdown('city', $position, $venue->city,'class="small-input"');
							?>
						   <?php if(form_error('city')!= ''): ?>
                            <span class="input-notification error png_bg"><?=form_error('city')?></span> 
                           <?php endif; ?>                         
                         </p>   
                                                 
                        <p><label for="address">Address: <em>*</em></label>
							<input class="text-input small-input" type="text" id="edt_address" name="address" value="<?=$venue->address?>">
      				   <?php if(form_error('address')!= ''): ?>
                        <span class="input-notification error png_bg"><?=form_error('address')?></span> 
                       <?php endif; ?>                        
                        </p>                           
                            
						<p><label for="youtube">Youtube:</label>
    				        <input  class="text-input small-input" type="text" id="youtube" name="youtube" value="<?=$venue->youtube?>">  
						</p>

						<p><label for="vimeo">Vimeo:</label>
    				        <input class="text-input small-input" type="text" id="vimeo" name="vimeo" value="<?=$venue->vimeo?>">  
						</p>
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
                        
                        <h3>Banners</h3>
						<?php
						$banner_list = array(
								   1 => $venue->banner_img1,
								   2 => $venue->banner_img2,
								   3 => $venue->banner_img3,
								   4 => $venue->banner_img4,
								   5 => $venue->banner_img5,
								   6 => $venue->banner_img6
					           	);
					     $banner_value = array(
								   1 => $venue->url_banner1,
								   2 => $venue->url_banner2,
								   3 => $venue->url_banner3,
								   4 => $venue->url_banner4,
								   5 => $venue->url_banner5,
								   6 => $venue->url_banner6
					           	);
						?>
                       <?php for($i=1; $i<=6; $i++):?>  
   						<div class="banner">
                            <form>
                            <div class="tip">Recommended banner size 280x120 px</div>
                                <div id="file-uploaderV<?=$i?>">		
                                </div>
                              </form>
                               <p class="bimg" id="insertB<?=$i?>"> 
                                 <?php if($banner_list[$i] != ''):?>
                                 <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/banners/<?=$banner_list[$i]?>&w=280&h=120&zc=1&aoe=1" />
                                 <a href="#" class="delBan" rel="<?=$i?>">Delete X</a><br/>
                                 <span>
                                 <label for="url_banner<?=$i?>">Link :</label><br/>
                                 <input type="text" name="url_banner<?=$i?>" value="<?=$banner_value[$i]?>" /></span>
                                 <?php endif;?>
                               </p>                 
                       </div>                        
                       <?php endfor; ?>                       
                       <p>
                         <input class="button" name="edit_venue_form" type="submit" value="Submit" />
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
<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/venues_img/<?=$venue_img->img_name?>&amp;w=180&amp;h=180&amp;zc=1&amp;aoe=1">
</div>
<div class="of_input">
<p>
<label for="img_title">Image title</label>
<input class="img_imp" type="text" name="img_title" value="<?=$venue_img->img_title?>" /></p>
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
<!-- end upload image -->

</div><!-- close content -->

</div> 
   
        </div>
      <!-- End .content-box-content -->  
   
    </div>
    <!-- End .content-box -->
    

    

    <!-- End .content-box -->
    
    <div class="clear"></div>
<script>
function createUploaderBanner(id_i){
           
	var uploader = new qq.FileUploader({
		element: $('#file-uploaderV'+id_i)[0],
		template: '<div class="qq-uploader">' + 
							'<div class="qq-upload-drop-area"><span>Drop files here to upload</span></div>' +
							'<div class="qq-upload-button">Add Banner '+id_i+'</div>' +
							'<ul class="qq-upload-list"></ul>' + 
							'</div>',
		action: '<?=base_url('ajax/upload_venueBanner_image')?>',
		debug: false,
		allowedExtensions: ['jpg','png','gif'],
		onSubmit: function() {
			uploader.setParams({
				property_id: <?=$venue->id?>,
				img_id: id_i
				 
			});
		},
		onComplete: function(id, fileName, responseJSON){
			
			$('#insertB'+id_i).empty();
			
			var html = '<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/banners/'+ responseJSON.img + '&w=280&h=120&zc=1&aoe=1" />';
			    html += '<a href="" class="delBan" rel="'+ id_i +'" >Delete X </a> ';
				html += '<span><label for="url_banner'+ id_i +'">Link :</label><br/>';
				html += '<input type="text" name="url_banner'+ id_i +'" value="" /></span>';
				
			$('#insertB'+id_i).html(html);

		}
	});           
}

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
function deleteBanner(Bid,ob){
	        data =  '&id=' + <?=$venue->id?>;
			data +=  '&Bid=' + Bid;
			$.ajax({
			type: "POST",
			dataType: "json",
			url: '<?=base_url('ajax/delete_venues_banner')?>',
			data: data ,
			success: function(obj){
              if(obj == 1){
                 ob.html('');
			  }else{
				  return false;
			  }
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
	createUploaderBanner(1);
	createUploaderBanner(2);
	createUploaderBanner(3);
	createUploaderBanner(4);
	createUploaderBanner(5);
	createUploaderBanner(6);
	
 $('.delBan').live('click', function(e){
    e.preventDefault();
    deleteBanner($(this).attr('rel'),$(this).parent());
     
 });
 
  $('.delBackground').live('click', function(e){
    e.preventDefault();
    deleteBackground(<?=$venue->id?>,'venues');
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
  

