<?php
if($payload)
{
    $lastOne = count($payload);
    $i = 1;
    $html = '<h1>Media</h1><div class="eight columns content_list">';
    foreach ($payload as $media)
    {
        $html .= '<h3>' . $media['heading'] . '</h3>';
        $html .= '<p>' . $media['content'] . '</p>';
        $html .= ($i != $lastOne) ? '<hr>' : '';
        ++$i;
    }
    $html .= '</div>';
    echo $html;
}
?>
<div class="four columns">&nbsp;</div>
<?php if(!empty($XXXpage)) { ?>
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