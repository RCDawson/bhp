<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['_heading']	= 'Pages';
$config['_model'] 	= 'pages_model';
$config['_args'] = 'page';
$config['li'] = array('tag'=>'li', 'class'=>'pages_dashboard li class');
$config['_method'] 	= 'get_all';