<h2>
<?php if( $parent ):?>
    <span class="crumb"><a href="/admin/pages/manage/<?php echo $parent->id?>"><?php echo $parent->title?></a> <strong>&raquo;</strong></span>
    <?php endif;?>
	<span class="crumb"><?php echo $row->title; ?> <strong>&raquo;</strong></span>
    <?php echo $template['title']; ?>
</h2>

<div id="columns">

	<div class="column w40">

        <form method="post" action="<?php echo current_url(); ?>" id="pages-delete">
        
            <p>Are you sure you want to delete: <strong><?php echo $row->title; ?></strong></p>            
            
            <input type="submit" value="Delete" />
            
            <a href="/admin/pages<?php echo $parent ? '/manage/' . $parent->id : ''?>" class="cancel">cancel</a>               
            
            <input type="hidden" name="action" value="pages-delete" />
        
        </form>
    
    </div>

</div>