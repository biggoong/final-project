<form method="POST" action="?page=user&action=login">
    <input type="hidden" name="account_token" value="<?php echo $data['account_token'];?>" />
    <label>Email</label>
    <input name="email" />
    <label>Password</label>
    <input type="password" name="password" /><br />
    <input type="submit" name='send' value="Log In" />
</form>
<p><?php echo $data['error']; ?></p>