<div id="event-panel">
<div class="left">
         <ul>
           <li><a href="<?=base_url()?>events/">Live Events</a></li>
           <li><a href="<?=base_url()?>events/upcoming-events/">Upcoming events</a></li>
           <li><a href="<?=base_url()?>events/past-events/">Past events</a></li>
           <?php if($this->venue_admin): ?>      
           <li><a href="<?=base_url()?>control-panel/my-events/">My Events</a></li>
           <?php endif;?>
          </ul>
</div>
<div class="right">

<?php if($events):?>
<h2>There are <?=$num_events?> past events</h2>
<?php foreach($events as $event): ?>
<div class="event_desc">
<h3><a href="<?=base_url()?>events/detail/<?=$event->id_events?>"><?=$event->title_events?></a></h3>
<div class="img_cont">

        
        <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/evt_logo_img/<?=$event->logo_events?>&w=200&h=200&zc=1&aoe=1" />
        

</div>
<div class="desc_cont">
<p><?=$event->description?>
</p>
<div class="detail">
<span class="first"><em>Country:</em> <?=$event->country?></span>
<span><em>City:</em> <?=$event->city?></span>
<span class="first"><em>Address:</em> <?=$event->address?>  </span>
<span><em>Venue: </em><a href="<?=base_url()?>venues/detail/<?=$event->id_venues?>"><?=$event->title_venues?></a></span>
<span class="first"><em>Start Date:</em> <?=date("m/d/Y H:i",$event->start_date)?></span>

<span><em>End Date:</em> <?=date("m/d/Y H:i",$event->end_date)?></span>
<span class="clear"></span>
</div>

</div><div class="clear"></div>
</div>
<?php endforeach; ?>
<div class="paginationI"><?=$this->pagination->create_links()?></div>
</div><div class="clear"></div>
<?php else:?>
<h2>There are no past events</h2>
<?php endif;?>

</div>