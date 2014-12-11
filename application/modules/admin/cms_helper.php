<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------

/*
 * CodeIgniter Selected Navigation Helper
 *
 * @author		Ryan Dawson
 */

// ------------------------------------------------------------------------

/**
 * States
 *
 * @access	public
 * @return	CSS to highlight links with .current class
 */

if ( ! function_exists('cms_nav'))
{

	function cms_nav($link, $segment=NULL)
	{
			debug::dump($this);
            $CI =& get_instance();
            if( $link==$CI->uri->segment($segment))
            {
                if ($link == NULL) { $link = "dashboard"; } // Necessary for home page (since it's not a sub directory)
                $link = ' class="current"';
                return $link; // Adds CSS class name 'base' to links matching site location.
            }
       }
}