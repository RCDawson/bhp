<div class="cms-40w left">
    <form method="post" action="<?php current_url(); ?>">
        <p>Are you sure you want to delete <strong><?php echo $row->first_name . ' ' . $row->last_name?></strong></p>
        <input type="submit" name="submit" value="Delete" />
        <a href="/admin/users" class="cancel">cancel</a>
    </form>
</div>