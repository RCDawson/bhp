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

if ( ! function_exists('dashboard'))
{

	function dashboard($pods)
	{
		if($pods)
		{
			foreach($pods as $pod) {
				$heading = (!empty($pod->_heading)) ? $heading = $pod->_heading : $heading = '';

				$output = '<div class="pod one-third">'."\n\t\t";
				$output .= '<h2>'.$heading.'</h2>'."\n\t\t".'<ul>'."\n\t\t\t";
				if(!empty($pod->_helper) && !empty($pod->pages) && is_array($pod->pages))
				{
//					debug::dump($pod->_helper);exit;
					$func = $pod->_helper;
					$output .= $func($pod->pages);
				}
				else 
				{
					$output .= default_pod($pod);
				}
				$output .= "\n\t\t".'</ul>'."\n\t".'</div>'."\n";
				echo $output;
			}
		}
	}
}

if ( ! function_exists('media_list'))
{
	// Expects an array of objects
	function media_list($array_objs, $path=null, $clickable=true)
	{
		$empty = '<em class="empty">-not set-</em>';
		$path = APPPATH.'media/';
//		$path = APPPATH.$path;
		$output .= '<ul class="cms-dash-pod">'."\n";
		
		foreach($array_objs as $media) {
//		debug::dump($media);exit;
			if(empty($media->title)) $media->title=$empty;
			if(empty($media->file)) $media->file=$empty;
			$output .= '<li>file: '.$media->title.', path: '.$path.$media->file.'</li>'."\n";
		}
		$output .= '</ul>'."\n".'</div>';
		return $output;
	}
}
if ( ! function_exists('page_list'))
{
	// Expects an array of objects
	function page_list($array_objs)
	{
		$i = 0;
		$parent_list=array();
		$kids = array();
		foreach($array_objs as $obj) {
			if($obj->parent_id !== null && $obj->page_type=='page')
			{
				$parent_list[] = $obj->parent_id;
				$kids[] = $obj->id;
				unset($array_objs[$i]);
			}
			++$i;
		}

		$output = '';
	
		foreach($array_objs as $page) {
			if($page->parent > 0 && !in_array($page->id,$kids))
			{
				$classes = array();
				$icons='';
				if($i%2==1) $classes[] = 'alt';
				if(in_array($page->id,$parent_list)) $classes[] = 'parent';
				if(in_array('parent',$classes)) $icons = '<span title="This page has child pages"></span>';
				$classes = (!empty($classes)) ? ' class="'.implode(' ',$classes).'"':'';
				$output .= '<li '.$classes.'>';
				if(!empty($page->title))
				{
					$output .='<a href="/admin/edit/'.$page->url.'" title="Edit: '.$page->title.'">'.$page->title.$icons.'</a>';
				}
				else
				{
					$output .= $page->title;
				}
				$output .= '</li>'."\n";
				++$i;
				}
			}
			//$output .= '</div>'."\n";
			return $output;
		}
}

if ( ! function_exists('default_pod'))
{
	// Expects an array of objects
	function default_pod($pod)
	{
		if(!empty($pod->pages) && gettype($pod->pages)==='string') {
			$output = '<li>'.$pod->pages.'</li>';
		}
		else {
			$output = '<li><em class="empty">No records returned</em></li>';
		}
		return $output;
	}
}