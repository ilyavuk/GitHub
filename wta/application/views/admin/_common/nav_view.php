<div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
  
  <div id="sidebar">
    <div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
      
      <h1><a href="#">Wall to All - Admin</a></h1>
      
      <!-- Logo (221px) --> 
      <a href="<?=base_url()?>"><img id="logo" src="<?=base_url()?>assets/img/logo.png" alt="Sport Impuls" /></a>
      
      <ul id="main-nav">
        <!-- Accordion Menu -->
        <?php if($this->master_admin): ?>
       <!-- <li> <a href="#" class="nav-top-item no-submenu">Dashboard</a>
        </li>-->
        <li>
        	<a href="#" class="nav-top-item <?=isset($s_users)?'current':false?>">Users</a>
        	<ul>
                <li><a href="<?=base_url()?>admin/users/insert/" <?=isset($add_users)?'class="current"':false?> >Add new user</a></li>
                <li><a href="<?=base_url()?>admin/users/" <?=isset($common_users)?'class="current"':false?> >Users</a></li>
        		<li><a href="<?=base_url()?>admin/users/facebook-users/" <?=isset($face_users)?'class="current"':false?> >Facebook users</a></li>
        		<li><a href="<?=base_url()?>admin/users/twitter-users/" <?=isset($twit_users)?'class="current"':false?> >Twitter users</a></li>
        	</ul>
        </li>
        <li>
        	<a href="#" class="nav-top-item <?=isset($home)?'current':false?>">Home</a>
            <ul>
                <li><a href="<?=base_url()?>admin/home/" <?=isset($home)?'class="current"':false?> >Home</a></li>
        	</ul>
        </li>   
        <?php endif; ?>     
        <?php if($this->venue_admin): ?>
        <li> 
        	<a href="#" class="nav-top-item <?=isset($s_venues)?'current':false?>">Venues</a>
			<ul>
				<li><a href="<?=base_url()?>admin/venues/insert/" <?=isset($venues_new)?'class="current"':false?> >New venue</a></li>
				<li><a href="<?=base_url()?>admin/venues/" <?=isset($venues_all)?'class="current"':false?> >All venues</a></li>
                <?php if($this->master_admin): ?>
				<li><a href="<?=base_url()?>admin/venues/categories/" <?=isset($venues_categories)?'class="current"':false?> >Categories</a></li>
				<li><a href="<?=base_url()?>admin/venues/cities/" <?=isset($venues_cities)?'class="current"':false?> >Cities</a></li>
                <?php endif; ?> 
			</ul>
        </li>
       <?php endif; ?> 
       <?php if($this->venue_admin): ?>
        <li> 
        	<a href="#" class="nav-top-item <?=isset($events_s)?'current':false?>" >Events</a>
			<ul>
				<li><a href="<?=base_url()?>admin/events/insert/" <?=isset($events_new)?'class="current"':false?> > New event </a></li>
				<li><a href="<?=base_url()?>admin/events/" <?=isset($events_all)?'class="current"':false?> >All events</a></li>
			</ul>
        </li>
        <?php endif; ?>
        <?php if($this->master_admin): ?>
        <li> 
        	<a href="#" class="nav-top-item <?=isset($events_live)?'current':false?> ">Live events</a>
			<ul>
				<li><a href="<?=base_url()?>admin/live-events/" <?=isset($events_live)?'class="current"':false?> >All live events</a></li>
			</ul>
        </li>
        <li> 
        	<a href="#" class="nav-top-item <?=isset($comments_s)?'current':false?> ">Comments</a>
			<ul>
            <li><a href="<?=base_url()?>admin/comments/" <?=isset($comments_all)?'class="current"':false?> >All comments</a></li>
				<li><a href="<?=base_url()?>admin/comments/liked-comments/" <?=isset($comments_liked)?'class="current"':false?>>Liked comments</a></li>
				<li><a href="<?=base_url()?>admin/comments/reported-comments/" <?=isset($comments_reported)?'class="current"':false?> >Reported comments</a></li>
				<li><a href="<?=base_url()?>admin/comments/block-bad-words/" <?=isset($comments_badwords)?'class="current"':false?> >Block bad words</a></li>
			</ul>
        </li>
        <!--<li> <a href="#" class="nav-top-item">Pages</a>
          <ul>
            <li><a href="#">New page</a></li>
            <li><a href="#">All pages</a></li>
          </ul>
        </li>-->
       <?php endif; ?>
      </ul>
      <!-- End #main-nav --> 
      
      <!-- Sidebar Profile links -->
      <?php if($this->venue_admin): ?>
      <div id="profile-links"> <a href="<?=base_url()?>" title="View the Site">View website</a> | <a href="<?=base_url()?>admin/logout" title="Sign Out">Sign out</a> </div>
      <?php endif; ?>
    </div>
  </div>
