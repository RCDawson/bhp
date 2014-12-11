<div class="cms-30w">
    <?php echo validation_errors(); ?>
    <form action="<?php echo current_url(); ?>" method="post">
        <p style="color:#636363"><em>Site Settings</em></p>
        <p><input name="option_name" type="text" value="<?php echo set_value('option_name'); ?>"></p>
        <p><input name="option_value" type="text" value="<?php echo set_value('option_value'); ?>"></p>
        <p><input type="submit"></p>
    </form>
</div>