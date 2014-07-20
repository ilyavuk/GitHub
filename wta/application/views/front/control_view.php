<div id="control-panel">
<div class="left">
         <ul>
           <li><a href="<?=base_url()?>control-panel/account-settings/">Account Settings</a></li>
           <?php if($this->venue_admin): ?> 
           <li><a href="<?=base_url()?>control-panel/my-venues/">My Venues</a></li>
           <li><a href="<?=base_url()?>control-panel/my-events/">My Events</a></li>
           <?php endif;?>
          </ul>
</div>
<div class="right">
<h2>Welcome back <?=$username?></h2>
</div><div class="clear"></div>
</div>