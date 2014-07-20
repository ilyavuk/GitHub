<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/loginstyle.css" />
<title>Login</title>
</head>

<body>
<div id="loginContent">
<h1>Admin login</h1>
<form action="<?=base_url()?>admin" method="post" name="form" >
<p class="error_login"><?=(isset($error_loggin))?'Incorrect combination email/password':false?></p>
<p><label for="name">Username</label></p>
<p><input name="username" type="text" /></p>
<p></p>
<p><label for="password">Password</label></p>
<p><input name="password" type="password" /></p>
<p><input type="submit" name="submit" value="Log in" /></p>
</form>
</div>
</body>
</html>
