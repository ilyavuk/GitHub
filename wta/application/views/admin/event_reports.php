  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2>Event: <?=$event->title?></h2>
    <p id="page-intro"></p>
    
    <div class="content-box"><!-- Start Content Box -->
      
      <div class="content-box-header">
        <h3></h3>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
            <p class="stronger" ><a class="poll" href="<?=base_url()?>admin/events/reports/poll/rate-event/<?=$event->id?>">Rate event detail view</a></p>
            <p class="stronger"><a class="poll" href="<?=base_url()?>admin/events/reports/poll/poll1/<?=$event->id?>">Poll1</a></p>
            <p class="stronger"><a class="poll" href="<?=base_url()?>admin/events/reports/poll/poll2/<?=$event->id?>">Poll2</a></p>
            <p class="stronger"><a class="poll" href="<?=base_url()?>admin/events/reports/attending/<?=$event->id?>">Attending</a></p>
            <div class="clear"></div>
            <!-- End .clear -->
            
         
        </div>
        <!-- End #tab2 --> 
        
      </div>
      <!-- End .content-box-content --> 
      
    </div>
    <!-- End .content-box -->
    

    

    <!-- End .content-box -->
    
    <div class="clear"></div>
    

