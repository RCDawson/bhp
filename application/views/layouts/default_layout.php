<?php //Debug::dump($main_nav,'default_layout'); ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
    <head>

        <!-- Basic Page Needs
  ================================================== -->
        <meta charset="utf-8">
        <title><?php echo (!empty($site_name)) ? $site_name.' : '.$template['title'] : $template['title']; ?></title>
        <?php echo $template['metadata']; ?>

        <!-- Mobile Specific Metas
  ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS
  ================================================== -->
        <link rel="stylesheet" href="/css/base.css">
        <link rel="stylesheet" href="/css/irespond.css">
        <link rel="stylesheet" href="/css/bhp.css">

        <!--[if lt IE 8]><link rel="stylesheet" href="/css/ieBS.css" type="text/css"><![endif]-->
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

        <!-- Favicons
	================================================== -->
        <link rel="shortcut icon" href="favicon.ico">
        <!--
        <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
        -->
        <?php // JavaScript files from controller **inject_partial($name, $value or $value as array())**
        if(!empty($template['partials']['js'])) {
            foreach ( $template['partials']['js'] as $k => $v ) {
                echo ('<script type="text/javascript" src="'.$v.'"></script>'."\n");
            }
        }
        ?>

    </head>
    <body id="<?php echo $this->uri->segment(1); ?>">
        <div id="header">
            <div id="logo" class="row">
                <div class="container">
                    <img src="/imgs/bhp/bleeding-heart-logo.png" alt="Bleeding Heart Publications">
                </div>
            </div>
            <div id="nav" class="row">
                <h3 id="menu-toggle"><span>menu</span></h3>
                <ul class="container">
                    <?php
                        if(!empty($main_nav)) {
                            foreach($main_nav as $link) {
                                if($link->url=='home') { $link->url=''; }
                                echo '<li><a href="/'.$link->url.'" title="'.$link->link_text.'" '.selected($link->url,1).'>'.$link->link_text.'</a></li>';
                            }
                        }
                    ?>
                </ul>
            </div>
        </div>
        <div class="container" id="main">
            <div class="row">
                <?php echo $template['body']; ?>
            </div>
	        <div class="row">
    	    	<div class="twelve columns">
		        	<div class="bird-border"></div>
            	</div>
        	</div>
        </div>
	        <div id="footer" class="row">
	        	<div class="container">
	    	    	<div class="eight columns">
	    	    		<ul id="socials">
	    	    			<li id="fb"><h5><a href="http://www.facebook.com/BleedingHeartPublications"><span></span>Follow Us</a></h5></li>
	    	    		</ul>
	    	    	</div>
	    	    	<div class="four columns">
    	    		    <h5 class="right">&copy; <?php date_default_timezone_set("America/Chicago");
                		echo date("Y"); ?> BH Publications PTE Ltd. All Rights Reserved.</h5>
        	    	</div>
				</div>
        	</div>

        <script type="text/javascript" src="/js/jquery-1.9.0.js"></script>
        <script type="text/javascript" src="/js/jquery-migrate-1.0.0.js"></script>
        <script type="text/javascript">
            $(function () {
                $('#menu-toggle').click(function() {
                    $('#nav ul').slideToggle();
                })
            })
        </script>
        <?php if($_SERVER['HTTP_HOST'] != 'bhp.local') { ?>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-43431152-1', 'auto');
            ga('send', 'pageview');

        </script>
        <?php } ?>
    </body>
</html>