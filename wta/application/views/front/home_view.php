
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Wall to All</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link rel="stylesheet" href="<?=base_url()?>assets/css/base.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/css/skeleton.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/css/layout.css">

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link rel="shortcut icon" href="<?=base_url()?>assets/img/favicon.ico">
	<link rel="apple-touch-icon" href="<?=base_url()?>assets/img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?=base_url()?>assets/img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?=base_url()?>assets/img/apple-touch-icon-114x114.png">

</head>
<body>

	<!-- Header
	================================================== -->
	<div class="header">
		<div class="container">
				<div class="three columns logo">Wall to All</div>
				<div class="ten columns selectors">
					<input class="two columns alpha" type="text" placeholder="City" />
					<input class="two columns" type="text" placeholder="Category" />
					<input class="two columns" type="text" placeholder="Event" />
					<a class="three columns omega advanced-search-callout" href="#">Advanced search</a>
				</div>
				<div class="three columns profile">
					<div class="avatar" style="background-image: url('<?=base_url()?>assets/img/avatar.jpg');"></div>
					<div class="name">Welcome Pera</div>
				</div>
		</div>
	</div>

	<!-- Advanced search
	================================================== -->
	<div class="container">
		<div class="sixteen columns">
			<div class="advanced-search">
				<h3 class="row">Advanced search</h3>
				<div class="row">
					<input class="three columns alpha" type="text" placeholder="City" />
					<input class="three columns" type="text" placeholder="Category" />
					<input class="three columns" type="text" placeholder="Venue" />
					<input class="three columns omega" type="text" placeholder="Event" />
				</div>
				<div class="row">
					<input class="three columns alpha" type="text" placeholder="Date from" />
					<input class="three columns omega" type="text" placeholder="Date to" />
				</div>
				<div class="row">
					<input class="columns alpha" type="button" name="" value="Search" />
				</div>
				<a href="#" class="close">close</a>
			</div>
		</div>
	</div>
	
	<!-- Google Map
	================================================== -->
	<div class="container home">
		<div id="map_canvas" class="sixteen columns map"></div>
	</div>

	<!-- Page
	================================================== -->
	<div class="container">
		<div class="one-third column">
			<h3>We recommend</h3>
			<ol class="events">
				<li class="group">
					<h3><a href="#"><img src="<?=base_url()?>assets/img/thumb.png" alt="thumbnail" />This is the title</a></h3>
					<span class="meta">August 10, 2011</span>
				</li>
				<li class="group">
					<h3><a href="#"><img src="<?=base_url()?>assets/img/thumb.png" alt="thumbnail" />This is the title</a></h3>
					<span class="meta">August 10, 2011</span>
				</li>
				<li class="group">
					<h3><a href="#"><img src="<?=base_url()?>assets/img/thumb.png" alt="thumbnail" />This is the title</a></h3>
					<span class="meta">August 10, 2011</span>
				</li>
			</ol>
		</div>
		<div class="one-third column">
			<h3>What's new</h3>
			<ol class="events">
				<li class="group">
					<h3><a href="#"><img src="<?=base_url()?>assets/img/thumb.png" alt="thumbnail" />This is the title</a></h3>
					<span class="meta">August 10, 2011</span>
				</li>
				<li class="group">
					<h3><a href="#"><img src="<?=base_url()?>assets/img/thumb.png" alt="thumbnail" />This is the title</a></h3>
					<span class="meta">August 10, 2011</span>
				</li>
				<li class="group">
					<h3><a href="#"><img src="<?=base_url()?>assets/img/thumb.png" alt="thumbnail" />This is the title</a></h3>
					<span class="meta">August 10, 2011</span>
				</li>
			</ol>
		</div>
		<div class="one-third column">
			<div class="banner"></div>
			<div class="banner"></div>
		</div>
	</div>

	<!-- JS
	================================================== -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="<?=base_url()?>assets/js/tabs.js"></script>
	<script src="<?=base_url()?>assets/js/app.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">
		 
		// Load google map
		var map = new google.maps.Map( document.getElementById("map_canvas"),  {
			zoom: 4,
			center: new google.maps.LatLng(50.1700235000, 4.7319823000),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			panControl: false,
			streetViewControl: false,
			mapTypeControl: false
		});
		 
		var events = [];
		for(var i = 0 ; i < 30 ; i++) {
			eventOnMap(i, events, map);
		}
		 
		function eventOnClick(num) {
			$(".popup").fadeOut();
		    $("#popup" + num).show().animate({right:'0'}, 800);
		}
		 
		$('.close').click(function(e) {
			$(this).parent().parent().animate({right:'-400'}, 800, function(){ $(".popup").hide(); });
		    e.preventDefault();
		});
		
		$('.next').click(function(e) {
			var num = $(this).parent().parent().attr('data-num');
			var next = parseInt(num) + 1;
			$("#popup" + num).fadeOut();
			$("#popup" + next).show().animate({right:'0'}, 800);
		});
		
		$('.prev').click(function(e) {
			var num = $(this).parent().parent().attr('data-num');
			var next = parseInt(num) - 1;			
			$("#popup" + num).fadeOut();
			$("#popup" + next).show().animate({right:'0'}, 800);
		});
		
	</script>
	
<!-- End Document
================================================== -->
</body>
</html>