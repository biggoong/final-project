<form method="POST" action="?page=user&action=registration">
    <label>Nickname</label>
    <input name="nickname" />
    <label>Email</label>
    <input name="email" />
    <label>Password</label>
    <input type="password" name="password" />
    <label>Comfirm password</label>
    <input type="password" name="password_confirm" /><br />
    <input type="submit" name='send' value='Sign In' />
</form>
<p><?php echo $data; ?></p>