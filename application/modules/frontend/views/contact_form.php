<?php
// Let this page fail silently. It's intended to be used as a partial view.
if (!empty($page)) {

    if ($this->session->flashdata('success') == FALSE) {
?>
        <form action="" method="post" id="contact">
            <fieldset style="overflow: hidden">
                <label for="name">Name: <?php echo form_error('name'); ?></label>
                <input id="name" name="name" type="text" class="fields" value="<?php echo set_value('name'); ?>" maxlength="50" required tabindex="1" style="width: 90%">
                <input id="last_name" name="last_name" type="hidden" maxlength="50">
                <label>Email: <?php echo form_error('email'); ?></label>
                <input name="email" type="text" class="fields" value="<?php echo set_value('email'); ?>" maxlength="50" required tabindex="1" style="width: 90%">
                <label>Message: <?php echo form_error('themsg'); ?></label>
                <textarea name="themsg" id="excerpt" cols="40" rows="8" class="fields" tabindex="1" style="height:10em; resize:none; width: 90%"><?php echo set_value('themsg'); ?></textarea>
            </fieldset>

            <button type="submit" tabindex="1">Send</button>
        </form>
<?php } else { ?>
        <h3><em>Your message has been sent.</em></h3>
        <h4>Thank you for your interest in Bleeding Heart Publishing.</h4>
<?php } ?>
<!--<script type="text/javascript" src="/js/ckeditor-full/ckeditor.js"></script>-->
<?php } ?>

