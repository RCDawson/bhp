<?php //debug::dump($this);die; ?><!DOCTYPE html><html>    <head>        <title><?php echo (!empty($this->config->item('site_name'))) ? $this->config->item('site_name') . ' : ' : ''; echo $template['title']; ?></title>        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        <link type="text/css" rel="stylesheet" href="/css/base.css">        <link type="text/css" rel="stylesheet" href="/css/irespond.css"><!--        <link type="text/css" rel="stylesheet" href="/css/layout.css">-->        <link rel="stylesheet" href="/cms/css/cms.css" type="text/css">        <script type="text/javascript" src="/js/jquery-1.9.0.js"></script>        <script type="text/javascript" src="/js/jquery-migrate-1.0.0.js"></script>    </head>    <body>		<div id="cms-container" class="<?php echo $this->router->fetch_method();?>">            <?php                // Hide Log Out / Support buttons if NOT authenticated                if($this->config->item('authenticated')) {            ?>            <div id="cms-header">                <ul id="cms-nav">                    <li<?php echo cms_nav('',2)?>><a href="/admin">Dashboard</a>                    </li>                    <li<?php echo cms_nav('users',2)?>><a href="/admin/users">Manage Users</a>                    </li>                </ul>                <ul id="cms-user-panel">                    <li id="cms-user">                        <b><a href="/admin/users/edit/<?php echo $this->session->userdata('uid'); ?>"><span class="cms-icon user"></span><?php echo $this->session->userdata('disp_name'); ?></b></a>                    </li>                    <li><a href="/admin/logout">Logout</a></li>                    <li<?php echo cms_nav('support',2)?>><a href="/admin/support">Support</a></li>                </ul>            </div>                <?php } // End Hide Log Out / Support buttons ?>            <?php   // Anybody set a breadcrumb?? Show it.                    if(!$this->config->item('hidebreadcrumbs') && !empty($template['breadcrumbs'])) {            ?>            <p class="breadcrumbs"><b><!--<a href="/admin/dashboard">Dashboard</a>-->                        <?php                        $divider = (count($template['breadcrumbs']) > 1) ? '/' : '';                        foreach($template['breadcrumbs'] as  $bc)                        {                                echo '<a href="' . $bc['uri'] . '">' . $bc['name'] . '</a> / ';                        }                        echo $template['title'];                        ?></b></p>            <?php   } // End breadcrumbs // ?>            <h1><?php echo $template['title']; ?></h1>            <?php $this->template->alerts('p');?>            <?php echo $template['body']; ?>        </div>        <div id="cms-footer">            <div id="cms-footer-container">            	<?php /*                <!--                    <p class="vcard cms-50w left">                            <span class="adr"><a class="extended-address" href="http://www.industrialfiresafety.com">INDUSTRIAL FIRE &amp; SAFETY EQUIPMENT</a></span><br>                            <span class="street-address">3801 4th Terrace North</span>, <span class="locality">Birmingham</span>,<br>                            <span class="region">Alabama</span> <span class="postal-code">35222</span> <b class="country">United States</b><br>                            <span class="tel"><span class="value">(205) 591-9660</span></span><br>		</p>                <dl class="vcard cms-50w left">                    <dd><span class="adr"><a class="extended-address" href="http://www.industrialfiresafety.com"><b><?php echo $info->name; ?></b></a></span><br>                        <span class="street-address"><?php echo $info->address; ?></span><br>                        <span class="locality"><?php echo $info->city; ?></span>, <span class="region"><?php echo $info->state; ?></span> <span class="postal-code">35222</span>, <span class="country">United States</span><br>                        <span class="tel"><span class="value"><?php echo $info->phone; ?></span></span>                    </dd>                </dl>                -->                */ ?>                <p class="cms-50w right" style="text-align:right">                    &copy; 2012 - <?php echo date('Y'); ?> <a target="_blank" class="author" href="http://www.iamryandawson.com">Ryan Dawson</a>. All Rights Reserved.                </p>            </div>        </div>        <script type="text/javascript" src="/js/common.js"></script>        <?php // Script files        if(!empty($template['partials']['js'])) {            echo '<script type="text/javascript" src="'.$template['partials']['js'].'"></script>';        }        ?>    </body></html>