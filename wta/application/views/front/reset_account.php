<div class="container">
<div class="sixteen columns signup">
<div class="seven columns offset-by-one omega">
<?php if(isset($successfully_sent)): ?>
<p>Your new password has been successfully sent to your email!<br/><br/>
<a href="<?=base_url()?>register/">Go back to the login page</a>
</p>
<?php elseif(isset($no_email)): ?>
<p>There is no user with such email address!</p>
<?php else: ?>
<form action="<?=base_url()?>reset-account/" method="post">
<p><label for="recover_email">Enter your email address</label>
<input type="text" name="recover_email" /></p>
<p><input type="submit" name="submit_recover_email" value="Send"></p>
</form>
<?php endif; ?>
</div>
<div class="seven columns offset-by-one alpha" >
</div><div class="clear"></div>
</div>
</div>
