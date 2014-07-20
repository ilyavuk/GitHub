<script>
function release_ape(){ 		
        
		var scope_comments_id = false;

		var client = new APE.Client();
		
		client.load();
		
		client.addEvent('load', function() {
			client.core.start({'name': String((new Date()).getTime()).replace(/D/gi,'')});
		});
		
         client.addEvent('ready', function() {
			 

				client.core.join('wall2all<?=$event->id_events?>');
 

                client.addEvent('multiPipeCreate', function(pipe, options) {
	
				});
                client.onRaw('data', function(raw, pipe) {
						if(raw.data.msg !== undefined){
							
//							var outputM = jQuery.parseJSON(decodeURIComponent(raw.data.msg));
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
								    /*scope_comments_id++;
									var comment_caught= '<li class="ten columns alpha omega post'+outputM.admin+' delete" data-id="'+scope_comments_id+'" ><div class="bouble"><h3>'+ outputM.userName+'</h3>'+outputM.comment;
									comment_caught += '<span class="meta" rel="'+scope_comments_id+'">'+currentTime();
									comment_caught += '</span></div>'
									comment_caught += outputM.userImg +'</li>';
								    $('#push_comments').prepend(comment_caught);*/	
								   checkLastId(outputM);				
							
							   }
		
                       
                            }	
							
							function checkLastId(outputM){
							   
							   var scope_comments_id_ape = outputM.comments_id;
							   var last_div_id = parseInt($("#push_comments li:first").attr("data-id"));
							   var last_div_id_incrementedByOne = last_div_id + 1;
							   //console.log(scope_comments_id_ape +'--'+ outputM.comments_id +'---'+ outputM.comment );
							   if(last_div_id_incrementedByOne === scope_comments_id_ape){
                                    
									var comment_caught = '<li class="ten columns alpha omega post'+outputM.admin+' delete" data-id="'+scope_comments_id_ape+'" ><div class="bouble"><h3>'+ outputM.userName+'</h3>'+outputM.comment;
									comment_caught += '<span class="meta" rel="'+scope_comments_id_ape+'">'+currentTime();
									comment_caught += '</span></div>'
									comment_caught += outputM.userImg +'</li>';
								    								   
									if(scope_comments_id_ape === parseInt($("#push_comments li:first").attr("data-id")) + 1){
									  $('#push_comments').prepend(comment_caught);
									}
							  
							   }else{
									
									ajax_comments(last_div_id, true);
							   
							   }
							   
						   }
							
											
					
				});
            });
}
</script>

<body class="live">

	<!-- Page
	================================================== -->
	<div class="container top-bottom-space">
		<div class="sixteen columns event live">
			<div class="eleven columns alpha omega">
				<div class="ten columns alpha omega content">
				
				        <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/evt_logo_img/<?=$event->logo_events?>&w=102&h=102&zc=1&aoe=1" alt="thumbnail" class="profile-image"/>

						<h1><?=$event->title_events?></h1>
						<h2><a href="<?=base_url()?>venues/detail/<?=$event->id_venues?>">@<?=$event->place?></a></h2>						
						<h2><a href="<?=base_url().$event->url_title?>"><?=base_url().$event->url_title?></a></h2>
						<div class="clear"></div>
						<p class="urlLive"></p>
					  	<ul class="ten columns alpha omega posts">
<div id="push_comments" class="bigger-letter"><div id="ajax-post-waiting-loader"></div> 
</div>                     	
<div class="load_more_ajax"><a href="#" rel="0">More posts...</a></div>

                    </ul>
				</div>
			</div>
			<div class="five columns sidebar omega live">
				<div class="five columns alpha omega side-logo">
				    <a href="<?=base_url()?>" title="Wall to all">
					<span class="logo"><strong>Wall to All</strong></span>
					</a>
				</div>			
				<div class="five columns alpha omega rating moment">
					<h3>Event rating</h3>				
					<div class="rate-total insert_impressions_poll" id="poll_0" ><?=$average?></div>
				</div>
                <?php if($event->poll1 != ''): ?>
				<div class="five columns alpha omega rating question">
					<h4><?=($event->poll1)?$event->poll1:'Not set'?></h4>					
					<div class="rate-total insert_impressions_poll" id="poll_1" ><?=$poll1?></div>
				</div>
                <?php endif; ?> 
                <?php if($event->poll2 != ''): ?>
				<div class="five columns alpha omega rating question">
					<h4><?=($event->poll2)?$event->poll2:'Not set'?></h4>					
					<div class="rate-total insert_impressions_poll" id="poll_2" ><?=$poll2?></div>
				</div> 
                <?php endif; ?>  
                 <?php if(!empty($event->live_video)): ?>
                 <div class="five columns alpha omega live-video-box">
                      <?=$event->live_video?>
                 </div>               
                <?php endif; ?>
				<div class="five columns alpha omega followers-list">
					<h2 id="num_atts" ><?=$num_attendings?></h2>
					<h3>attending</h3>
					<div class="five columns alpha omega people" id="thumb_att" >
                      <?php foreach($attendings as $attending): ?>
						  <?php if(($attending['facebook_id']==0)&&($attending['twitter_id']==0)):?>
                                <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/users_img/<?=$attending['img']?>&amp;w=42&h=42&zc=1&amp;aoe=1&fltr[]=wmt|<?=user_privilege($attending['is_admin'])?>|15|C|FFFFFF|arial.ttf|100|100||000000|100|x" alt="thumbnail" rel="<?=$attending['id']?>" />                    
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
function printHTML(obj, imparity, lastID){
				var comment_ajax = '';
				var admin_is = '';
				$(obj).each(function(i, d){	
				
				         admin_is = (d.is_admin==3)?'-alter':'';	 
						 comment_ajax += '<li class="ten columns alpha omega post'+ admin_is +' delete"  data-id="'+ d.id_comments +'" ><div class="bouble"><h3>'+ d.username +'</h3>'+d.comment;
						 comment_ajax += '<span class="meta">'+d.comment_date_post ;
    
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
			cache:false,
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



function return_next_set_of_comments(){
	$('#ajax-comments-loader').css('display','block');
	if($('#push_comments li:last-child').attr('data-id')){
		ajax_comments($('#push_comments li:last-child').attr('data-id'),false);
	}
}

$(function() {
   <?php if($event->event_background_image!=''):?>
   	$("body").ezBgResize({
		img : "<?=base_url()?>assets/background/<?=$event->event_background_image?>",
	}); 
   <?php endif; ?> 
});  
   
$(window).load(function () {
	
	$('#ajax-post-waiting-loader').css('display','none');
	$('.load_more_ajax').css('display','block');
	ajax_comments(false,false);
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
</script>
</body>
</html>