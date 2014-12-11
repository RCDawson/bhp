<?php // Location: /modules/users/views/admin/index ?>
<div class="cms-50w left">

    <?php if( $rows ) { ?>

    <ul class="manage">

    <?php
    // Start Listing users
    $i=0;
    foreach( $rows as $row ) {
        // Hide current user
        if($row->id != $this->session->userdata('uid')){
    ?>

        <li <?php echo ($i%2==1) ? ' class="alt"' : ''; ?>>
            <b><?php echo $row->first_name . ' ' . $row->last_name; ?></b>

            <dl class="cms-controls">
                <dd><a href="/admin/users/edit/<?php echo $row->id ?>" class="edit" title="Edit"><span>edit</span></a></dd>
                <dd><a href="<?php echo current_url() . '/delete/' . $row->id?>" class="delete" title="Delete"><span>delete</span></a></dd>
            </dl>

            <p><?php echo $row->username?>
                <br />
                <a href="mailto:<?php echo $row->email; ?>" title="Send an email"><?php echo $row->email; ?></a>
            </p>
        </li>

    <?php
        $i++;
        } // End hide current user
    } // End Listing users
    ?>
    </ul>

    <?php } else { ?>

    <p class="cms-icon warning">No other users have been added.</p>

    <?php } // End if( $rows ) ?>

</div>

<div class="cms-50w right">

    <form method="post" action="/admin/users" id="users-insert">
        <h3>Add User</h3>
        <dl class="cms-form-errors">
            <?php echo validation_errors(); ?>
        </dl>
        <div class="cms-50w left">
            <p>
                <label>Username</label>
                <br>
                <input type="text" name="username" value="<?php echo set_value('username'); ?>" />
                <br>
                <label>Password</label>
                <br>
                <input type="password" name="password" value="<?php echo set_value('password'); ?>" />
                <br>
                <label>Confirm Password</label>
                <br>
                <input type="password" name="repassword" value="<?php echo set_value('repassword'); ?>" />
                <br>
                <label>Email</label>
                <br>
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

</div>