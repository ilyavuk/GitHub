	 <?php echo $map['js']; ?>

	<div class="container home">
		<?php echo $map['html']; ?>
	
    </div>

<div id="search-panel" >


<?php if($events):?>
<h2>There are <?=($num_events == 1)?''.$num_events.' search result':''.$num_events.' search results'?> </h2>
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

<?php else:?>
<h2>There isn't search result for such criteria</h2>
<?php endif;?>

</div></div><div class="clear"></div>
<script type="text/javascript">
<?php foreach($windows as $key =>$window):?>

var popup<?=$key?> = '<?=$window?>';

<?php endforeach; ?>
		
</script>
