  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2>Categories</h2>
    <p id="page-intro"><?=$num?> Categories</p>
    
    <div class="content-box"><!-- Start Content Box -->
      
      <div class="content-box-header">
        <h3></h3>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
          
        <?php if(isset($successfullyinserted)):?>
	      <div class="notification success png_bg"> <a href="#" class="close"><img src="<?=base_url()?>assets/img/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div> Successfully inserted! </div>
          </div>
		<?php endif;?>
         <?php if(isset($successfully)):?>
	      <div class="notification success png_bg"> <a href="#" class="close"><img src="<?=base_url()?>assets/img/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div> Successfully deleted! </div>
          </div>
		<?php endif;?>         
            <form action="<?=base_url()?>admin/venues/categories/" method="post">
               <p><label for="category">Category:</label>
                <input class="text-input small-input" type="text" id="category" name="category" > 
                <input class="button" name="submit_category_form" type="submit" value="Submit" /> 
               </p> 
            </form><br/><br/>          
          <table>
            <thead>
              <tr>
                <th><input class="check-all" type="checkbox" /></th>
                <th>Category</th>
                <th>Inserted</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <td colspan="6"><div class="bulk-actions align-left">
                    <select name="dropdown" id="applyDrop" >
                      <option value="option1">Choose an action…</option>
                      <option value="delete">Delete</option>
                    </select>
                    <a id="applyForm" class="button" href="#">Apply to selected</a> </div>
                  <div class="pagination"></div>
                  <!-- End .pagination -->
                  
                  <div class="clear"></div></td>
              </tr>
            </tfoot>
            <tbody>
<form id="applySelected" method="post">           
<?php foreach($categories as $category): ?>
              <tr>
                <td><input type="checkbox" name="spec_checkbox_<?=$category->id?>" value="<?=$category->id?>" /></td>
                <td><?=$category->category?></td>
                <td><?=date("m/d/Y H:i",$category->post_time)?></td>
                <td><!-- Icons --> 
					<a href="<?=base_url().'admin/venues/categories/delete/'.$category->id?>" title="Delete"><img src="<?=base_url()?>assets/img/icons/cross.png" alt="Delete" /></a></td>
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
	
	 $('#applyForm').click(function(e){
		 e.preventDefault();
		 if($('#applyDrop').val() == 'delete'){
		    $("#applySelected").attr("action", "<?=base_url()?>admin/venues/categories/delete/multi");
		    $("#applySelected").submit();
		 }
	 });		
 
});
</script>