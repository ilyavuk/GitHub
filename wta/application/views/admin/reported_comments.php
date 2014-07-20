  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2>Repoted comments</h2>
    <p id="page-intro"><?=$comments_num?> repoted</p>
    
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
                $selected_user = (isset($selected_user))?$selected_user:'';
                $selected_event = (isset($selected_event))?$selected_event:'';
                $user_option['all'] = 'Users';
                foreach($users as $user){
                    $user_option[$user->id] = $user->username;
                }
                echo form_open('');
                echo '<span>';
                $attributes =  'id = "filter_users1" class="small-input filter" rel=1';
                echo form_dropdown('users', $user_option, $selected_user, $attributes);
                echo '</span>';
                
                
                $event_option['all'] = 'Events';
                foreach($events as $event){
                    $event_option[$event->id] = $event->title;
                }
                
                echo '<span>';
                $attributes =  'id = "filter_users2" class="small-input filter" rel=2';
                echo form_dropdown('events', $event_option, $selected_event , $attributes);
                echo '</span>';
                
                echo form_close();
            ?>           
            
          <table>
            <thead>
              <tr>
                <th><input class="check-all" type="checkbox" /></th>
                <th>User</th>
                <th>Events</th>
                <th>Posted</th>
                <th>Comments</th>
                <th>Is active</th>
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
<?php if($comments): ?> 
<?php foreach($comments as $comment): ?>       
              <tr>
                <td><input type="checkbox" name="spec_checkbox_<?=$comment->comments_id?>" value="<?=$comment->comments_id?>" /></td>
                <td>
					 <?php if($comment->facebook_id): ?>                  
                     <img src="http://graph.facebook.com/<?=$comment->username?>/picture" width="20px" />
                     <?php elseif($comment->twitter_id): ?> 
                     <img src="<?=$comment->img?>" width="20px" />  
                     <?php else: ?> 
                     <img class="fav" src="<?=base_url().'phpThumb/phpThumb.php?src=/assets/users_img/'.$comment->img.'&w=20&aoe=1' ?>" />              
                     <?php endif; ?> 
                     <?=$comment->username?>
                </td>
					<td><?=$comment->title?></td>
					<td><?=date("m/d/Y H:i",$comment->comment_date_post)?></td>
					<td><?=word_limiter($comment->comment,8)?></td>
					<td><?=($comment->comment_is_active == 1)?'Yes':'No'?></td>
                <td><!-- Icons --> 
                 <a href="<?=base_url().'admin/comments/edit/'.$comment->comments_id?>" title="Edit"><img src="<?=base_url()?>assets/img/icons/pencil.png" alt="Edit" /></a> <a href="<?=base_url().'admin/admin_comments_delete/'.$comment->comments_id?>" title="Delete"><img src="<?=base_url()?>assets/img/icons/cross.png" alt="Delete" /></a></td>
              </tr>
<?php endforeach; ?>           
<?php endif; ?>  
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
		if($(this).attr('rel') == 1){
			window.location.href = '<?=base_url()?>admin/comments/reported-comments/select/'+$(this).val() +'/'+ $('#filter_users2').val();
		}else if($(this).attr('rel') == 2) {
		    window.location.href = '<?=base_url()?>admin/comments/reported-comments/select/'+ $('#filter_users1').val()+'/'+ $(this).val();
		}

	});
	
	$('#applyForm').click(function(e){
		 e.preventDefault();
		 if($('#applyDrop').val() == 'delete'){
		    $("#applySelected").attr("action", "<?=base_url()?>admin/comment_mdelete/r");
		    $("#applySelected").submit();
		 }
	 });
	
 
});
</script>