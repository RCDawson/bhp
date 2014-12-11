    <div class="cms-50w left">
    
    	<ul class="manage">
            <li class="alt">
        	<a href="/admin/pages/edit/<?php echo $parent->id?>/<?php echo $parent->id?>" title="edit <?php echo $parent->title?>"><b><?php echo $parent->title?></b></a>
                <dl class="cms-controls">
                    <dd><a href="/admin/pages/edit/<?php echo $parent->id?>/<?php echo $parent->id?>" class="edit"><span>edit</span></a></dd>
                </dl>
            </li>
        
        </ul>
    
<?php if( $rows ) { ?>
        
    	<ul class="manage sub">
        
<?php $i=0; foreach( $rows as $row ) { ?>
            <li>
            	
                <a href="/admin/pages/edit/<?php echo $row->id?>/<?php echo $parent->id?>" title="edit <?php echo $row->title?>"><b><?php echo $row->title?></b></a>
                                
                <dl class="cms-controls">
                    <dd><a href="/admin/pages/edit/<?php echo $row->id?>/<?php echo $parent->id?>" class="edit"><span>edit</span></a></dd>
                    <dd><?php if( $parent->parent == 1 ):?><a href="/admin/pages/delete/<?php echo $row->id?>/<?php echo $parent->id?>" class="delete" title="Delete this Sub Page"><span>delete</span></a><?php endif;?></dd>
                </dl>
                               
                <p><?php echo character_limiter(strip_tags($row->description), 80); ?></p>

            </li>
            <?php $i++; } ?>
        </ul>
        
<?php } else { ?>
        
        <p class="info warning"><span class="icon">&nbsp;</span> No sub pages have been created.</p>
        
<?php } ?>
    
    </div>
    
    <?php if( $parent->parent == 1 ) { ?>
    <div class="cms-50w right">
    
    	<form method="post" action="/admin/pages/insert/<?php echo $parent->id?>" id="pages-insert">
        
        	<h3>Create Page</h3>
            
            <p>
            	<label for="title">Title</label>
            	<br>
	            <input type="text" name="title" />
            </p>
            
            <p>
            	<label for="date">Date</label>
            	<br>
            	<input type="text" name="date" class="date" />
            </p>
            
			<p>            
				<label>Brief Description</label>
				<br>
				<textarea name="excerpt"></textarea>
            </p>
            <p>
	            <label>Description</label>
	            <br>
	            <textarea name="description" class="editor"></textarea>
    		</p>        
        
        	<input type="submit" value="Submit" />
            
            <a href="/admin/pages/manage/<?php echo $parent->id?>" class="cancel reset">cancel</a>            
        
        	<input type="hidden" name="action" value="pages-insert" />
        
        </form>
    
    </div>
<?php } ?>