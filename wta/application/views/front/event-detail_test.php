<script>
var is_blocked = 1;
var images_sum = '';
var soc_post = '';

	   	<?php if($face_logged_in): ?>
			  soc_post = '| <a href="" class="user_facebook_post" rel=""> | Facebook post to wall</a>';
		<?php endif; ?>
	   	<?php if($twit_logged_in): ?>
			  soc_post = '| <a href="https://twitter.com/share" class="twitter-share-button" data-text="<?=$event->title_events?>" data-via="IlyaWolf">Tweet</a>';
		<?php endif; ?>
		
function release_ape(){ 		
        
		var scope_comments_id_ape = false;

		var client = new APE.Client();
		
		client.load();
		
		client.addEvent('load', function() {
			client.core.start({'name': String((new Date()).getTime()).replace(/D/gi,'')});
		});
		
         client.addEvent('ready', function() {

				client.core.join('wall2all<?=$event->id_events?>');
 

                client.addEvent('multiPipeCreate', function(pipe, options) {
					 
						$.ajax({
							type: "POST",
							dataType: "json",
							url: '<?=base_url('ajax/init_id')?>',
							success: function(obj){
							scope_comments_id_ape = obj;
							}
						});	
						 
						
						$('.user_like').live('click', function(e){
							e.preventDefault();
							<?php if($this->common_logged_in):?>
							var comment_id = $(this).attr('rel');
							var change_span = $(this);
							like(comment_id,change_span);
							<?php else:?>
							alert('You need to log in to rate this comment!');
							<?php endif;?>
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
												$("a.user_like[rel='"+ comment_id+"']").html(' | Like '+obj['like']);
//												var apeLike = '{"like":"'+obj['like']+'","id_like":"'+comment_id+'"}';
												var apeLike = JSON.stringify({"like": obj['like'] , "id_like": comment_id });
												pipe.send(apeLike);
											}else{
												alert('You cannot like two times the same comment!');
											}
										}
										});
							}						
						
						$('#attending-button').live('click', function(e){
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
												
												$(obj['atts']).each(function(i, d){	
															
													if((d.facebook_id == 0)&&(d.twitter_id == 0)){
													
														html +='<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/users_img/'+d.img+'&amp;w=42&h=42&zc=1&amp;aoe=1&fltr[]=wmt||15|C|FFFFFF|arial.ttf|100|100||000000|100|x" alt="thumbnail" rel="'+d.id+'" />';
													
													}else if(d.facebook_id != 0){
														
														html +='<img src="http://graph.facebook.com/'+d.username+'/picture" rel="'+d.id+'" >';
													
													}else if(d.twitter_id != 0) {
													
														html +='<img src="'+d.img+'" rel="'+d.id+'" >';
													
													}
												
												});		
											
											    var htmlDeliver='';
												<?php if($this->logged_in):?>
												      htmlDeliver +='<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/users_img/<?=$this->session->userdata('img')?>&amp;w=57&amp;h=57&amp;zc=1&amp;aoe=1&amp;fltr[]=wmt||15|C|FFFFFF|arial.ttf|100|100||000000|100|x" rel="<?=$user_id?>" />';
												<?php elseif($this->facebook_admin):?>
												      htmlDeliver +='<img src="http://graph.facebook.com/<?=$this->session->userdata('facebook_username')?>/picture" rel="<?=$user_id?>" />';
												<?php elseif($this->twitter_admin):?>
												      htmlDeliver +='<img src="<?=$this->session->userdata('twitter_img')?>" rel="<?=$user_id?>" />';
												<?php endif; ?>												
												var htmlEscaped = htmlDeliver.replace(new RegExp('"','gm'),'~');
												
												
												
												if(obj['result'] == 1){
													
													$('#thumb_att').html(html);		
													$('#attending-button').html('I\'m attending');
													$('#attending-button').addClass('iamattending');	
													$('#attending-button').attr('rel',obj['att']);			
													$('#num_atts').html(obj['num_atts']);
													var apeAttending = '{"htmlApe":"'+htmlEscaped+'", "delElem":"0", "numAtts":"'+obj['num_atts']+'" }';
										            pipe.send(apeAttending);
												
												}else if(obj['result'] == 2){
												
													$('#thumb_att').html(html);		
													$('#attending-button').html('Attend');
													$('#attending-button').removeClass('iamattending');	
													$('#attending-button').attr('rel',obj['att']);	
													$('#num_atts').html(obj['num_atts']);
													var apeAttending = '{"htmlApe":"opt", "delElem":"<?=$user_id?>", "numAtts":"'+obj['num_atts']+'" }';
										            pipe.send(apeAttending);													
												
												}else if(obj['result'] == 3){
												
													$('#thumb_att').html(html);		
													$('#attending-button').html('I\'m attending');
													$('#attending-button').addClass('iamattending');	
													$('#attending-button').attr('rel',obj['att']);	
													$('#num_atts').html(obj['num_atts']);
													var apeAttending = '{"htmlApe":"'+htmlEscaped+'", "delElem":"0", "numAtts":"'+obj['num_atts']+'" }';
										            pipe.send(apeAttending);													
												
												}
											
											}else{
												return false;
											}
										
										  }
									});
							}
						
					  	
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
									   
									    insert_impressions_poll.html(obj['average']);
										if(distinguish == 0){
											var id_poll = 'poll_0';
										}else if(distinguish == 1){
											var id_poll = 'poll_1';
										}else{
											var id_poll = 'poll_2';
										}
										resetVal.val(0);
