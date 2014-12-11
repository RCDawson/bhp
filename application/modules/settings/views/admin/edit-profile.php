<p>
    <span class="crumb">Profile <strong>&raquo;</strong></span> Edit
</p>

<div id="columns">

	<div class="column">
    
    	<form method="post" action="<?php echo $self?>" id="users-edit">
        
        	<label>First Name</label>
            <input type="text" name="first_name" value="<?php echo $row->first_name?>" />
            
            <label>Last Name</label>
            <input type="text" name="last_name" value="<?php echo $row->last_name?>" />
            
            <label>Email</label>
            <input type="text" name="email" value="<?php echo $row->email?>" />   
        
        	<input type="submit" value="Update" />
        
        	<a href="/admin/profile" class="cancel">cancel</a>
        
        	<input type="hidden" name="action" value="users-edit" />
        
        </form>
    
    </div>

</div>