<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wall to All - Admin</title>
<link rel="stylesheet" type="text/css" href="http://wall2allnew.cp-dev.com/assets/css/jquery-ui-1.8.20.custom.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/fileuploader.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/css/reset.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>assets/css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/jquery-ui-timepicker-addon.css" /> 


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.configuration.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.8.20.custom.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/fileuploader.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/admin_wall2all.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
	var wall2all_base_url = '<?=base_url()?>';
	$(function() {
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "1900:2012" 
		});
		$('.timepicker_a').timepicker();
	});
	</script>
</head>
<body>