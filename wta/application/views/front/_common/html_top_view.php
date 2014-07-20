<?php
$ts = gmdate("D, d M Y H:i:s") . " GMT";
header("Expires: $ts");
header("Last-Modified: $ts");
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
?>
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
    <link rel="stylesheet" href="<?=base_url()?>assets/css/flexslider.css">


	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
   
	<link rel="shortcut icon" href="<?=base_url()?>assets/img/faviconBlue.ico">
	<link rel="apple-touch-icon" href="<?=base_url()?>assets/img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?=base_url()?>assets/img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?=base_url()?>assets/img/apple-touch-icon-114x114.png">
    <link type="text/css" href="<?=base_url()?>assets/css/jquery-ui-1.8.20.custom.css" rel="stylesheet" />   
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/fileuploader.css" />   
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/jquery-ui-timepicker-addon.css" /> 
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/colorbox.css" />
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/js/wall2all.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.8.20.custom.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.limit-1.2.source.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/js/fileuploader.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-timepicker-addon.js"></script>  
    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.colorbox.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.flexslider-min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.fullscreenBackground.js"></script>
    <script type="text/javaScript" src="<?=base_url()?>ape/APE_JSF/Build/uncompressed/apeClientJS.js?f"></script>
	<script src="<?=base_url()?>assets/js/jquery.ez-bg-resize.js" type="text/javascript" charset="utf-8"></script>   
    <!--<script language="JavaScript" src="http://j.maxmind.com/app/geoip.js"></script>-->
    <script type="text/javascript" src="<?=base_url()?>assets/js/json2.js"></script>
    <script type="text/javascript">

	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-36988911-1']);
	_gaq.push(['_trackPageview']);
	
	(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	
	</script>
    <script src="http://walltoall.com:3000/socket.io/socket.io.js"></script>
</head>
