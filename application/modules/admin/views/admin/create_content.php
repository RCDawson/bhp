<div>
    <label>Publish</label>
    <form method="post" action="<?php current_url(); ?>">
        <ul class="cms-form-errors">
            <?php echo validation_errors(); ?>
        </ul>
        <div class="six columns left">
            <p>
                <label>Username</label>
                <input type="text" name="title" value="<?php echo set_value('title'); ?>" maxlength="30" required>
            </p>
            <p>
                <label>Email</label>
                <input type="text" name="email" value="<?php echo set_value('email'); ?>" />
            </p>
        </div>
        <div class="cms-50w right">
            <p>
                <label>First Name</label>
                <br>
                <input type="text" name="first_name"  value="<?php echo set_value('first_name'); ?>" />
                <br>
                <label>Last Name</label>
                <br>
                <input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>" />
                <br>
                <label>User Role</label>
                <br>
                <input type="radio" name="role" value="1" <?php echo set_radio('role', '1'); ?> >
                <label>Admin</label>
                <br>
                <input type="radio" name="role" value="0" <?php echo set_radio('role', '0', TRUE); ?> >
                <label>Default</label>
            </p>
        </div>
        <div class="cms-70w left">
            <input type="submit" value="Add User" name="submit" />
        </div>
    </form>
    <div class="pods">
        <label>Extras</label>
        <ul>
            <li>Side bar: 
                <select>
                    <option><?php echo(!empty($page->sidebar_content->friendly)) ? $page->sidebar_content->friendly : 'None'; ?></option>
                </select>
            </li>
        </ul>
    </div>
</div>