//										var eventGradeApe = '{"eventGradeApe":"'+obj['average']+'", "id_poll":"'+id_poll+'" }';
										var eventGradeApe = JSON.stringify({"eventGradeApe": obj['average'] , "id_poll": id_poll });
										pipe.send(eventGradeApe);
										  
									}else{
										  return false;
									  }
									}
									});	
							}					
						
						$('.user_comm_delete').live('click', function(e){
								blockUser();
								if(is_blocked == 1){
									e.preventDefault();
									/*var comment_id = $(this).attr('rel');
									delete_comment(comment_id);
									$(this).parents('li .delete').remove();
									var jsonDelId = '{"deletePost":"'+comment_id+'"  }';
									pipe.send(jsonDelId);*/
								    delete_comment($(this));
								
								}else{
									alert('Your username has been blocked by administrator');
								}								
						 });	
						
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
											 comment_obj.parents('li .delete').remove();
//											 var jsonDelId = '{"deletePost":"'+comment_id+'"  }';
											 var jsonDelId = JSON.stringify({"deletePost": comment_id });
											 pipe.send(jsonDelId);
											 alert('You successfully deleted !');
										   }else{
											   return false;
										   }
										}
										});	
							}						
						
						
					$('#give_comment').submit(function(e){
						
						if($('input[name="userfile"]').val()===''){
							
						$("input[type=submit]").attr("disabled", true);
						    clearButton();
                            e.preventDefault();
							blockUser();
							if(is_blocked == 1){
								
								var userName = '';
								var userImg = '';
								var admin = '';
								$('.qq-upload-list').empty();
								/*var comment = bad_words(htmlEncode($('#comment_val').val()),'<?=$badWords?>');
								comment = comment;*/
								var comment = htmlEncode($('#comment_val').val());
								images_sum = '';
								$('#give_comment textarea').val('');
								
								
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
									/*var userImgApe = userImg.replace(new RegExp('"','gm'),'~');
									var commentApe = comment.replace(new RegExp('"','gm'),'~');
									var userNameApe = userName.replace(new RegExp('"','gm'),'~');*/
									
									var userImgApe = userImg;
									var commentApe = comment.replace(new RegExp("'",'gm'),'');
									var userNameApe = userName;
									
//	                                var comment_send = '{"userImg":"'+userImgApe+'", "comment":"'+commentApe+'", "userName":"'+userNameApe+'", "admin":"'+admin+'"}';
//                                    var comment_send = '{userImg:"'+userImgApe+'", comment:"'+commentApe+'", userName:"'+userNameApe+'", admin:"'+admin+'"}';					                
                                    var comment_send = JSON.stringify({"userImg": userImgApe , "comment": commentApe , "userName": userNameApe , "admin": admin });
									
								    
									var spec_data =  '&comment=' + encodeURIComponent(comment);
									spec_data +=  '&events_id=' + <?=$event->id_events?>;
									spec_data +=  '&user_id=' + <?=$user_id?>;
								
								   $.ajax({
											type: "POST",
											dataType: "json",
											url: '<?=base_url('ajax/insert_comments')?>',
											data: spec_data,
											success: function(obj){
												
												if(obj['result'] == 1){
													
													scope_comments_id_ape++;
														
													var comment_add = '<li class="ten columns alpha omega post'+admin+' delete" data-id="'+scope_comments_id_ape+'" ><div class="bouble"><h3>'+userName+'</h3>'+comment;
													comment_add += '<span class="meta">'+currentTime()+ '| <a href="" class="user_like" rel="'+scope_comments_id_ape+'"> Like </a> | <a href="" class="user_report" rel="'+scope_comments_id_ape+'"> Report </a>';
													comment_add +='<a href="" class="user_comm_delete" rel="'+scope_comments_id_ape+'"> | Delete</a>'
													comment_add += soc_post +'</span></div>'
													comment_add += userImg +'</li>';
													pipe.send(comment_send);
													$('#push_comments').prepend(comment_add);												
													
												}else{
												   return false;
												}
										}
								   });									
									
								
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
						
						             var userName_local = '';
									 var userImg_local = '';
									 var admin_local = '';	
									 var comment_local  = '';
									     comment_local += '<?=$user_comment?>';
									 var images_sum_local = '<a class="groupComment" href="<?=base_url()?>assets/comments_img/<?=$user_imagename?>" >';
									     images_sum_local += '<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/comments_img/<?=$user_imagename?>&w=485&aoe=1" />';																
									     images_sum_local += '</a>';	
									 
									 
									 comment_local = comment_local + '<div class="imgInc">'+ images_sum_local +'</div>';						
						             
									 
						
								         
								    <?php if($this->logged_in):?>
									userName_local = '<?=$this->session->userdata('username')?>';
									userImg_local ='<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/users_img/<?=$this->session->userdata('img')?>&amp;w=57&amp;h=57&amp;zc=1&amp;aoe=1&amp;fltr[]=wmt||15|C|FFFFFF|arial.ttf|100|100||000000|100|x" />';
									<?php elseif($this->facebook_admin):?>
									userName_local = '<?=$this->session->userdata('facebook_username')?>';
									userImg_local ='<img src="http://graph.facebook.com/<?=$this->session->userdata('facebook_username')?>/picture" />';
									<?php elseif($this->twitter_admin):?>
									userName_local = '<?=$this->session->userdata('twitter_username')?>';
									userImg_local ='<img src="<?=$this->session->userdata('twitter_img')?>" />';
									<?php endif; ?>	 
									<?php if($this->master_admin):?>
									   admin_local = '-alter';
									<?php endif; ?>						
						
									/*var userImgApe = userImg_local.replace(new RegExp('"','gm'),'~');
									var commentApe = comment_local.replace(new RegExp('"','gm'),'~');
									var userNameApe = userName_local.replace(new RegExp('"','gm'),'~');
									
	                                var comment_send = '{"userImg":"'+userImgApe+'", "comment":"'+commentApe+'", "userName":"'+userNameApe+'", "admin":"'+admin_local+'"}';*/
									var userImgApe = userImg_local;
									var commentApe = comment_local.replace(new RegExp("'",'gm'),'');
									var userNameApe = userName_local;
                                    var comment_send = JSON.stringify({"userImg": userImgApe , "comment": commentApe , "userName": userNameApe , "admin": admin_local });									
									
									
									//insert_comments(comment_local);
									var spec_data =  '&comment=' + encodeURIComponent(comment_local);
									spec_data +=  '&events_id=' + <?=$event->id_events?>;
									spec_data +=  '&user_id=' + <?=$user_id?>;
								
								   $.ajax({
											type: "POST",
											dataType: "json",
											url: '<?=base_url('ajax/insert_comments')?>',
											data: spec_data,
											success: function(obj){
												
												if(obj['result'] == 1){
													
													pipe.send(comment_send);
										            scope_comments_id_ape++;
									
													var comment_add = '<li class="ten columns alpha omega post'+admin_local+' delete" data-id="'+scope_comments_id_ape+'" ><div class="bouble"><h3>'+userName_local+'</h3>'+comment_local;
													comment_add += '<span class="meta">'+currentTime()+ '| <a href="" class="user_like" rel="'+scope_comments_id_ape+'"> Like </a> | <a href="" class="user_report" rel="'+scope_comments_id_ape+'"> Report </a>';
													comment_add +='<a href="" class="user_comm_delete" rel="'+scope_comments_id_ape+'"> | Delete</a>'
													comment_add += soc_post +'</span></div>'
													comment_add += userImg_local +'</li>';
									
									                $('#push_comments').prepend(comment_add);													
													
												}else{
												   return false;
												}
										}
								   });
						<?php endif; ?>
					
							function bad_words(str,bwArray){
								
								var arr = bwArray.split(", ");
							
								for(i=0;i<arr.length;i++ ){
									 var re = new RegExp(arr[i], "gi");
									 str = str.replace(re,'...');
								}
								return str;
							}	
				});
				
                client.onRaw('data', function(raw, pipe) {
  						if(raw.data.msg !== undefined){
							
							/*var outputM = jQuery.parseJSON(decodeURIComponent(raw.data.msg));
							 console.log(outputM); */ 
							var outputM = JSON.parse(decodeURIComponent(raw.data.msg));
							
							   if(outputM.deletePost !== undefined){ 
								
									 $(".delete[data-id='"+ outputM.deletePost +"']").remove();
								
							   }else if(outputM.eventGradeApe !== undefined) {
								   
								     $('#'+ outputM.id_poll).html(outputM.eventGradeApe);
								   
							   }else if(outputM.htmlApe !== undefined){
								   
							        if(outputM.delElem == 0){
										$('#thumb_att').append(outputM.htmlApe.replace(/~/g,'"'));
										$('#num_atts').html(outputM.numAtts);
									}else{
									    $("img[rel='"+ outputM.delElem +"']").remove();
										$('#num_atts').html(outputM.numAtts);
									}
							   
							   }else if(outputM.userImg !== undefined){
								    scope_comments_id_ape++;
									
								    var comment_caught= '<li class="ten columns alpha omega post'+outputM.admin+' delete" data-id="'+scope_comments_id_ape+'" ><div class="bouble"><h3>'+ outputM.userName +'</h3>'+outputM.comment ;
									comment_caught += '<span class="meta">'+currentTime()+ '| <a href="" class="user_like" rel="'+scope_comments_id_ape+'"> Like </a> | <a href="" class="user_report" rel="'+scope_comments_id_ape+'"> Report </a>';
	                                <?php if($this->master_admin):?>
									   comment_caught +='<a href="" class="user_comm_delete" rel="'+scope_comments_id_ape+'"> | Delete</a>';
									<?php endif; ?>
									comment_caught += soc_post +'</span></div>'
									comment_caught += outputM.userImg +'</li>';
								    $('#push_comments').prepend(comment_caught);
							
							
							   }else if(outputM.like !== undefined){
								   $("a.user_like[rel='"+ outputM.id_like+"']").html('| Like '+outputM.like);
							   }
							

                      }
                 
				});
            });


}
  
