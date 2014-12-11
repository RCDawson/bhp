<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['_heading']	= 'Sidebars';
$config['_model'] 	= 'pages_model';
$config['_args'] = 'sidebar';
$config['li'] = array('tag'=>'li', 'class'=>'sidebar li class');
$config['_method'] 	= 'get_all';