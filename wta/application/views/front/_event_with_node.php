<style> .sidebar .attending {display:block;} </style>
<script>$(function() {
	
	/**
		The first thing is init existing comments 
	*/
	ajax_comments(false, false);
	
	
	var num_time = 0;
	var soc_post = '';
	<?php if($face_logged_in): ?>
		  soc_post = '| <a href="" class="user_facebook_post" rel=""> | Facebook post to wall</a>';
	<?php endif; ?>
	<?php if($twit_logged_in): ?>
		  soc_post = '| <a href="" class="tweet-click" >Tweet</a>';
	<?php endif; ?>
	
	
	/**
		Init socket
	*/
	var socket = io.connect('http://walltoall.com:3000');
	
	socket.on('entrance', function  (data) {
	});
	
	/**
		Submit comment or press enter
	*/
	$(document).on('click','input[name="upload"]', function(evt){
		if($('input[name="userfile"]').val()===''){
			evt.preventDefault();
			blockUser();
			if(is_blocked == 1){
				afterSubmit();
			}else{
				alert('Your username has been blocked by administrator');
			}
		}else{
			$('#upload-loader').css('display','block');
		}
	});
	
	<?php if(isset($something_went_wrong)):?>
	   alert("Your picture isn't posted! File extension must be jpg, jpeg, gif or png");
	<?php endif; ?>
	
	<?php if(isset($post_comments)):?>
		afterSubmit();
	<?php endif; ?>
	
	$(document).on('keypress','#comment_val', function(event){
		if (event.which == 13) {
			blockUser();
			if(is_blocked == 1){
				afterSubmit();
			}else{
				alert('Your username has been blocked by administrator');
			}
		}
	});
	
	/**
		Delete comment by id
	*/
	$(document).on('click','.user_comm_delete', function(e){
		e.preventDefault();
		delete_comment($(this));
	});
	
	/**
		Like comment by id
	*/
	$(document).on('click','.user_like', function(e){
		e.preventDefault();
		<?php if($this->common_logged_in):?>
		var comment_id = $(this).attr('rel');
		var change_span = $(this);
		like(comment_id,change_span);
		<?php else:?>
		alert('You need to log in to rate this comment!');
		<?php endif;?>
	});
	
	/**
		Rate the event 
	*/
	$('.rate_event').change(function(){
		if($('.rate_event').attr('rel')==1){
			blockUser();
			if(is_blocked == 1){
				var insert_impressions_poll = $(this).siblings('.insert_impressions_poll');
				if($(this).hasClass('poll2')){
				  poll($(this).val(),2,insert_impressions_poll,$(this));
				}else if($(this).hasClass('poll1')){
				   poll($(this).val(),1,insert_impressions_poll,$(this));
				}else{
				  poll($(this).val(),0,insert_impressions_poll,$(this));
				}
			}else{
				alert('Your username has been blocked by administrator');
			}
		}else{
			alert('You need to login to rate events');
		}
	});	
	
	/**
		Attending the event 
	*/
	$(document).on('click','#attending-button', function(e){
		e.preventDefault();
		var att = $('#attending-button').attr('rel');
		if(att==3){
		  alert('You need to login to attend the event!');
		}else{
			blockUser();
			if(is_blocked == 1){
			  attending(att);
			}else{
				alert('Your username has been blocked by administrator');
			}
		}
	});
	
	
	socket.on('chat', function  (data) {
		
		if (typeof data.message.Channel != 'undefined' &&  data.message.Channel == 'wall2all<?=$event->id_events?>'  ) {
			checkLastId(data.message);
		}
		
	});
	
	socket.on('deleteComment', function  (data) {
		
		if (typeof data.message.Channel != 'undefined' &&  data.message.Channel == 'wall2all<?=$event->id_events?>'  ) {
			$(".delete[data-id='"+ data.message.DeletePost +"']").remove();
		}
		
	});
	
	socket.on('likeComment', function  (data) {
		
		if (typeof data.message.Channel != 'undefined' &&  data.message.Channel == 'wall2all<?=$event->id_events?>'  ) {
			$("a.user_like[rel='"+ data.message.Comment_id+"']").html('| Like '+data.message.Like);
		}
		
	});
	
	socket.on('rateEvent', function  (data) {
		
		if (typeof data.message.Channel != 'undefined' &&  data.message.Channel == 'wall2all<?=$event->id_events?>'  ) {
			$('#'+ data.message.Id_poll).html(data.message.EventGrade);
		}
		
	});
	
	socket.on('Attending', function  (data) {
		
		if (typeof data.message.Channel != 'undefined' &&  data.message.Channel == 'wall2all<?=$event->id_events?>'  ) {
			if(data.message.DelElem == 0){
				$('#thumb_att').append(data.message.HtmlNode);
				$('#num_atts').html(data.message.NumAtts);
			}else{
				$("img[rel='"+ data.message.DelElem +"']").remove();
				$('#num_atts').html(data.message.NumAtts);
			}
		}
		
	});

	function like(comment_id, change_span){
			data =  '&comment_id=' + comment_id;
			data +=  '&user_id=' + <?=$user_id?>;
			data +=  '&events_id=' + <?=$event->id_events?>;
			$.ajax({
			type: "POST",
			dataType: "json",
			url: '<?=base_url('ajax/like')?>',
			data: data,
			success: function(obj){
				if(obj['result'] == 1){

					socket.emit('likeComment', {message: {
										Channel:'wall2all<?=$event->id_events?>',
										Like: obj['like'],
										Comment_id:comment_id
									}}  
						   );				 

				}else{
					alert('You cannot like two times the same comment!');
				}
			}
			});
	}						

	function delete_comment(comment_obj) {
			  var comment_id = comment_obj.attr('rel');
				data =  '&comment_id=' + comment_id;
				data +=  '&user_id=' + <?=$user_id?>;
				data +=  '&events_id=' + <?=$event->id_events?>;
				$.ajax({
				type: "POST",
				dataType: "json",
				url: '<?=base_url('ajax/delete_comment')?>',
				data: data,
				success: function(obj){
				   if(obj['result'] == 1){
					socket.emit('deleteComment', {message: {
										Channel:'wall2all<?=$event->id_events?>',
										DeletePost: comment_id
									}}  
						   );				 
					 
					 alert('You successfully deleted !');
				   }else{
					   return false;
				   }
				}
				});	
	}						
	
	function afterSubmit(){
		var userName = '';
		var userImg = '';
		var admin = '';
	    var comment = $('#comment_val').val();

		/**
			Values after submitting comment
		*/
		<?php if($this->logged_in):?>
		userName = '<?=$this->session->userdata('username')?>';
		userImg ='<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/users_img/<?=$this->session->userdata('img')?>&amp;w=57&amp;h=57&amp;zc=1&amp;aoe=1&amp;fltr[]=wmt||15|C|FFFFFF|arial.ttf|100|100||000000|100|x" />';
		<?php elseif($this->facebook_admin):?>
		userName = '<?=$this->session->userdata('facebook_username')?>';
		userImg ='<img src="http://graph.facebook.com/<?=$this->session->userdata('facebook_username')?>/picture" />';
		<?php elseif($this->twitter_admin):?>
		userName = '<?=$this->session->userdata('twitter_username')?>';
		userImg ='<img src="<?=$this->session->userdata('twitter_img')?>" />';
		<?php endif; ?>	 
		<?php if($this->master_admin):?>
		   admin = '-alter';
		<?php endif; ?>		
		
		<?php if(isset($post_comments)):?>
			var comment_local = '<?=$user_comment?>';
			var images_sum_local = '<a class="groupComment" href="<?=base_url()?>assets/comments_img/<?=$user_imagename?>" >';
				images_sum_local += '<img src="/phpThumb/phpThumb.php?src=/assets/comments_img/<?=$user_imagename?>&w=485&aoe=1" />';																
				images_sum_local += '</a>';	
			var comment = comment_local + '<div class="imgInc">'+ images_sum_local +'</div>';
	   <?php endif; ?>

	   
		var spec_data =  '&comment=' + encodeURIComponent(comment);
		spec_data +=  '&events_id=' + <?=$event->id_events?>;
		spec_data +=  '&user_id=' + <?=$user_id?>;
	   
	   $.ajax({
				type: "POST",
				async: false,
				dataType: "json",
				url: '<?=base_url('ajax/insert_comments')?>',
				data: spec_data,
				success: function(obj){
					
					if(obj){
						var scope_comments_id = obj['inserted_id'];
						var last_div_id = parseInt($("#push_comments li:first").attr("data-id"));
						var last_div_id_incrementedByOne = last_div_id + 1;	
						
						socket.emit('chat', {message: {
												Channel:'wall2all<?=$event->id_events?>',
												Comment: comment,
												UserName: userName,
												UserImg: userImg,
												Admin: admin,
												Comments_id: scope_comments_id
											}}  
								   );							
						$('#comment_val').val('');
					}else{
					   return false;
					}
			}
	   });									
	}
	
	function poll(grade,distinguish,insert_impressions_poll,resetVal) {
		data =  '&grade=' + grade;
		data +=  '&distinguish=' + distinguish;
		data +=  '&events_id=' + <?=$event->id_events?>;
		data +=  '&user_id=' + <?=$user_id?>;
			$.ajax({
			type: "POST",
			dataType: "json",
			url: '<?=base_url('ajax/poll')?>',
			data: data,
			success: function(obj){
				if(obj['result'] == 1){
					if(distinguish == 0){
						var id_poll = 'poll_0';
					}else if(distinguish == 1){
						var id_poll = 'poll_1';
					}else{
						var id_poll = 'poll_2';
					}
					resetVal.val(0);
					socket.emit('rateEvent', {message: {
								Channel:'wall2all<?=$event->id_events?>',
								EventGrade: obj['average'],
								Id_poll:id_poll
							}}  
				   );				 
 
				}else{
					  return false;
				  }
				}
			});	
	}					

	function attending(att) {
				
			if(att == 0){
				 data =  '&att=' + 1;
				 var url = '<?=base_url('ajax/attending_insert')?>';
			}else if(att == 1){
				 data =  '&att=' + 0;
				 var url = '<?=base_url('ajax/attending_update')?>';
			}else if(att == 2){
				 data =  '&att=' + 1;
				 var url = '<?=base_url('ajax/attending_update')?>';
			}
			
			data +=  '&events_id=' + <?=$event->id_events?>;
			data +=  '&user_id=' + <?=$user_id?>;
				
			$.ajax({
				type: "POST",
				dataType: "json",
				url: url,
				data: data,
				success: function(obj){
					var html = '';
	
					if(obj){
						
						var htmlDeliver='';
						<?php if($this->logged_in):?>
							  htmlDeliver +='<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/users_img/<?=$this->session->userdata('img')?>&amp;w=57&amp;h=57&amp;zc=1&amp;aoe=1&amp;fltr[]=wmt||15|C|FFFFFF|arial.ttf|100|100||000000|100|x" rel="<?=$user_id?>" />';
						<?php elseif($this->facebook_admin):?>
							  htmlDeliver +='<img src="http://graph.facebook.com/<?=$this->session->userdata('facebook_username')?>/picture" rel="<?=$user_id?>" />';
						<?php elseif($this->twitter_admin):?>
							  htmlDeliver +='<img src="<?=$this->session->userdata('twitter_img')?>" rel="<?=$user_id?>" />';
						<?php endif; ?>												
						
						
						if(obj['result'] == 1){
							
							$('#attending-button').html('I\'m attending');
							$('#attending-button').addClass('iamattending');	
							$('#attending-button').attr('rel',obj['att']);			
							socket.emit('Attending', {message: {
										Channel:'wall2all<?=$event->id_events?>',
										HtmlNode: htmlDeliver,
										DelElem: 0,
										NumAtts: obj['num_atts']
									}}  
							);				 

						}else if(obj['result'] == 2){
						
							$('#attending-button').html('Attend');
							$('#attending-button').removeClass('iamattending');	
							$('#attending-button').attr('rel',obj['att']);	
							socket.emit('Attending', {message: {
										Channel:'wall2all<?=$event->id_events?>',
										HtmlNode: htmlDeliver,
										DelElem: <?=$user_id?>,
										NumAtts: obj['num_atts']
									}}  
							);				 
						
						}else if(obj['result'] == 3){
						
							$('#attending-button').html('I\'m attending');
							$('#attending-button').addClass('iamattending');	
							$('#attending-button').attr('rel',obj['att']);	
							socket.emit('Attending', {message: {
										Channel:'wall2all<?=$event->id_events?>',
										HtmlNode: htmlDeliver,
										DelElem: 0,
										NumAtts: obj['num_atts']
									}}  
							);				 
												
						}
					
					}else{
						return false;
					}
				
				  }
			});
	}


	function checkLastId(data){
	
	   var scope_comments_id = data.Comments_id;
	   var last_div_id = parseInt($("#push_comments li:first").attr("data-id"));
	   var last_div_id_incrementedByOne = last_div_id + 1;
	   
	   if(last_div_id_incrementedByOne === scope_comments_id){
		   
		   var comment_caught = '<li class="ten columns alpha omega post'+data.Admin+' delete" data-id="'+scope_comments_id+'" ><div class="bouble"><h3>'+ data.UserName +'</h3>'+data.Comment ;
			   comment_caught += '<span class="meta">'+currentTime()+ '| <a href="" class="user_like" rel="'+scope_comments_id+'"> Like </a> | <a href="" class="user_report" rel="'+scope_comments_id+'"> Report </a>';
		   <?php if($this->master_admin):?>
			   comment_caught +='<a href="" class="user_comm_delete" rel="'+scope_comments_id+'"> | Delete</a>';
			<?php endif; ?>
			comment_caught += soc_post +'</span></div>'
			comment_caught += data.UserImg +'</li>';
			if(scope_comments_id === parseInt($("#push_comments li:first").attr("data-id")) + 1){
			  $('#push_comments').prepend(comment_caught);
			}
	  
	   }else{
			/**
				In the case when id doesn't match the last one from the DOM!
			*/
			ajax_comments(last_div_id, true);
	   
	   }
	   
	}
	

});</script>


