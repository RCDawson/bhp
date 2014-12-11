<div id="columns">
	<div class="column w60">
    
    	<form method="post" action="<?php echo current_url(); ?>" id="pages-edit">        
        	
            <label>Title</label>
            <input type="text" name="title" value="<?php echo $row->title?>" />
            
<!-- 
            <?php if ( $settings->date == 1 || (isset($parent) && $parent->type == 'web-wednesday' && !empty($row->parent_id))):?>
 -->
            <label>Date</label>
            <input type="text" name="date" class="date" value="<?php echo substr($row->date, 0, 10)?>" />
<!-- 
            <?php endif;?>
 -->
            
            <?php if ( $row->id == 1):?>
            
            <label>Brief Description</label>
            <textarea name="excerpt"><?php echo $row->excerpt?></textarea>
            
            <?php endif;?>
            
            <label>Description</label>
            <textarea name="description" class="editor"><?php echo $row->description?></textarea>
                
        	<input type="submit" value="Update" />            
            
            <a href="/admin/pages<?php echo $parent ? '/manage/' . $parent->id : ''?>" class="cancel">cancel</a>  
            
            <input type="hidden" name="action" value="pages-edit" />
        
        </form>
    
    </div>
    
    <?php if( $row->media ):?>
    
    <div class="column w40">        
            
        <?php if( $row->media == 'image' ): // Get an image for this item ?>
            
        <form method="post" action="/admin/pages/media/insert/<?php echo $row->id; ?>" id="pages-media-insert" enctype="multipart/form-data";>
    	
            <h3>Media</h3>
            
            <?php if( $media ):?>
                <label>Current Image</label>
                <p><img src="/images/thumb/200,200/width/uploads/images/pages/<?php echo $media[0]->file; ?>" /></p>
                <p><a href="/admin/pages/media/delete/<?php echo $media[0]->id?>/<?php echo $row->id?>">remove image</a></p>
            <?php else:?>
                <p>No image attached to page</p>
            <?php endif;?>
            
            <label>Upload Image</label>
            <input type="file" name="file" />
            
            <input type="submit" value="Upload" />
            
            <a href="<?php echo current_url(); ?>" class="cancel reset">cancel</a>
            
            <input type="hidden" name="type" value="<?php echo $row->media?>" />           
            <input type="hidden" name="id" value="<?php echo $media ? $media[0]->id : ''?>" />                
            <input type="hidden" name="return" value="<?php echo current_url(); ?>" />
        
            <input type="hidden" name="action" value="pages-media-insert" />
            
        </form>
            
        <?php elseif( $row->media == 'images' ):?>
        
            
            <form method="post" action="/admin/pages/media/insert/<?php echo $row->id?>" id="pages-media-insert" enctype="multipart/form-data">
            
				<?php if( $media ):?>
                
                <ul class="manage thumbnails">
                
                <?php $i=0; foreach( $media as $item ):?>
                
                    <li<?php echo $i%2==1 ? ' class="alt"' : ''?>>
                    
                        <a href="/uploads/images/pages/<?php echo $item->file?>" target="_blank" class="img"><img src="/images/thumb/100,100/height/uploads/images/pages/<?php echo $item->file?>" alt="<?php echo $item->title?>" title="<?php echo $item->title?>"/></a>
                    
                        <span class="controls">
                            <a href="/admin/pages/media/edit/<?php echo $item->id?>/<?php echo $row->id?><?php echo $parent->id ? '/' . $parent->id : ''?>" class="edit">edit</a>
                            <a href="/admin/pages/media/delete/<?php echo $item->id?>/<?php echo $row->id?><?php echo $parent->id ? '/' . $parent->id : ''?>" class="delete" title="delete">delete</a>
                        </span>   
                    
                    </li>
                
                <?php $i++; endforeach;?>
                
                </ul>
                
                <?php else:?>   
                         
                <p>No images atteched to page.</p>  
                          
                <?php endif?>
                            
            	<h3>Upload Image</h3>
            
            	<label>Title</label>
                <input type="text" name="title" />
                
                <label>Description</label>
                <textarea name="description"></textarea>
                
                <label>Image</label>
                <input type="file" name="file" />
                
                <input type="submit" value="Upload" />
                
                <a href="<?php echo $self?>" class="cancel reset">cancel</a>
            
                <input type="hidden" name="type" value="<?php echo $parent->media?>" />                      
                <input type="hidden" name="return" value="<?php echo $self_uri?>" />
            
                <input type="hidden" name="action" value="pages-media-insert" />
            
            </form>
            
        <?php elseif( $row->media == 'video' ):?>
        
        <p class="info warning">Ability currently not available</p>
        
        <?php elseif( $row->media == 'videos' ):?>
        
        <p class="info warning">Ability currently not available</p>
        
        <?php elseif( $row->media == 'media' ):?>
        
        <p class="info warning">Ability currently not available</p>
        
        <?php endif;?>
    
    </div>
    
    <?php endif;?>
</div>