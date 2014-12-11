<h2>** Profile View **</h2>

<div id="columns">

    <div class="column w35">
    
    	<div>

			<h3>My Info</h3>
		
			<dl class="info">
			
				<dt>username</dt>
				<dd><?php echo $row->username?></dd>
				
				<dt class="alt">first name</dt>
				<dd><?php echo $row->first_name?></dd>
				
				<dt>last name</dt>
				<dd><?php echo $row->last_name?></dd>
				
				<dt class="alt">email</dt>
				<dd><?php echo $row->email?></dd>
				
				<dt>members since</dt>
				<dd><?php echo $row->created_formatted?></dd>
			
			</dl>
        
        <a href="/admin/users/edit" class="edit">edit profile</a>
    	
    	</div>
        
    </div>
    
    <div class="column w35">
    
    	<h3>Update Password</h3>
        
        <form method="post" action="/admin/users/edit" id="users-edit-password">
        
        	<label>Current Password</label>
            <input type="password" name="password_current" />
            
            <label>New Password</label>
            <input type="password" name="password_new" />
            
            <label>Confirm New Password</label>
            <input type="password" name="password_confirm" />
        
        	<input type="submit" value="Update" />
        
        	<a href="<?php echo $self?>" class="cancel reset">cancel</a>
        
        	<input type="hidden" name="action" value="users-edit-password" />
        
        </form>
    
    </div>
    
</div>