<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '123275541154765', // App ID
      channelUrl : '<?=base_url()?>channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    // Additional initialization code here
  };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));

</script>
 <?php /*echo $map['js'];*/ ?>	
    <div class="container">
		<div class="sixteen columns event">
			<div class="eleven columns alpha omega">
				<div class="ten columns alpha omega content">
				
						<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/evt_logo_img/<?=$event->logo_events?>&w=102&h=102&zc=1&aoe=1" alt="thumbnail" class="profile-image"/>
				
						<h1><?=$event->title_events?></h1>
						<h2><a href="<?=base_url()?>venues/detail/<?=$event->id_venues?>">@<?=$event->place?></a></h2>						
						<!--<a href="#" id="following_event" class="follow-button" <?=($following)?' rel="1"':' rel="0"'?>><?=($following)?'Followed':'Following'?></a>-->
						
						<div class="clear"></div>
						
						<ul class="ten columns alpha omega tabs">
						  <li><a class="active" href="#activity">Posts</a></li>
						  <li><a href="#desc">Description</a></li>
						  <li><a id="map_block" href="#map">Map</a></li>
						  <li><a href="#gallery">Gallery</a></li>
                          <?php if(($event->youtube_events != '')||($event->vimeo_events != '')): ?>
						  <li><a href="#video">Video</a></li>
                          <?php endif; ?>
						</ul>
						<ul class="ten columns alpha omega tabs-content">
						  <li class="active" id="activity">
						  	<ul class="ten columns alpha omega posts">
						  		<li class="update">
                                <?php if(($logged_in)||($face_logged_in)||($twit_logged_in)): ?>
                                    <!--<form id="give_comment" action=""  method="post">-->
                                     <?php
                                     $attr = array(
									        'id'=>'give_comment',
                                            'name' => 'upload'
                                            );
                                     echo form_open_multipart(base_url().'node.js/'.$event->url_title, $attr);
				
									   $hidden_data = array(
												  'id_of_user'  => $user_id,
												  'id_of_event'=> $event->id_events
												);
									
									   echo form_hidden($hidden_data);
             							 
									 ?>
						  			<textarea name="comment_val" id="comment_val" class="ten columns alpha omega" placeholder="Write a comment..."></textarea>
                                    <div class="clear"></div>
                                    <div id="fileup"><div id="upload-loader"></div>
                                      <?php echo form_upload('userfile'); ?> 
                                    </div>
                                    <div id="charsLeft"></div>
                                    <script type="text/javascript">
										$('#comment_val').limit('240','#charsLeft');
									</script>
                                    <div id="submit_comment">
                                    <input type="submit" name="upload" value="submit" />
                                    </div>
                                    <div id="upload_images">
 									      <div class="photo_button_img"></div>                              
                                    </div>
                                    </form>
                                    
                                 <?php else: ?>

                                    <form id="give_comment" action=""  method="post">
						  			<textarea id="comment_val" class="ten columns alpha omega" placeholder="Please login to give comments!"></textarea>
                                    </form>
                                    
                                 <?php endif; ?><div class="clear"></div>
						  		</li>
                                
