  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2><?=$event->title?></h2>
    <p id="page-intro">
    </p>
    
    <div class="content-box"><!-- Start Content Box -->
      
      <div class="content-box-header">
        <h3>Content box</h3>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
          

      
      <p>
      <form>
      <label for="selectAge">Age filter</label>
      <?php
		$position = array(
		   ''=>'Select age',
		   18 =>18,
		   25 =>25,
		   35 =>35,
		   40 =>' > 35'
		);

		echo form_dropdown('selectAge', $position, $sel_age, ' id ="selectAge" class="selectAge small-input"');

	  ?></form>
      </p>
       <p> Number of Attending: <?=$num_att?> </p>
		 <?php if(isset($unknown_age)&&($unknown_age != 0)):?>
         <p> Number of Attending With Unknown Age: <?=$unknown_age?> </p>
         <?php endif; ?>
       <div class="excel">
         <a href="<?=base_url()?>admin/events/edit/attending/excel/<?=$event->id?>" class="button" >Export To Excel</a>
       </div><br/><br/>

       
          <table>
            <thead>
              <tr>
					<th >Username</th>
					<th>Birthday</th>
                    <th>Country</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <td colspan="8"><div class="bulk-actions align-left"></div>
                  <div class="pagination"></div>
                  <!-- End .pagination -->
                  
                  <div class="clear"></div></td>
              </tr>
            </tfoot>
            <tbody>

			<?php foreach($att_users as $att_user): ?>
                            <tr >
                                <td class="first"><?=$att_user['username']?></td>
                                <td><?=$att_user['birthday']?></td>
                                <td class="tc last"><?=$att_user['country']?></td>
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
   $('#selectAge').change(function(){
       window.location.href = '<?=base_url()?>admin/events/edit/attending/age/<?=$event->id?>/'+$(this).val();
   });
});
</script>