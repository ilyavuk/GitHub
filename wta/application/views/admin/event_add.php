  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2>Add event</h2>
    <p id="page-intro"></p>
    
    <div class="content-box"><!-- Start Content Box -->
      
      <div class="content-box-header">
        <h3></h3>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
          <form action="<?=base_url()?>admin/events/insert" method="post">
            <fieldset>
            	 <?php  
					   $data = array(
								  'user_id'  => $this->session->userdata('id'),
								  'username'  => $this->session->userdata('username'),
								  'logo_event'=> ($event->logo != '')?$event->logo:'admin.jpg'
								);
					
					  echo form_hidden($data);
    			 ?>  
                <p>
                    <label for="venues_id">Venue <em>*</em></label>
                    <?php
                    $position = array();
                    $position[''] = 'Venue..';
                    foreach($venues as $venue) {
                        $position[$venue->id] = $venue->place;
                    }
                    echo form_dropdown('venues_id', $position ,set_value('venues_id'), 'class="small-input"');
                    ?>
                    <?php if(form_error('venues_id')!= ''): ?>
                    <span class="input-notification error png_bg"><?=form_error('venues_id')?></span> 
                    <?php endif; ?>
               </p> 
           
              <p>
                <label for="title">Title: <em>*</em></label>
				<input  class="text-input small-input" type="text" id="title" name="title" value="<?=set_value('title')?>">
                <?php if(form_error('title')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('title')?></span> 
                <?php endif; ?>
              </p>
              <p>
                <label for="url_title">Url title: <em>*</em></label>
				<input  class="text-input small-input" type="text" id="url_title" name="url_title" value="<?=set_value('url_title')?>">
                <?php if(form_error('url_title')!= ''): ?>
                <span class="input-notification error png_bg"><?=form_error('url_title')?></span> 
                <?php endif; ?>
              </p> 
              <script>$(function(){CKEDITOR.replace( 'description' );});</script>            
              <p><label for="description">Description:</label>
                 <textarea class="text-input text area wysiwyg" rows="5" cols="20" name="description"><?=set_value('description')?></textarea></p>
                                    
               <p><label for="category">Category <em>*</em></label>
                    <?php
                    $position2 = array();
                    $position2[''] = 'Category..';
                    foreach($categories as $category) {
                        $position2[$category->category] = $category->category;
                    }
                    echo form_dropdown('category', $position2, set_value('category'),'class="small-input"');
                    ?>
                <?php if(form_error('category')!= ''): ?>
                	<span class="input-notification error png_bg"><?=form_error('category')?></span> 
                <?php endif; ?>
               </p> 
               
                <p><label for="date">Date and Time event starts: <em>*</em></label>
                    <input  class="text-input small-input timepicker_a" type="text" name="start_date" value="<?=set_value('start_date')?>">  
                 <?php if(form_error('start_date')!= ''): ?>
                	<span class="input-notification error png_bg"><?=form_error('start_date')?></span> 
                <?php endif; ?>             
                </p>
             
                 <p><label for="time">Date and Time event ends: <em>*</em></label>
                    <input  class="text-input small-input timepicker_a" type="text" name="end_date" value="<?=set_value('end_date')?>">  
                  <?php if(form_error('end_date')!= ''): ?>
                	<span class="input-notification error png_bg"><?=form_error('end_date')?></span> 
                <?php endif; ?>             
                </p>	           
             
                <p><label for="youtube">Youtube:</label>
                    <input  class="text-input small-input" type="text" id="youtube" name="youtube" value="<?=set_value('youtube')?>">  
                </p>

                <p><label for="vimeo">Vimeo:</label>
                    <input  class="text-input small-input" type="text" id="vimeo" name="vimeo" value="<?=set_value('vimeo')?>">  
                </p>
                <p><label for="live_video">Live Video:</label>
                    <textarea class="text-input medium-input" rows="4" cols="20" name="live_video"><?=set_value('live_video')?></textarea>  
                </p>               
                                                                      
              <div class="banner">
              <h3>Upload banner</h3>
                    <form>
                    <div class="tip">Recommended banner size 102x102 px</div>
                        <div id="file-uploaderB">		
                        </div>
                      </form>
                       <p class="bimg"> 
                         <?php if($event->banner_img != ''):?>
                         <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/banners/<?=$event->banner_img?>&w=280&h=120&zc=1&aoe=1" />
                         <a href="#" class="delBan" >Delete X</a>
                         <span>
                         <label for="url_bannerE">Link :</label><br/>
                         <input type="text" name="url_bannerE" value="<?=$event->url_bannerE?>" /></span>
                         <?php endif;?>
                       </p>                 
               </div>              
                <p><label for="is_active:">Is active:</label>
                    <input type="checkbox" name="is_active" value="1"  checked="checked" />✔</p> 
                <p>
                <input class="button" name="insert_event_form" type="submit" value="Submit" />
              </p>
            </fieldset>
            <div class="clear"></div>
            <!-- End .clear -->
            
          </form>
        </div>
        <!-- End #tab2 --> 
        <hr/>
        <h3>Background image</h3>
        <div class="banner" id="backgroundShield" >
            <form>
            <div class="tip">Recommended Background image size 1280x1024 px</div>
                <div id="file-uploaderBImg">		
                </div>
              </form>
               <p class="background-img " id="insertBack" > 
                 <?php if($event->background_image != ''):?>
                 <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/background/<?=$event->background_image?>&w=280&h=280&zc=1&aoe=1" />
                 <a href="#" class="delBackground" >Delete X</a>
                 <?php else: ?>
                   Background image is not set
                 <?php endif;?>
               </p>                 
        </div> 
        
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

<div id="images_wrapper">
<?php foreach($event_imgs as $event_img): ?>
<div class="img_shell"></div>
<div class="of_img">
<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/evt_logo_img/<?=$event_img->img_name?>&amp;w=180&amp;h=180&amp;zc=1&amp;aoe=1">
</div>
<div class="of_input">
<p>
<label for="img_title">Image title</label>
<input class="img_imp" type="text" name="img_title" value="<?=$event_img->img_title?>"></p>
<p>
<label for="img_decription">Image decription</label>
<textarea class="img_textarea" name="img_decription" rows="3" cols="20"><?=$event_img->img_description?></textarea></p>
<p>
<label for="logo">Select if you want to be logo</label>
<input type="radio" name="logo" class="radiobutton" value="<?=$event_img->img_name?>"  <?=($event_img->img_name==$event->logo)?'checked="checked"':false?>/></p>
</div>
<div class="closeLL"><a class="delete_event_img" href="" rel="<?=$event_img->id?>">delete X</a></div>
</div>
<?php endforeach; ?>  
</div>

      
    </div>

    
    <div class="clear"></div>
<script>
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
function createUploaderBanner(){
           
	var uploader = new qq.FileUploader({
		element: $('#file-uploaderB')[0],
		template: '<div class="qq-uploader">' + 
							'<div class="qq-upload-drop-area"><span>Drop files here to upload</span></div>' +
							'<div class="qq-upload-button">Add Banner</div>' +
							'<ul class="qq-upload-list"></ul>' + 
							'</div>',
		action: '<?=base_url('ajax/upload_eventBanner_image')?>',
		debug: false,
		allowedExtensions: ['jpg','png','gif'],
		onSubmit: function() {
			
			uploader.setParams({
				property_id: <?=$event->id?>
			});
		},
		onComplete: function(id, fileName, responseJSON){
			
			
			var innerHTML = '<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/banners/'+ responseJSON.img + '&amp;w=280&amp;h=120&amp;zc=1&amp;aoe=1?x='+new Date().getTime()+ '" /><a href="#" class="delBan" >Delete X</a>';
			    innerHTML += '<span><label for="url_bannerE">Link :</label><br/><input type="text" name="url_bannerE" value="" /></span>';			
			
			$('p.bimg').html(innerHTML);
            
		}
	});           
}
function deleteBanner(){
	        data =  '&id=' + <?=$event->id?>;
			$.ajax({
			type: "POST",
			dataType: "json",
			url: '<?=base_url('ajax/delete_events_banner')?>',
			data: data ,
			success: function(obj){
              if(obj == 1){
                 $('p.bimg').html('');
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
			url: '<?=base_url('ajax/get_images')?>',
			data: "property_id="+<?=$event->id?>,
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
if(d.img_name === '<?=$event->logo?>'){
	var checkedB = 'checked="checked" ';
}else{
	var checkedB = '';
}


html += '<div class="img_shell">';
html += '<div class="of_img">';
html += '<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/evt_logo_img/'+d.img_name+'&amp;w=180&amp;h=180&amp;zc=1&amp;aoe=1"></div>';
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
	createUploaderBanner();
	manageBackground(<?=$event->id?>,'events');
	
    $('.delBackground').live('click', function(e){
      e.preventDefault();
      deleteBackground(<?=$event->id?>,'events');
    });
	
   $('.delBan').live('click', function(e){
	e.preventDefault();
	deleteBanner();
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
	$('input[name="logo_event"]').attr('value',logo);

  }); 
  
});
</script>   
  

