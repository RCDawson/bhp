<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('cms_nav'))
{
	function cms_nav($link, $segment=NULL)
	{
		$CI =& get_instance();
		if( $link==$CI->uri->segment($segment))
		{
			if ($link == NULL) { $link = "dashboard"; } // Necessary for home page (since it's not a sub directory)
			$link = ' class="current"';
			return $link; // Adds CSS class name 'base' to links matching site location.
		}
	}
}