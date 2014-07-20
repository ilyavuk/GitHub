  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2>All Venues</h2>
    <p id="page-intro"><?=$venues_num?> Venues</p>
    
    <div class="content-box"><!-- Start Content Box -->
      
      <div class="content-box-header">
        <h3></h3>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
          
        <?php if(isset($successfully)):?>
	      <div class="notification success png_bg"> <a href="#" class="close"><img src="<?=base_url()?>assets/img/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div> Successfully deleted! </div>
          </div>
		<?php endif;?>

			<?php
			   if($this->master_admin){
					$selected_user = (isset($selected_user))?$selected_user:'';
					$user_option['all'] = 'Users';
					foreach($users as $user){
						$user_option[$user->id] = $user->username;
					}
					echo form_open('');
					echo '<span>';
					$attributes =  'class="filter" ';
					echo form_dropdown('users', $user_option, $selected_user,$attributes);
					echo '</span>';
					echo form_close();
			   }
            ?>
          <table>
            <thead>
              <tr>
                <th><input class="check-all" type="checkbox" /></th>
                <th>User</th>
                <th>Place</th>
                <th>Country</th>
                <th>City</th>
                <th>Posted</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <td colspan="7"><div class="bulk-actions align-left">
                    <select name="dropdown" id="applyDrop" >
                      <option value="option1">Choose an action…</option>
                      <option value="delete">Delete</option>
                    </select>
                    <a id="applyForm" class="button" href="#">Apply to selected</a> </div>
                  <div class="pagination"><?=$this->pagination->create_links()?></div>
                  <!-- End .pagination -->
                  
                  <div class="clear"></div></td>
              </tr>
            </tfoot>
            <tbody>
<form id="applySelected" method="post">             
<?php foreach($venues as $venue): ?>       
              <tr>
                <td><input type="checkbox" name="spec_checkbox_<?=$venue->id?>" value="<?=$venue->id?>" /></td>
                <td>

                     <?php if(($venue->facebook_id == 0)&&($venue->twitter_id == 0)): ?>
                       <img class="fav" src="<?=base_url().'phpThumb/phpThumb.php?src=/assets/users_img/'.$venue->img.'&w=20&aoe=1' ?>" />
                       <?=$venue->username?>
                   <?php elseif(($venue->facebook_id != 0)&&($venue->twitter_id == 0)): ?>
                       <img class="fav" src="http://graph.facebook.com/<?=$venue->username?>/picture" width="20" />
                       <?=$venue->username?> 
                   <?php elseif(($venue->facebook_id == 0)&&($venue->twitter_id != 0)): ?>   
                       <img class="fav" src="<?=$venue->img?>" width="20" />
                       <?=$venue->username?>                               
                   <?php endif; ?>                
               
               
               
                </td>
                <td><?=$venue->place?></td>
                <td><?=$venue->country?></td>
                <td><?=$venue->city?></td>
                <td><?=date("m/d/Y H:i",$venue->posted_time)?></td>
                <td><!-- Icons --> 
                 <a href="<?=base_url().'admin/venues/edit/'.$venue->id  ?>" title="Edit"><img src="<?=base_url()?>assets/img/icons/pencil.png" alt="Edit" /></a> <a href="<?=base_url().'delete/venue_delete/'.$venue->id ?>" title="Delete"><img src="<?=base_url()?>assets/img/icons/cross.png" alt="Delete" /></a></td>
              </tr>
<?php endforeach; ?>           
</form>               
            </tbody>
          </table>
        </div>
        <!-- End #tab1 -->
        

        
      </div>
      <!-- End .content-box-content --> 
      
    </div>
    <!-- End .content-box -->
<script>
$(function() {
	
	$('.filter').change(function(){
			window.location.href = '<?=base_url()?>admin/venues/select/'+$(this).val();
	});
	 
	 
	 $('#applyForm').click(function(e){
		 e.preventDefault();
		 if($('#applyDrop').val() == 'delete'){
		    $("#applySelected").attr("action", "<?=base_url()?>admin/venue_mdelete/");
		    $("#applySelected").submit();
		 }
	 });		
 
});
</script>