<h2>Subscription Pricing</h2>

<div id="columns">

	<div class="column">
    
    	<form method="post" action="<?php echo $self?>" id="pages-subscription">
        
        	<?php foreach ( $settings as $key => $value ):?>
            
            <div class="col">
            
            <label>Title</label>
            <input type="text" name="<?php echo $key?>[title]" value="<?php echo $value->title?>" class="title" />
            
            <label>Description</label>            
            <textarea name="<?php echo $key?>[description]"><?php echo $value->description?></textarea>            
            
            	<?php foreach ( $value->pricing as $i => $item ):?>
                
                <fieldset>
                
                    <label>Title</label>
                    <input type="text" name="<?php echo $key?>[pricing][<?php echo $i?>][title]" value="<?php echo $item->title?>"/>
                    
                    <label>Price</label>
                    <input type="text" name="<?php echo $key?>[pricing][<?php echo $i?>][price]" value="<?php echo $item->price?>"/>
                    
                    <?php if ( isset($item->length) ):?>
                    <label>Length in years</label>
                    <input type="text" name="<?php echo $key?>[pricing][<?php echo $i?>][length]" value="<?php echo $item->length?>"/>
                    <?php endif;?>
                
                </fieldset>                      
                
                <?php endforeach;?>
            
            </div>    
            
            
            <?php endforeach;?>
            
            <br clear="all" />
            
            <input type="submit" value="save" />
        
        	<a href="/admin" class="cancel">cancel</a>
            
            <input type="hidden" name="action" value="pages-subscription" />
        
        </form>
    
    </div>

</div>