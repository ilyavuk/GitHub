<div class="container">
		<div class="sixteen columns venue">
			<div class="sixteen columns alpha omega">

				<div class="sixteen columns alpha omega content">
				
						<h1>Events</h1>
						<div class="filter">
							<?php
							$position = array(
							     ''=>'All...',
								 'live-events'=>'Live',
								 'upcoming-events'=>'Upcoming',
								 'past-events'=>'Past'
							);
							echo form_dropdown('eventsChange', $position, $selected_time_event, 'id="eventsChangeDD"');
							?>
							<br/><br/>
						</div>
                        <?php if($events): ?>
                        <?php foreach($events as $event): ?>
                        <div class="five columns alpha vignette">
                            <a href="<?=base_url().$event->url_title?>">
							<img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/evt_logo_img/<?=$event->logo_events?>&w=200&h=200&zc=1&aoe=1" alt="thumbnail" class="two columns alpha omega" />
                            </a>
                            <div class="three columns alpha omega">
                                <a href="<?=base_url().$event->url_title?>">
								<div class="title"><?=character_limiter($event->title_events,15)?></div>
                                </a>
								<div class="datetime">
                                <?=date("m/d/Y H:i",$event->start_date)?>
                                </div>
								<div class="text"><?=character_limiter(strip_tags($event->description_events),25)?></div>
							</div>
						</div>
                        <?php endforeach; ?>
                        <?php endif; ?>
						<div class="clear"></div>
						<div class="page">
							<?=$this->pagination->create_links()?>
						</div>
				</div>
			</div>
			
		</div>
	</div>
<script>
 $(function() {
 $('#eventsChangeDD').change(function(e){
	 e.preventDefault();
	 window.location = '<?=base_url() ?>events/'+$('#eventsChangeDD').val()+'/';
 });
});
</script>