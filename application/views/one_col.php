<?php if(!empty($page)) { ?>
<div class="row">
    <div class="twelve columns">
        <h1><?php echo(!empty($page->heading)) ? $page->heading : $page->title; ?></h1>
        <?php echo($page->content); ?>
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
//        		Debug::dump($this->template['partials']);exit;
        		foreach($template['partials']['_afterbody_partial'] as $k=>$v)
        		{
        			echo $v;
        		}
        	}
        ?>
    </div>
</div>
<?php } else { show_404(); } ?>