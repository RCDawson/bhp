<h2>
    <?php if( $parent ):?><span class="crumb"><a href="/admin/pages/manage/<?php echo $parent->id?>"><?php echo $parent->title?></a> <strong>&raquo;</strong></span><?php endif;?>
    <span class="crumb"><a href="/admin/pages/edit/<?php echo $page->id?><?php echo $parent ? '/' . $parent->id : ''?>"><?php echo $page->title?></a> <strong>&raquo;</strong></span> 
    Edit Media
</h2>

<div id="columns">

	<div class="column">

        <form method="post" action="<?php echo $self?>" id="pages-media-edit">
        
        	<label>Image</label>
        	<p><a href="/uploads/images/pages/<?php echo $row->file?>" class="img" target="_blank"><img src="/images/thumb/100,100/height/uploads/images/pages/<?php echo $row->file?>" title="<?php echo $row->title?>" alt="<?php echo $row->title?>"/></a></p>
        
        	<label>Title</label>
            <input type="text" name="title" value="<?php echo $row->title?>" />
            
            <label>Description</label>
            <textarea name="description"><?php echo $row->description?></textarea>
            
            <input type="submit" value="Update" />     
            
            <a href="/admin/pages/edit/<?php echo $page->id?><?php echo $parent ? '/' . $parent->id : ''?>" class="cancel">cancel</a>                
            
            <input type="hidden" name="action" value="pages-media-edit" />
        
        </form>
    
    </div>

</div>