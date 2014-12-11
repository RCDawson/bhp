<?php echo 'settings view'; exit; ?>
<div class="cms-30w">
    <form action="<?php echo current_url(); ?>" method="post" id="cms-login-form" >
        <p style="color:#636363"><em>Please login to continue.</em></p>
        <p><input name="login-user" type="text" /></p>
        <p><input name="login-pass" type="password" /></p>
        <p><input type="submit" value="LOGIN" /></p>
        <p><input name="user_id" type="hidden" /></p>
    </form>
</div>