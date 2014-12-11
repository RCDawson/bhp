<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------

/**
 * CodeIgniter Selected Navigation Helper
 *
 * @author		Ryan Dawson
 */

// ------------------------------------------------------------------------

/**
 * States
 *
 * @access	public
 * @return	CSS to highlight links with .selected class
 */

if ( ! function_exists('selected'))
{

	function selected($link, $segment=NULL)
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