</script>


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
 <?php echo $map['js']; ?>	
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
                                     echo form_open_multipart(base_url().$event->url_title, $attr);
				
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
			    <!--<div class="five columns alpha omega followers-list">-->
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
  intOf_wallpost = setInterval(enableButton,5000);
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
function ajax_comments(lastID){
	
	        if(lastID == false){
				lastID = 'false';
			}

			data =  '&events_id=' + <?=$event->id_events?>;
			data +=  '&lastID=' + lastID;
			
			$.ajax({
			type: "POST",
			dataType: "json",
			url: '<?=base_url('ajax/ajax_comments_pagination')?>',
			data: data,
			cache:false,
			success: function(obj){

               if(obj['result'] == 1){
				   var comment_ajax = '';
				   var admin_is = '';
				$(obj['comments']).each(function(i, d){	
				
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
						  comment_ajax += '<a href="https://twitter.com/share" class="twitter-share-button" data-text="<?=$event->title_events?>" data-via="IlyaWolf"> | Tweet</a>';
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
						$('#push_comments').append(comment_ajax);
						
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
					change_span.replaceWith('Reported');
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
		link: '<?=base_url()?>events/detail/<?=$event->id_events?>',
		picture: '<?=base_url()?>assets/evt_logo_img/<?=$event->logo_events?>',
		caption: 'Wall2all',
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
		ajax_comments($('#push_comments li:last-child').attr('data-id'));
	}
}
  
$(window).load(function () {
	
	$('#ajax-post-waiting-loader').css('display','none');
	$('.load_more_ajax').css('display','block');
	ajax_comments(false);
	release_ape();
	
							
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
/*									$("#click").live('click',function(){ 
                                        $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
                                        return false;
                                    });
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
		var postToFace = $(this).parents('.post').children('.txt').html();
		fb_publish(postToFace);
	});
	$('#pagination a').live('click', function(e){
		e.preventDefault();	
	    var page_link = $(this).attr('href');
		if($(this).html() == 1){
		   var offset_part = 0;
		}else{
		   var offset_part = page_link.substring(page_link.lastIndexOf('/') + 1);
		}
		get_pagination_comments(offset_part);
    });	

   $('.follow-button').live('click', function(e){
	   e.preventDefault();
	   if($(this).attr('rel') == 1){
		   return false;
	   }else{
	     following();
	   }
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

		  var center = map.getCenter(); 
          google.maps.event.trigger(map, 'resize'); 
		  map.setCenter(center);

	     }  
    }
  }

  // listen on event and fire right away
  $(window).on('hashchange.skeleton', hashchange);
  hashchange();
  $(hashchange);
  
  
});
</script>