<div id="push_comments"><div id="ajax-post-waiting-loader"></div>
</div>    
<div class="load_more_ajax"><a href="#" rel="0">More posts...</a></div>

                            
						  	</ul>
						  </li>
						  <li id="desc">
						  <?=$event->description_events?>
						  </li>
                       
						  <li id="map">
						  	<div id="map_canvas"><?php echo $map['html']; ?></div>
						  </li>
                          <!--Start Gallery-->
						  <li id="gallery">
                              

                         
                          
                          <!--start DIVgallery-->
                            <div id="galleryDetailsView" >
                              <?php foreach($event_imgs as $event_img): ?>
                              <div class="imgThumbView" >
                              <a class="group1" href="<?=base_url()?>assets/evt_logo_img/<?=$event_img->img_name?>" title="<?=$event_img->img_title?>">
                               <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/evt_logo_img/<?=$event_img->img_name?>&w=130&h=130&zc=1&aoe=1" />
                               </a>
                              </div>
                              <?php endforeach; ?>
                          
                                 <div class="clear"></div>
                            </div>
                            <!--end DIVgallery-->
                          </li>
                          <!--End Gallery-->
                          <!--start DIVvideo-->
						  <li id="video">
                             <?php if($event->youtube_events != ''): ?>
                             <div id="youtubeFrame">
                              
                              <iframe class="video" width="580" height="350" src="<?=youtube_segment($event->youtube_events)?>" frameborder="0"  allowfullscreen></iframe>
                             </div>
                             <?php endif; ?>
                             <?php if($event->vimeo_events != ''): ?>
                             <div id="vimeoFrame">
                             <iframe src="<?=str_replace("http://vimeo.com/", "http://player.vimeo.com/video/", $event->vimeo_events.'?wmode=transparent')?>" width="580" height="350" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                             </div>
                             <?php endif; ?>
                          </li>
                          <!--end DIVvideo-->
						</ul>
							
				</div>
			</div>
			<div class="five columns sidebar omega">
				<div class="five columns alpha omega attending ">
					<a href="#" class="attending-button<?=($rel==1)?' iamattending':''?>" id="attending-button" rel="<?=$rel?>"><?=($rel==1)?'I\'m attending':'Attend'?></a>
				</div>
				<div class="five columns alpha omega rating moment">
					<h3>Rate Event at this moment</h3>
					<select id="rate_event" class="three columns add alpha omega rate rate_event" rel="<?=($this->common_logged_in)?1:0?>">
					    <option value="0">0</option>
					    <option value="1">1</option>
					    <option value="2">2</option>
					    <option value="3">3</option>
					    <option value="4">4</option>
					    <option value="5">5</option>
					</select>					
					<div class="two columns alpha omega rate-total insert_impressions_poll" id="poll_0" ><?=$average?></div>
				</div>
                <?php if($event->poll1 != ''): ?>
				<div class="five columns alpha omega rating question">
					<h4><?=($event->poll1)?$event->poll1:'Not set'?></h4>
					<select class="three columns add alpha omega rate rate_event poll1" rel="<?=($this->common_logged_in)?1:0?>" >
					    <option value="0">0</option>
					    <option value="1">1</option>
					    <option value="2">2</option>
					    <option value="3">3</option>
					    <option value="4">4</option>
					    <option value="5">5</option>
					</select>					
					<div class="two columns alpha omega rate-total insert_impressions_poll" id="poll_1" ><?=$poll1?></div>
				</div>
                <?php endif; ?> 
                <?php if($event->poll2 != ''): ?>
 				<div class="five columns alpha omega rating question">
					<h4><?=($event->poll2)?$event->poll2:'Not set'?></h4>
					<select class="three columns add alpha omega rate rate_event poll2" rel="<?=($this->common_logged_in)?1:0?>" >
					    <option value="0">0</option>
					    <option value="1">1</option>
					    <option value="2">2</option>
					    <option value="3">3</option>
					    <option value="4">4</option>
					    <option value="5">5</option>
					</select>					
					<div class="two columns alpha omega rate-total insert_impressions_poll" id="poll_2" ><?=$poll2?></div>
				</div> 
                <?php endif; ?>
                <?php if(!empty($event->live_video)): ?>
                 <div class="five columns alpha omega live-video-box">
                      <?=$event->live_video?>
                 </div>               
                <?php endif; ?>
				<div class="five columns alpha omega followers-list">
					<h2 id="num_atts"><?=$num_attendings?></h2>
					<h3>attending</h3>
					<div class="five columns alpha omega people" id="thumb_att">
                      <?php foreach($attendings as $attending): ?>
						  <?php if(($attending['facebook_id']==0)&&($attending['twitter_id']==0)):?>
                                <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/users_img/<?=$attending['img']?>&amp;w=42&h=42&zc=1&amp;aoe=1&fltr[]=wmt||15|C|FFFFFF|arial.ttf|100|100||000000|100|x" alt="thumbnail" rel="<?=$attending['id']?>" />                    
                          <?php elseif($attending['facebook_id']!=0):?>
                                <img src="http://graph.facebook.com/<?=$attending['username']?>/picture" rel="<?=$attending['id']?>" />
                          <?php elseif($attending['twitter_id']!=0):?>
                                <img src="<?=$attending['img']?>" rel="<?=$attending['id']?>" />                     
                          <?php endif; ?>
					  <?php endforeach; ?>
					</div>
				</div>
                <?php if($event->banner_imgE != ''): ?>
                <div class="five columns alpha omega ">
                   <?php if($event->url_bannerE):?>
                   <a href="<?=$event->url_bannerE?>" >
                   <?php endif; ?>
                   <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/banners/<?=$event->banner_imgE?>&amp;w=280&amp;aoe=1" />
                   <?php if($event->url_bannerE):?>
                   </a>
                   <?php endif; ?>             
                </div>
                <?php endif; ?>
            </div>
		</div>
	</div>
    <div id="ajax-comments-loader"></div>
