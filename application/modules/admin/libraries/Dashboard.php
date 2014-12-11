<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard {
	protected $_modules = array();
	protected $_models = array();
	protected $_exceptions = array();
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->init();
	}
 
 	public function init() {
		$Directory = new RecursiveDirectoryIterator(APPPATH . 'modules');
		$Iterator = new RecursiveIteratorIterator($Directory);
		$Models = new RegexIterator($Iterator, '/^.+\_dashboard_model.php$/i', RecursiveRegexIterator::GET_MATCH);
		foreach ($Models as $k=>$v ) {
			$this->_modules[] = $k;
		}
		$this->_exceptions[] = ''; // nothing at the moment...
		$this->_modules = array_diff($this->_modules,$this->_exceptions);
		foreach($this->_modules as $k=>$v) {
			$classname = pathInfo($v,PATHINFO_FILENAME);
			if(is_file($v)) {
				$this->CI->load->file($v);
			}
			$this->CI->load->file(FCPATH.APPPATH.'/modules/users/helpers/dashboard_helper.php');
			$class = new $classname();
		}
 	}
}