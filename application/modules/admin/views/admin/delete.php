<div class="cms-40w left">
<?php if($content) { ?>
	<form method="post" action="<?php current_url(); ?>">
        <p>Are you sure you want to <strong>delete <?php echo $content->title; ?></strong>?</p>
        <input type="submit" name="submit" value="Delete" />
        <a href="/admin/users" class="cancel">cancel</a>
    </form>
<?php } else { ?>
	<p><strong>Error: </strong><em>Can't find the content you're trying to delete. Maybe it's already been deleted.</em></p>
<?php } ?>
</div>