<script>
var intOf_wallpost = false;

!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
function clearButton(){
  intOf_wallpost = setInterval(enableButton,2);
}
function enableButton(){
	  $("input[type=submit]").attr("disabled", false);
	  clearInterval(intOf_wallpost);
}

function blockUser(){
	data =  '&user_id=' + <?=$user_id?>;
		$.ajax({
			   
				type: "POST",
				dataType: "json",
				async: false,
				url: '<?=base_url('ajax/blockUser')?>',
				data: data,
				success: function(obj){

					if(obj['result'] == 1){
						
						is_blocked = 1;
					
					 }else{
						
						is_blocked = 0; 
					
					}
				  
				}
			
			});
}
function printHTML(obj, imparity, lastID){
				var comment_ajax = '';
				var admin_is = '';
				$(obj).each(function(i, d){	
				
				         admin_is = (d.is_admin==3)?'-alter':'';	 
						 comment_ajax += '<li class="ten columns alpha omega post'+ admin_is +' delete"  data-id="'+ d.id_comments +'" ><div class="bouble"><h3>'+ d.username +'</h3>'+d.comment;
						 comment_ajax += '<span class="meta">'+d.comment_date_post ;
   
						
						 comment_ajax += '<a href="" class="user_like" rel="'+ d.id_comments +'"> | Like '+d.like+'</a>';
						
						
						 if((d.id_abused_comments!== undefined)&&(d.id_abused_comments!==null)){
							 comment_ajax += '| Reported';
						 }else{
						 	 comment_ajax += '<a href="" class="user_report" rel="'+ d.id_comments +'"> | Report</a>';
						 }
						
						<?php if($this->master_admin): ?>
						   comment_ajax += '<a href="" class="user_comm_delete" rel='+d.id_comments+'> | Delete</a>';
						<?php elseif(($this->common_logged_in)&&($this->master_admin==FALSE)): ?>
						  if(d.comments_users_id == <?=$user_id?> ){
						   comment_ajax += '<a href="" class="user_comm_delete" rel='+d.id_comments+'> | Delete</a>';
						  }
						<?php endif; ?>
						<?php if($face_logged_in): ?>
						   comment_ajax += '<a href="" class="user_facebook_post" rel=""> | Facebook post to wall</a>';
						<?php endif; ?>
						<?php if($twit_logged_in): ?>
						  comment_ajax += ' | <a href="" class="tweet-click" >Tweet</a>';
						<?php endif; ?>
    
                         comment_ajax += '</span></div>';
						 
						 
						comment_ajax += '<img alt="thumbnail" src="';
						if(d.facebook_id != 0){
						 comment_ajax += 'http://graph.facebook.com/'+d.username+'/picture';
						} else if(d.twitter_id != 0){ 
						 comment_ajax += d.img;
						}else{
						comment_ajax += '<?=base_url()?>phpThumb/phpThumb.php?src=/assets/users_img/'+ d.img + '&amp;w=57&h=57&zc=1&amp;aoe=1&fltr[]=wmt||15|C|FFFFFF|arial.ttf|100|100||000000|100|x';
						}
						comment_ajax += '" /></li>';
						
				});
				        
					$('#ajax-comments-loader').css('display','none');
					
					if(imparity === true){	
					
						 if(parseInt(lastID) === parseInt($("#push_comments li:first").attr("data-id"))){
							$('#push_comments').prepend(comment_ajax);
						 }				
					   
					}else{
						
					      $('#push_comments').append(comment_ajax);
						
					}

	
}
function ajax_comments(lastID, imparity){
	
	        
	        if((lastID == false)||(isNaN(lastID))){
				lastID = 'false';
				imparity = false;
			}

			data =  '&events_id=' + <?=$event->id_events?>;
			data +=  '&lastID=' + lastID;
			if(imparity === true){
				data +=  '&imparity=' + 1;
			}else{
				data +=  '&imparity=' + 0;
			}
			
			
			$.ajax({
			type: "POST",
			async: false,
			dataType: "json",
			url: '<?=base_url('ajax/ajax_comments_pagination')?>',
			data: data,
			/*cache:false,*/
			success: function(obj){
             
               if(obj['result'] == 1){

					printHTML(obj['comments'], imparity, lastID);

			   }else{
				   
				   $('#ajax-comments-loader').css('display','none');
				   return false;
			   
			   }
			}
			});	

}
function insert_comments(comment) {
	
		data =  '&comment=' + encodeURIComponent(comment);
		data +=  '&events_id=' + <?=$event->id_events?>;
		data +=  '&user_id=' + <?=$user_id?>;
	
	   $.ajax({
				type: "POST",
				dataType: "json",
				async: false,
				url: '<?=base_url('ajax/insert_comments')?>',
				data: data,
				success: function(obj){
				}
			
	  });
	
}

