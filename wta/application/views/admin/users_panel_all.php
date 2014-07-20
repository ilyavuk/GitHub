  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2>Users</h2>
    <p id="page-intro"><?=$users_num?>  Users</p>
    
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

          <table>
            <thead>
              <tr>
                <th><input class="check-all" type="checkbox" /></th>
                <th>Icon</th>
                <th>Username</th>
                <th>Country</th>
                <th>Last Login</th>
                <th>Type of user</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <td colspan="7"><div class="bulk-actions align-left">
                    <select name="dropdown" id="applyDrop">
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
<?php if($users_data): ?>           
<?php foreach($users_data as $user_data): ?>
		 <?php  
           /*$data = array(
                      'user_'.$user_data->id  => $user_data->id
                    );
          echo form_hidden($data);*/
         ?> 
          
              <tr>
                <td><input type="checkbox" name="spec_checkbox_<?=$user_data->id?>" value="<?=$user_data->id?>" /></td>
                <td><img src="<?=base_url().'phpThumb/phpThumb.php?src=/assets/users_img/'.$user_data->img.'&w=20&h=20&zc=1&aoe=1' ?>" /></td>
                <td><?=$user_data->username?></td>
                <td><?=$user_data->country?></td>
                <td><?=date("m/d/Y H:i",$user_data->last_login)?></td>
                <td><?php 
					switch ($user_data->is_admin) {
						case 0:
							echo "Website Visitor";
							break;
						case 1:
							echo "Registered User";
							break;
						case 2:
							echo "Venue Admin";
							break;
						case 3:
							echo "Master Admin";
							break;							
                     }
 					?>
                 </td>
                <td><!-- Icons --> 
                  <a href="<?=base_url()?>admin/users/edit/<?=$user_data->id?>" title="Edit"><img src="<?=base_url()?>assets/img/icons/pencil.png" alt="Edit" /></a> <a href="<?=base_url().'admin/admin_users_delete/'.$user_data->id?>" title="Delete"><img src="<?=base_url()?>assets/img/icons/cross.png" alt="Delete" /></a></td>
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
		
	 $('#applyForm').click(function(e){
		 e.preventDefault();
		 if($('#applyDrop').val() == 'delete'){
		
		    $("#applySelected").attr("action", "<?=base_url()?>admin/multy_users_delete/n");
		    $("#applySelected").submit();
		
		 }
		 
		 
	 });
	 
	});
</script>