<div id="event-panel">
<div class="left">
         <ul>
           <li><a href="<?=base_url()?>venues/">Upcoming Venues</a></li>
           <li><a href="<?=base_url()?>venues/past-venues/">Past Venues</a></li> 
           <?php if($this->venue_admin): ?>         
           <li><a href="<?=base_url()?>control-panel/my-venues/">My Venues</a></li>
           <?php endif;?>
          </ul>
</div>
<div class="right">

<?php if($venues):?>
<h2>There are <?=$num_venues?> past venues</h2>
<?php foreach($venues as $venue): ?>
<div class="event_desc">
<h3><a href="<?=base_url()?>venues/detail/<?=$venue->id?>"><?=$venue->title?></a></h3>
<div class="img_cont">

        
        <img src="<?=base_url()?>phpThumb/phpThumb.php?src=/assets/venues_img/<?=$venue->logo?>&w=200&h=200&zc=1&aoe=1" />
        

</div>
<div class="desc_cont">
<p><?=$venue->description?>
</p>
<div class="detail">
<span class="first"><em>Country:</em> <?=$venue->country?></span>
<span><em>City:</em> <?=$venue->city?></span>
<span class="first"><em>Address:</em> <?=$venue->address?>  </span>
<span><em>Club:</em> </span>
<span class="first"><em>Start Date:</em> <?=date("m/d/Y H:i",$venue->start_date)?></span>
<span><em>End Date:</em> <?=date("m/d/Y H:i",$venue->end_date)?></span>
<a href="<?=base_url()?>venues/detail/<?=$venue->id?>">View</a>
<span class="clear"></span>
</div>

</div><div class="clear"></div>
</div>
<?php endforeach; ?>
<div class="paginationI"><?=$this->pagination->create_links()?></div>
</div><div class="clear"></div>
<?php else:?>
<h2>There are no past venues</h2>
<?php endif;?>

</div>