function following() {
	
		    data =  '&events_id=' + <?=$event->id_events?>;
		    data +=  '&user_id=' + <?=$user_id?>;
			$.ajax({
			type: "POST",
			dataType: "json",
			url: '<?=base_url('ajax/following')?>',
			data: data,
			success: function(obj){

              if(obj['result'] == 1){
                 
				 $('#following_event').html('Followed');
				 $('#following_event').attr('rel','1');
				 alert('You successfully followed!');
			}else{
				  return false;
			  }
			}
			});
}

function report(comment_id, change_span){
			data =  '&comment_id=' + comment_id;
		    data +=  '&user_id=' + <?=$user_id?>;
			data +=  '&events_id=' + <?=$event->id_events?>;
			$.ajax({
			type: "POST",
			dataType: "json",
			url: '<?=base_url('ajax/report')?>',
			data: data,
			success: function(obj){
				if(obj['result'] == 1){
					change_span.replaceWith(' | Reported');
					alert('You successfully reported abuse!');
				}else{
					return false;
				}
			}
			});
}
function fb_publish(postToFace){
	FB.ui(
	  {
		method: 'feed',
		name: '<?=$event->title_events?>',
		link: '<?=base_url()?><?=$event->url_title?>',
		picture: '<?=base_url()?>assets/evt_logo_img/<?=$event->logo_events?>',
		caption: 'Walltoall.com',
		description: postToFace,
	  },
	  function(response) {
		if (response && response.post_id) {
		  alert('Post was published.');
		} else {
		  alert('Post was not published.');
		}
	  }
	);	  
}
function return_next_set_of_comments(){
	$('#ajax-comments-loader').css('display','block');
	if($('#push_comments li:last-child').attr('data-id')){
		ajax_comments($('#push_comments li:last-child').attr('data-id'), false);
	}
}
  
