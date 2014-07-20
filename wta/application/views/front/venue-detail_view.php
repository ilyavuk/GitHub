<?php echo $map['js']; ?>	
	<div class="container">
		<div class="sixteen columns venue">
			<div class="eleven columns alpha omega">
				<img class="poster" src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/venues_img/<?=$venue->logo?>&w=600&h=250&zc=1&aoe=1" />
				<div class="ten columns alpha omega content">
				
						<h1><?=$venue->place?></h1>
						<h2>
							<?=$venue->address?>, <?=$venue->city?>, <?=$venue->country?><br/>
							<?=$venue->title?><br/>
							<?=($venue->site_url!='')?'<a href="'.prep_url($venue->site_url).'">'.$venue->site_url.'</a>':false?>
						</h2>
						
						<ul class="ten columns alpha omega tabs">
						  <li><a class="active" href="#desc">Description</a></li>
						  <li><a href="#map">Map</a></li>
						  <li><a href="#gallery">Gallery</a></li>
						  <?php if(($venue->youtube != '')||($venue->vimeo != '')): ?>
                          <li><a href="#video">Video</a></li>
                          <?php endif; ?>
						</ul>
						<ul class="ten columns alpha omega tabs-content">
						  <li class="active" id="desc">
						  	<?=$venue->description?>
						  </li>
						  <li id="map">
						  	<div id="map_canvas"><?php echo $map['html']; ?></div>
						  </li>
						  <li id="gallery">
                          
                             <script>
                                $(document).ready(function(){
                                    //Examples of how to assign the ColorBox event to elements
                                    $(".group1").colorbox({rel:'group1',scalePhotos:true, maxWidth:"75%",maxHeight:"90%"});
                                    $(".group2").colorbox({rel:'group2', transition:"fade"});
                                    $(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
                                    $(".group4").colorbox({rel:'group4', slideshow:true});
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
                                    $("#click").click(function(){ 
                                        $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
                                        return false;
                                    });
                                });
                            </script>                         
                             <div id="galleryDetailsView" >
                               <?php foreach($venue_imgs as $venue_img): ?>
                              <div class="imgThumbView" >
                              <a class="group1" href="<?=base_url()?>assets/venues_img/<?=$venue_img->img_name?>" title="<?=$venue_img->img_title?>">
                               <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/venues_img/<?=$venue_img->img_name?>&w=130&h=130&zc=1&aoe=1" />
                               </a>
                              </div>
                              <?php endforeach; ?> 
                                 <div class="clear"></div>
                            </div>                        
                          </li>
						  <li id="video">
                             <?php if($venue->youtube != ''): ?>
                             <div id="youtubeFrame">
                              <iframe class="video" width="600" height="350" src="<?=youtube_segment($venue->youtube)?>" frameborder="0"  allowfullscreen></iframe>
                             </div>
                             <?php endif; ?>
                             <?php if($venue->vimeo != ''): ?>
                             <div id="vimeoFrame">
                             <iframe src="<?=str_replace("http://vimeo.com/", "http://player.vimeo.com/video/", $venue->vimeo.'?wmode=transparent')?>" width="600" height="350" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                             </div>
                             <?php endif; ?>                          
                          
                          
                          </li>
						</ul>
						<?php if($upcoming_events): ?>
						<h4>Upcoming events</h4>
						
                           <?php foreach($upcoming_events as $upcoming_event): ?>
                           <div class="five columns alpha vignette">
							    <a href="<?=base_url().$upcoming_event->url_title?>" >
								<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/evt_logo_img/<?=$upcoming_event->logo?>&w=102&h=102&zc=1&aoe=1" alt="thumbnail" class="two columns alpha omega" />
                                </a>  
                                    <div class="three columns alpha omega">
                                        <a href="<?=base_url().$upcoming_event->url_title?>" >
                                        <div class="title"><?=$upcoming_event->title?></div>
                                        </a> 
                                        <div class="datetime"><?=date("F j, Y",$upcoming_event->start_date)?></div>
                                        <div class="text"><?=descOptimizer($upcoming_event->description)?></div>
                                    </div>
                            </div>
                            <?php endforeach; ?>
					
						<?php endif; ?>
				</div>
			</div>
			<div class="five columns sidebar omega">
               <?php
			   
			      $banners = array(
				                
								0=>($venue->banner_img1!='')?$venue->banner_img1:false,
								1=>($venue->banner_img2!='')?$venue->banner_img2:false,
								2=>($venue->banner_img3!='')?$venue->banner_img3:false,
								3=>($venue->banner_img4!='')?$venue->banner_img4:false,
								4=>($venue->banner_img5!='')?$venue->banner_img5:false,
								5=>($venue->banner_img6!='')?$venue->banner_img6:false,
								   
								);
				
				$banners_url = array(
				                
								0=>($venue->url_banner1!='')?$venue->url_banner1:false,
								1=>($venue->url_banner2!='')?$venue->url_banner2:false,
								2=>($venue->url_banner3!='')?$venue->url_banner3:false,
								3=>($venue->url_banner4!='')?$venue->url_banner4:false,
								4=>($venue->url_banner5!='')?$venue->url_banner5:false,
								5=>($venue->url_banner6!='')?$venue->url_banner6:false,
								   
								);
			   ?>
               <?php foreach($banners as $key=>$banner):?>
               <?php if($banner):?>
				<div class="five columns alpha omega banner">
                   <?php if($banners_url[$key]):?>
                   <a href="<?=prep_url($banners_url[$key])?>" >
                   <?php endif; ?>
                    <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/banners/<?=$banner?>&amp;w=280&amp;h=120&amp;zc=1&amp;aoe=1" />
                   <?php if($banners_url):?>
                   </a> 
                   <?php endif; ?>
				</div>
               <?php endif; ?>              
               <?php endforeach; ?>
			</div>
		</div>
	</div>
<script>
(function ($) {
   <?php if($venue->background_image!=''):?>
   	$("body").ezBgResize({
		img : "<?=base_url()?>assets/background/<?=$venue->background_image?>",
	}); 
   <?php endif; ?> 
  // hash change handler
  function hashchange () {
	  
//	 $('#map').css('display','block'); 
	 
    var hash = window.location.hash
      , el = $('ul.tabs [href*="' + hash + '"]')
      , content = $(hash)

    if (el.length && !el.hasClass('active') && content.length) {
      el.closest('.tabs').find('.active').removeClass('active');
      el.addClass('active');
	  

//      alert(content.attr('id'));
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
  
  
})(jQuery);
</script>