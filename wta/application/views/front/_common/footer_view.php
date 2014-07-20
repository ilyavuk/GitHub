<div class="container footer">
		<div class="sixteen columns">
		<strong><a href="<?=base_url()?>venues/">Venues</a> | <a href="<?=base_url()?>events/">Events</a> | About | Contact | <a href="<?=base_url()?>terms-and-privacy/" >Terms and Privacy</a></strong><br>
		Copyright notice<br/>
		This website and its content is copyright of WalltoAll - &copy; WalltoAll <?=date('Y')?>. All rights reserved.
		</div>
</div>
<script>
$(function() {
 $('.search_change').change(function(e){
	 e.preventDefault();
	 var urlObject = {
			searchCity: $('#searchCity').val(), 
			searchCategory: $('#searchCategory').val(),  
			searchEvent: $('#searchEvent').val(), 
     };
	 var urlGo = jQuery.param(urlObject);
	 window.location = '<?=base_url() ?>search?'+urlGo;
 });
});

var wall2all_log_in_url = '<?=base_url() ?>ajax/log_in';
var wall2all_url = '<?=base_url() ?>';
var wall2all_current_url = '<?=$_SERVER['REQUEST_URI'] ?>';

</script>

</body>
</html>