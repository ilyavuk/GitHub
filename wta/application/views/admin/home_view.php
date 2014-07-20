  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2>Home page</h2>
    <p id="page-intro">Set up home page</p>
    
    <div class="content-box"><!-- Start Content Box -->
      
      <div class="content-box-header">
        <h3></h3>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
        <?php if(isset($succ_home)):?>
	      <div class="notification success png_bg"> <a href="#" class="close"><img src="<?=base_url()?>assets/img/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div> Successfully updated! </div>
          </div>
		<?php endif;?>
			
			
			<?php
                $position = array();
                $position['0'] = 'Select..';
                foreach($all_events as $all_event) {
                    $position[$all_event->id] = $all_event->title;
                }
             ?>  
          <form action="<?=base_url()?>admin/home/" method="post">
            <fieldset>
              <p><label for="recommend1">Recommend1 </label>
            	<?=form_dropdown('recommend1', $position, $recommend1->events_id, 'class="small-input"')?>
              </p> 
              <p><label for="recommend2">Recommend2 </label>
                <?=form_dropdown('recommend2', $position, $recommend2->events_id, 'class="small-input"')?>
              </p>  
              <p><label for="recommend3">Recommend3 </label>
                <?=form_dropdown('recommend3', $position, $recommend3->events_id, 'class="small-input"')?>
              </p> 
               <p><label for="recommend4">Recommend4 </label>
                <?=form_dropdown('recommend4', $position, $recommend4->events_id, 'class="small-input"')?>
              </p> 
              <p><label for="youtube">Youtube:</label>
                 <input  class="text-input medium-input" type="text" id="youtube" name="youtube" value="<?=$youtube?>">  
              </p> 
               <p><label for="banners">Banners: </label>
               <textarea class="text-input text area wysiwyg" rows="4" cols="20" name="banners"><?=$banners?></textarea>
               </p>  
                    
                <h3>Background image</h3>
                <div class="banner" id="backgroundShield" >
                    <form>
                    <div class="tip">Recommended Background image size 1280x1024 px</div>
                        <div id="file-uploaderBImg">		
                        </div>
                      </form>
                       <p class="background-img " id="insertBack" > 
                         <?php if($background != ''):?>
                         <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/background/<?=$background?>&w=280&h=280&zc=1&aoe=1" />
                         <a href="#" class="delBackground" >Delete X</a>
                         <?php else: ?>
                           Background image is not set
                         <?php endif;?>
                       </p>                 
                </div> 	            
              
              
              <p>
                <input class="button" name="submit_home_form" type="submit" value="Submit" />
              </p>          
            
            </fieldset>
            <div class="clear"></div>
            <!-- End .clear -->
            
          </form>
        </div>
        <!-- End #tab2 --> 
        
      </div>
      <!-- End .content-box-content --> 
      
    </div>
    <!-- End .content-box -->
    

    

    <!-- End .content-box -->
    
    <div class="clear"></div>
<script>
$(function() {
	
  $('.delBackground').live('click', function(e){
    e.preventDefault();
    deleteBackground(1,'homeyoutube');
  });

  manageBackground(1,'homeyoutube');

});
</script>    

