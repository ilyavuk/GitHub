	 <?php echo $map['js']; ?>
	<!-- Google Map
	================================================== -->
	<div class="container home">
		<?php echo $map['html']; ?>
	
    </div>

	<!-- Page
	================================================== -->
	<div class="container home-featured">
		<div class="five columns  alpha vignettes-wrapper vignettes-one">
			<h4>Upcoming events</h4>
            <?php if($what_is_news ): ?>
            <?php foreach($what_is_news as $what_is_new):?>
			<div class="five columns alpha omega vignette">
				<a href="<?=base_url()?><?=$what_is_new->url_title?>" ><img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/evt_logo_img/<?=$what_is_new->logo_events?>&amp;w=100&amp;h=100&amp;zc=1&amp;aoe=1" alt="thumbnail" class="two columns alpha omega" /></a>
				<div class="three columns alpha omega">
					<div class="title"><a href="<?=base_url()?><?=$what_is_new->url_title?>" ><?=character_limiter($what_is_new->title_events,15)?></a></div>
					<div class="datetime"><?=date("d.m.Y. | l \a\\t H\h",$what_is_new->start_date)?></div>
					<div class="text"><?=descOptimizer($what_is_new->description_events)?></div>
                    <div class="text"><a href="<?=base_url()?>venues/detail/<?=$what_is_new->id_venues?>" ><?=$what_is_new->place?></a></div>
				</div>
			</div>
            <?php endforeach; ?>  
            <?php endif; ?> 
		</div>
		<div class="five columns vignettes-wrapper vignettes-two">
			<h4>Recommended events</h4>
            <?php foreach($we_recommends as $we_recommend):?>
            <?php if($we_recommend->title): ?>
			<div class="five columns alpha omega vignette">
				<a href="<?=base_url()?><?=$we_recommend->url_title?>" ><img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/evt_logo_img/<?=$we_recommend->logo?>&amp;w=100&amp;h=100&amp;zc=1&amp;aoe=1" alt="thumbnail" class="two columns alpha omega" /></a>
				<div class="three columns alpha omega">
					<div class="title"><a href="<?=$we_recommend->url_title?>" ><?=character_limiter($we_recommend->title,15)?></a></div>
					<div class="datetime"><?=date("d.m.Y. | l \a\\t H\h",$we_recommend->start_date)?></div>
					<div class="text"><?=descOptimizer($we_recommend->description) ?></div>
                    <div class="text"><a href="<?=base_url()?>venues/detail/<?=$we_recommend->venueID?>" ><?=$we_recommend->venuePlace?></a></div>
				</div>
			</div>
            <?php endif; ?>
            <?php endforeach; ?>  
		</div>
		<div class="five columns omega vignettes-wrapper vignettes-three">
			<div class="six columns alpha omega">
              <iframe class="six columns alpha omega video"  height="240" src="<?=youtube_segment($youtube)?>" frameborder="0"  allowfullscreen></iframe>
            </div>
            <div class="six columns alpha omega recent-posts">
					<h4>Recent posts</h4>
                    <?php if($last_posts): ?>
					<?php foreach($last_posts as $last_post):?>
                    <div class="post">
						<span class="name"><?=$last_post->username?></span><span class="text"> <?=word_limiter(strip_tags(walltoall_strip_bad_words($last_post->comment,$bad_words)),3)?></span>
						<div class="datetime"><?=date("F j, Y,G:i:s",$last_post->comment_date_post)?> on <a href="<?=base_url()?><?=$last_post->url_title?>"><?=$last_post->title?></a> event</div>
					</div>
                    <?php endforeach; ?>
                    <?php endif; ?> 
            </div>
	   </div>
   </div>
	<!-- JS
	================================================== -->
<script type="text/javascript">
<?php if(isset($windows)): ?>
<?php foreach($windows as $key =>$window):?>

var popup<?=$key?> = '<?=$window?>';

<?php endforeach; ?>
<?php endif; ?>
<?php if(isset($hwindows)): ?>
<?php foreach($hwindows as $key =>$hwindows):?>

var hover<?=$key?> = '<?=$hwindows?>';

<?php endforeach; ?>
<?php endif; ?>
<?php if($is_center == 'auto'): ?>



	 /*var centerOfMap = false;
	 if (navigator.geolocation)
		{
			
		  navigator.geolocation.getCurrentPosition(
		  function (position) {
			  centerOfMap = new google.maps.LatLng(position.coords.latitude, position.coords.longitude); 
		  });		  
				  
		}
		if(centerOfMap == false){
			 var centerOfMap = new google.maps.LatLng(geoip_latitude(), geoip_longitude());
				
		}
		
	  google.maps.event.trigger(map, 'resize'); 
	  map.setCenter(centerOfMap);
*/

<?php endif; ?>
$(function() {
	
	
	<?php if($background!=''):?>
   	$("body").ezBgResize({
		img : "<?=base_url()?>assets/background/<?=$background?>",
	}); 
   <?php endif; ?> 


});

</script>
	
<!-- End Document
================================================== -->
