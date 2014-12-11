<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Accepts an object of arrays
 * Requires each array to have a '_helper' key
 */

if ( ! function_exists('get_pods'))
{
	function get_pods($pods)
	{
		if($pods)
		{
			$CI =& get_instance();
			$CI->load->library('wrap_block');
			
			$pods_arr = array();

			foreach($pods as $pod)
			{
				$CI->load->helper($pod->_helper);
				$helper = $pod->_helper;
				$heading = (!empty($pod->_heading)) ? $heading = $pod->_heading : '';
				$pods_arr[] = '<h2>'.$heading.'</h2>'.$helper($pod);
			}

			foreach($pods_arr as $k=>$pod)
			{
				$output = $CI->wrap_block($pod,'div','pod one-third');
				echo $output;
			}
		}
	}
} // End get_pods