  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2>Block bad words</h2>
    <p id="page-intro">Please enter words with comma separator.</p>
    
    <div class="content-box"><!-- Start Content Box -->
      
      <div class="content-box-header">
        <h3></h3>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
        <?php if(isset($successfully)):?>
	      <div class="notification success png_bg"> <a href="#" class="close"><img src="<?=base_url()?>assets/img/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div> Successfully updated! </div>
          </div>
		<?php endif;?>
        
         <form action="<?=base_url()?>admin/comments/block-bad-words/" method="post">
         <p><label for="bad_words">Bad words:</label>
            <textarea class="text-input text area wysiwyg" name="bad_words" rows="6"><?=$bad_words?></textarea></p>
         <p>
            <input name="bad_words_form" class="button" type="submit" value="Submit" />
         </p>
         </form>			

        </div>
        <!-- End #tab2 --> 
        
      </div>
      <!-- End .content-box-content --> 
      
    </div>
    <!-- End .content-box -->
    

    

    <!-- End .content-box -->
    
    <div class="clear"></div>
    

