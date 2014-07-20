<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
#content{
	margin:50px 0 0 50px;
}
#content textarea{
	width:300px;
}
</style>
</head>

<body>
<div id="content">
<?php
 $attr = array(
            'class' => 'up_form', 
			'id' => 'up_form',
			'name' => 'upload',
            );
echo form_open_multipart(base_url().'testupload/', $attr)?>
<p><textarea name="posttext"></textarea></p>
<p><?php echo form_upload('userfile'); ?>
</p>
<p><?php echo form_submit('upload', 'Upload'); ?></p>
</form>
<?php if(isset($file_name)): ?>
<div id="img">
  <img src="<?=base_url()?>assets/testupload/<?=$file_name?>"
</div>
<?php endif; ?>
</div>
</body>
</html>
