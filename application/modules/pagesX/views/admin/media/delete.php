<h2>
    <?php if( $parent ):?><span class="crumb"><a href="/admin/pages/manage/<?php echo $parent->id?>"><?php echo $parent->title?></a> <strong>&raquo;</strong></span><?php endif;?>
    <span class="crumb"><a href="/admin/pages/edit/<?php echo $page->id?><?php echo $parent ? '/' . $parent->id : ''?>"><?php echo $page->title?></a> <strong>&raquo;</strong></span> 
    Delete Media
</h2>

<div id="columns">

	<div class="column w40">

        <form method="post" action="<?php echo $self?>" id="pages-media-delete">
        
            <p>Are you sure you want to delete <strong><?php echo $row->title ? $row->title : $row->file?></strong></p>
            
            <p><a href="/uploads/images/pages/<?php echo $row->file?>" class="img" target="_blank"><img src="/images/thumb/150,150/height/uploads/images/pages/<?php echo $row->file?>" title="<?php echo $row->title?>" alt="<?php echo $row->title?>"/></a></p>
            
            <input type="submit" value="Delete" />
            
            <a href="/admin/pages/edit/<?php echo $page->id?><?php echo $parent ? '/' . $parent->id : ''?>" class="cancel">cancel</a>                
            
            <input type="hidden" name="action" value="pages-media-delete" />
        
        </form>
    
    </div>

</div>