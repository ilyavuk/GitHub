<body>
<?php
	if($this->session->userdata('social_blocked')){
		echo $this->session->userdata('social_blocked');
		$this->session->unset_userdata('social_blocked');
	}
?>
	<!-- Header
	================================================== -->
	<div class="header">
		<div class="container">
                <a href="<?=base_url()?>" class="logo-top-link">
				<div class="four columns logo">Wall to All</div>
                </a>
				<div class="nine columns selectors">
                    <?php
					$position = array();
					$position[''] = 'City';
					foreach($cities as $city) {
						$position[$city->city] = $city->city;
					}
					echo form_dropdown('searchCity', $position, $selected_city, ' id ="searchCity" class="two columns alpha search_change searchCity"');
					?>
<!--<input id="searchCity" class="two columns alpha search_change" type="text" placeholder="City" <?=($selected_city!='')?'value="'.$selected_city.'"':false?> />
-->					
                    <?php
					$position2 = array();
					$position2[''] = 'Category';
					foreach($categories as $category) {
						$position2[$category->category] = $category->category;
					}
					echo form_dropdown('searchCategory', $position2, $selected_category, ' id ="searchCategory" class="two columns search_change searchCategory"');
					?>
                    <input id="searchEvent" class="two columns search_change" type="text" placeholder="Event" <?=($selected_event!='')?'value="'.$selected_event.'"':false?> />
				    <a class="three columns omega advanced-search-callout" href="#">Advanced search</a>
                </div>
				<div class="three columns profile">
                    <div class="facebook-ico">
                    <a href="http://www.facebook.com/walltoalll" title="Follow us on Facebook">
                    <img src="<?=base_url()?>assets/img/facebook_ico.png" title="Follow us on Facebook" />
                    </a>
                    </div>
                    <?php if($this->logged_in): ?>
                    <!--<div class="info_toggle">-->
                    <a href="<?=base_url()?>account-settings/" title="Account Settings">
 					<div class="avatar" style="background-image: url('<?=base_url().'phpThumb/phpThumb.php?src=/assets/users_img/'.$ava_img.'&w=60&h=65&zc=1&aoe=1' ?>');"></div>
                    </a>
                   <!-- <div class="name"><a href="<?=base_url()?>account-settings/">Welcome <?=$username?></a></div> --> 
                    <!--</div>-->                 
                    <?php elseif($this->twitter_admin): ?> 
                    <a href="<?=base_url()?>account-settings/" title="Account Settings">
 					<div class="avatar" style="background-image: url('<?=$this->session->userdata('twitter_img')?>');"></div>
					<!--<div class="name">Welcome <?=$this->session->userdata('twitter_username')?></div>-->                   
                    </a>
					<?php elseif($this->facebook_admin): ?>
                    <a href="<?=base_url()?>account-settings/" title="Account Settings"> 
  					<div class="avatar" style="background-image: url('http://graph.facebook.com/<?=$this->session->userdata('facebook_username')?>/picture');"></div>
					<!--<div class="name">Welcome <?=$this->session->userdata('facebook_Fname').' '.$this->session->userdata('facebook_Lname')?></div>-->                  
                    </a>
					<?php else: ?> 
                    <div class="register"><a href="<?=base_url()?>register/">Login / Register</a></div>
                    <?php endif; ?>
				</div>
		</div>
	</div>
	<!-- Advanced search
	================================================== -->
	<div class="container search ">
		<div class="sixteen columns">
			<div class="advanced-search">
				<h3 class="row">Advanced search</h3>
				<div class="row">
                    <form action="<?=base_url()?>search" method="get">
					<?php
					echo form_dropdown('searchCity', $position, $selected_city, ' class="two columns alpha searchCity"');
					?>
                    <?php
					echo form_dropdown('searchCategory', $position2, $selected_category, '  class="two columns searchCategory"');
					?>                  
					<!--<input class="three columns" type="text" placeholder="Category" name="searchCategory" value="<?=$selected_category?>" />-->
					<input class="three columns" type="text" placeholder="Venue" name="searchVenue" value="<?=$selected_venue?>" />
					<input class="three columns omega" type="text" placeholder="Event" name="searchEvent" value="<?=$selected_event?>" />
				</div>
				<div class="row">
					<input class="three columns alpha timepicker-add-time" type="text" placeholder="Date from" name="dateFrom" value="<?=$selected_dateFrom?>" />
					<input class="three columns omega timepicker-add-time" type="text" placeholder="Date to" name="dateTo" value="<?=$selected_dateTo?>" />
				</div>
				<div class="row">
					<input class="columns alpha" type="submit" name="" value="Search" />
                    </form>
				</div>
				<a href="#" class="close">close</a>
			</div>
		</div>
	</div>