$(window).load(function () {
	
	$('#ajax-post-waiting-loader').css('display','none');
	$('.load_more_ajax').css('display','block');
	
	//ajax_comments(false, false);
	
	if (navigator.userAgent.match(/Opera Mini/i)) {
	   alert("Browser Opera Mini isn't compatible with live chat! Please switch to other browser");
	}
	/**
	 Checking user agent and redirecting!
	*/	
	/*setInterval(function(){
		if (navigator.userAgent.match(/Opera Mini/i)) {
		   window.location = "<?=current_url()?>";
		}
	},10000);*/
	/**
	Setting interval to check last id with last id in db
	*/
	/*setInterval(function(){
		   ajax_comments($("#push_comments li:first").attr("data-id"), true)
	},10000);*/	
	
	$(document).on('click','.load_more_ajax a',function(e){
			e.preventDefault();
            return_next_set_of_comments();
		});

	$(window).scroll(function(){
		if( $(window).scrollTop() == ($(document).height() - $(window).height()) ){
           return_next_set_of_comments();
		}

	});
	
	


});

$(function() {
	
	
//$("input[type=submit]").attr("disabled", true);


		
	//Scroller extending

	//end->Scroller extending
	<?php if($event->event_background_image!=''):?>
   	$("body").ezBgResize({
		img : "<?=base_url()?>assets/background/<?=$event->event_background_image?>",
	}); 
   <?php endif; ?> 
   
   $('.tweet-click').live("click", function(e){
	   e.preventDefault();
	   var thisComment = $(this).parents('.bouble').html();
	   var thisCommentStriped = thisComment.replace(/<(a|span|h3|div).*>.*<\/\1>/gm,'');
	   window.location = "https://twitter.com/share?url=<?=current_url()?>&text="+ encodeURIComponent(thisCommentStriped);
   });	
	
	
	$(".photo_button_img").click(function(e){
		e.preventDefault();
		$('#fileup').show("slow");
	});
	
                       
                                    //Examples of how to assign the ColorBox event to elements
                                    $(".group1").colorbox({rel:'group1',scalePhotos:true, maxWidth:"75%",maxHeight:"90%"});
									$(".groupComment").colorbox({rel:'group1',scalePhotos:true, maxWidth:"75%",maxHeight:"90%"});
                                    /*$(".group2").colorbox({rel:'group2', transition:"fade"});
                                    $(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
                                    $(".group4").colorbox({rel:'group4', slideshow:true});*/
                                    $(".ajax").colorbox();
                                    $(".youtube").colorbox({iframe:true, innerWidth:425, innerHeight:344});
                                    $(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
                                    $(".inline").colorbox({inline:true, width:"50%"});
                                    $(".callbacks").colorbox({
                                        onOpen:function(){ alert('onOpen: colorbox is about to open'); },
                                        onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
                                        onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
                                        onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
                                        onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
                                    });
                                    
                                    //Example of preserving a JavaScript event for inline calls.
                                    
									
									$(".groupComment").live('click',function(e){ 
									     e.preventDefault();
									    $(this).colorbox({open:true});
                                    });
                          

    /**
	   Sending report on comment abuse
	*/
	$('.user_report').live('click', function(e){
		e.preventDefault();
		<?php if($this->common_logged_in):?>
		var comment_id = $(this).attr('rel');
		var change_span = $(this);
		report(comment_id,change_span);
		<?php else:?>
		alert('You need to log in to report this comment!');
		<?php endif;?>		
	});	

<?php if($this->common_logged_in):?>	
	$('.user_facebook_post').live('click', function(e){
		e.preventDefault();
		var postToFace = $(this).parents('.bouble').html();
		fb_publish(postToFace);
	});
<?php endif;?>
  // hash change handler
  function hashchange () {
    var hash = window.location.hash
      , el = $('ul.tabs [href*="' + hash + '"]')
      , content = $(hash)

    if (el.length && !el.hasClass('active') && content.length) {
      el.closest('.tabs').find('.active').removeClass('active');
      el.addClass('active');


      content.show().addClass('active').siblings().hide().removeClass('active');
	      if(content.attr('id')===$('#map').attr('id')){

//		  var center = map.getCenter(); 
//          google.maps.event.trigger(map, 'resize'); 
//		  map.setCenter(center);

	     }  
    }
  }

  // listen on event and fire right away
  $(window).on('hashchange.skeleton', hashchange);
  hashchange();
  $(hashchange);
  
  
});
</script>

