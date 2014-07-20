<?php 
$upcoming_events = array();
?>
<div class="container">
		<div class="sixteen columns venue">
			<div class="sixteen columns alpha omega">

				<div class="sixteen columns alpha omega content">
				
						<h1>Venues</h1>
						<div class="filter">
							<br/><br/>
						</div>
                        <?php foreach($venues as $venue): ?>
                        <div class="five columns alpha vignette">
                            <a href="<?=base_url()?>venues/detail/<?=$venue->id_venues?>">
                            <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/venues_img/<?=$venue->logo_venues?>&w=200&h=200&zc=1&aoe=1" alt="thumbnail" class="two columns alpha omega" />
							</a>
                            <div class="three columns alpha omega">
                                <a href="<?=base_url()?>venues/detail/<?=$venue->id_venues?>">
								<div class="title"><?=$venue->place?></div>
                                </a>
								<div class="datetime">
                                <?php
									$upcoming_events = explode(",",$venue->start_date_events);
									$k = 0;
									for($i=0;$i<count($upcoming_events);$i++){
									     
										 if($upcoming_events[$i]>time()){
											 $k++;
										 }
									}
									if($k > 0){
										echo $k.' upcoming events';
									}
                                ?>
                                </div>
								<div class="text"><?=character_limiter(strip_tags($venue->description_venues),40)?></div>
							</div>
						</div>
                        <?php endforeach; ?>
						<div class="clear"></div>
						<div class="page">
							<?=$this->pagination->create_links()?>
						</div>
				</div>
			</div>
			
		</div>
	</div>