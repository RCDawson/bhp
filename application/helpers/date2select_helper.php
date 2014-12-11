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
 * @return	MySQL datetime field to select menu
 * @date	var		required	need a date to process
 * @time	var		optional	defaults to 00:00:00
 */

if ( ! function_exists('date2select'))
{

	function date2select($date,$time=null)
	{
		$datetime = strtotime($date);
		$m = date("m",$datetime);
		$d = date("d",$datetime);
		$y = date("y",$datetime);
		$g = date("g",$datetime);
		$i = date("i",$datetime);
		$A = date("A",$datetime);
		return '<select><option>'.$m.'/'.$d.'/'.$y.' '.$g.':'.$i.' '.$A.'</option></select>';
/*            if( $link==$CI->uri->segment($segment))
            {
                if ($link == NULL) { $link = "logo"; } // Necessary for home page (since it's not a sub directory)
                return $link . ' base'; // Adds CSS class name 'base' to links matching site location.
            }
            else
            {
                if ($link == NULL) { $link = "logo"; } // Necessary for home page (since it's not a sub directory)
                return $link;
            }
*/    }
}
