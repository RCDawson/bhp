    <?php
    // Returns an array of objects
    foreach($info as $edit_user) {

        /*@ Documentation
         *  Popluate the form on initial render with user-to-be-edited's information.
         *  Use form_validation handler after form processing begins.
        */

        if($edit_user->id == $this->uri->segment(4)) {
            if(!$this->input->post('submit')) {
                $uname = $edit_user->username;
                $fname = $edit_user->first_name;
                $lname = $edit_user->last_name;
                $email = $edit_user->email;
                ($edit_user->role=="1") ? $role1='checked' : $role1='checked';
                ($edit_user->role=="0") ? $role0='checked' : $role0='';
            }
            else {
                $uname = set_value('username');
                $fname = set_value('first_name');
                $lname = set_value('last_name');
                $email = set_value('email');
                $role1 = set_radio('role','1');
                $role0 = set_radio('role','0');
            }
            //Debug::dump($info,true);
            ?>
    <div class="cms-50w left">

        <form method="post" action="<?php current_url(); ?>" id="users-edit">
            <h3>Edit Profile Information</h3>
            <dl class="cms-form-errors">
                        <?php echo validation_errors(); ?>
            </dl>
            <div class="cms-50w left">
                <p>
                    <label>Username</label>
                    <br>
                    <input type="text" name="username" value="<?php echo $uname; ?>" maxlength="15" /><?php //echo form_error('username'); ?>
                    <br>
                    <label>Email</label>
                    <br>
                    <input type="text" name="email" value="<?php echo $email; ?>" maxlength="50" />
                </p>
            </div>
            <div class="cms-50w right">
                <p>
                    <label>First Name</label>
                    <br>
                    <input type="text" name="first_name"  value="<?php echo $fname; ?>"  maxlength="10"/>
                    <br>
                    <label>Last Name</label>
                    <br>
                    <input type="text" name="last_name" value="<?php echo $lname; ?>" maxlength="15" />
                    <br>
                    <label>User Role</label>
                    <br>
                    <input type="radio" name="role" value="1" <?php echo $role1; ?> >
                    <label>Admin</label>
                    &nbsp;&nbsp;
                    <input type="radio" name="role" value="0" <?php echo $role0; ?> >
                    <label>Default</label>
                </p>
            </div>
            <div class="cms-70w">
                <p>
                    <input type="submit" value="Save Changes" name="submit" />
                    <a href="/admin/users/" title="Cancel">cancel</a>
                </p>
            </div>

        </form>
    </div>
<?php }}/*
    <div class="cms-50w right">

        <form method="post" action="<?php current_url(); ?>">
            <h3>Reset Password</h3>
            <dl class="cms-form-errors">
                        <?php echo validation_errors(); ?>
            </dl>
            <div class="cms-50w left">
                <p>
                    <label>Password</label>
                    <br>
                    <input type="password" name="current-pass" value="<?php echo set_value('current-pass'); ?>" />
                    <br>
                    <label>Confirm Password</label>
                    <br>
                    <input type="password" name="current-match" value="<?php echo set_value('current-match'); ?>" />
                    <label>New Password</label>
                    <br>
                    <input type="password" name="password" value="<?php echo set_value('password'); ?>" />
                </p>
                <p>
                    <input type="submit" value="Reset Password" name="submit" />
                    <a href="/admin/users/" title="Cancel">cancel</a>
                </p>
            </div>

        </form>
                <?php }
    }
    ?>
    </div>
 *
 */?>