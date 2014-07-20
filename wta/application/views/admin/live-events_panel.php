  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2>Live events</h2>
    <p id="page-intro"><?=$events_num?> Events</p>
    
    <div class="content-box"><!-- Start Content Box -->
      
      <div class="content-box-header">
        <h3></h3>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
          
			<?php
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
            ?>
          <table>
            <thead>
              <tr>
                <th>User</th>
                <th>Title</th>
                <th>Posted</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <td colspan="6"><div class="bulk-actions align-left"></div>
                  <div class="pagination"><?=$this->pagination->create_links()?></div>
                  <!-- End .pagination -->
                  
                  <div class="clear"></div></td>
              </tr>
            </tfoot>
            <tbody>
<?php foreach($events as $event): ?>       
              <tr>
                <td>
					<?php if($event->img != NULL): ?>                  
                    <img class="fav" src="<?=base_url().'phpThumb/phpThumb.php?src=/assets/users_img/'.$event->img.'&w=20&aoe=1' ?>" />
                    <?php else: ?> 
                    <img class="fav" src="<?=base_url().'phpThumb/phpThumb.php?src=/assets/users_img/admin.png&w=30&aoe=1'  ?>" />                 
                    <?php endif; ?>    
					<?=$event->username?>               
                </td>
                <td><?=$event->title?></td>
                <td><?=date("m/d/Y H:i",$event->posted_time)?></td>
                <td><!-- Icons --> 
                 <a href="<?=base_url().'live/'.$event->url_title  ?>/" title="Play"><img src="<?=base_url()?>assets/img/iconPlay.png" alt="Play" /></a> </td>
              </tr>
<?php endforeach; ?>           
              
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
		
			window.location.href = '<?=base_url()?>admin/live-events/select/'+$(this).val();

	

	});
 
});
</script>