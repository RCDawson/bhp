<?php 
if(!empty($page)) { ?>
    <div class="eight columns">
        <h1><?php echo(!empty($page->heading)) ? $page->heading : $page->title; ?></h1>
        
        <?php echo($page->content); ?>
        
        <?php 
        if(!empty($featured_author))
        {
        	$this->load->view('featured_author');
        }
        ?>
        <?php //if(!empty($template['partials']['_afterbody_partial'])) {
            //foreach($template['partials'] as $k=>$v) {
            //    echo($v);
            //}
        //}
        //echo(serialize("\$this->frontend_model->contact_form();"));
        ?>
        <?php echo(!empty($template['partials']['_prebody_partial']))?$template['partials']['_prebody_partial']:''; ?>
        <?php
        	if(!empty($template['partials']['_afterbody_partial']))
        	{
        		echo $template['partials']['_afterbody_partial'];
        	}
        ?>
    </div>
    <div class="four columns">
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
<?php } ?>