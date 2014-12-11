<?php
if(!empty($page)) { ?>
<div class="row">
    <div class="four columns">
    <!--
        <img src="assets/imgs/bhp/heroes/transfusion.jpg">
        <p style="width:250px; text-align:center;"><a href="http://www.amazon.com/Transfusions-Edition-1-ebook/dp/B00EHA5KWW/ref=sr_1_1?s=books&ie=UTF8&qid=1376369038&sr=1-1&keywords=Transfusions+Edition+1" title="Transfusion - Edition 1 is available now!" target="_blank">Available now for Kindle<img src="imgs/bhp/amazon-kindle-logo.jpg"></a>
    -->
        <img src="assets/imgs/bhp/heroes/transfusion-v2.jpg">
        <p style="width:250px; text-align:center;"><a href="http://www.amazon.com/Transfusion-ebook/dp/B00FYNN686/ref=sr_1_2?s=books&ie=UTF8&qid=1382025516&sr=1-2&keywords=transfusion" title="Transfusion - Edition 1 is available now!" target="_blank">Available now for Kindle<img src="imgs/bhp/amazon-kindle-logo.jpg"></a>
        </p>
    	<?php
            if(!empty($sidebars)) {
                foreach($sidebars as $sidebar) {
                  if($sidebar->meta_key=='sidebar') {
                    echo'<h2>'.$sidebar->heading.'</h2>';
                    echo($sidebar_charlimit) ? character_limiter($sidebar->content, $sidebar_charlimit):$sidebar->content;
                  }
                }
              } 
        ?>
    </div>
    <div class="eight columns">
    
        <h1>Transfusion</h1>
    	<?php echo($page->content); ?>
    	<?php
    	if(!empty($page->kids))
    	{
    		foreach($page->kids as $kid)
    		{
    			echo '<hr style="margin:1.667em 0">'."\n";
				echo '<h2 style="display:inline-block; margin-right:1ex;"><em>'.$kid->heading.'</em></h2><span>'.$kid->excerpt.'</span><br>'."\n";    			
    			echo '<div style="border-left:2px solid #efefef; padding-left:2ex; margin-bottom:3.33334em">';
				echo $kid->content."\n";    			
				echo '</div>'."\n";    			
    		}
    	}
    	?>
    </div>
</div>
<?php } ?>