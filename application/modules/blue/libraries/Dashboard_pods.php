<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Assembles dashboard pods based on an iteration of the modules directory
 * If the assembler finds modules/name_of_module/config/dashboard.php file, its values are loaded,
 * and the data from that module's model is pulled to add to the pods object, which will be returned
 * to the admin controller to be passed to the view.
 *
 */

class Dashboard_pods {
	protected $_packages = array();
	protected $_models = array();
	protected $_exceptions = array();
	public $model_data = array();
	public $html = '';
	public $pods;

	public function index() {

		$html = '';

		$ci =& get_instance();
		$basepath = 'application/modules';
		$dir = new RecursiveIteratorIterator(new RecursiveRegexIterator(new RecursiveDirectoryIterator($basepath), '#(?<!/)\/config\/[A-z]+_dashboard\.php$|^[^\.]*$#i'), true);
		foreach($dir as $d) {
			if($d->isFile()) {
				$_packages[] = dirname(dirname($d->getPathname())); // application/modules/menus/
				$_configs[] = $d->getFilename();
			}
		}
			$helper = new Site_View_Helper_Pod(array());
			$helper->setView(new Zend_View());
			//debug::dump($helper);

 		foreach($_packages as $k=>$v) {
			if(isset($pod)) {
			unset($pod);
			}
			unset($html);
 			$html = '';
 			/*
 			 *Load mvc for each module with a dashboard config
 			 */
 			$ci->load->add_package_path($v);

 			/*
 			 * Load that config file and the model and model->method from its config array
 			 */
 			$ci->config->load(str_replace('.php','',$_configs[$k])); // menus_dashboard
 			$ci->load->model($ci->config->item('_model'));
 			$_model = $ci->config->item('_model');
 			$_method = $ci->config->item('_method');
 			$ci->config->item('_args') ? $args=$ci->config->item('_args') : $args=null;

 			/*
 			 * Get the properties of the Pod kids from the config file
 			 */
			$ci->config->item('head_tag') ? $head_tag = $ci->config->item('head_tag') : $head_tag = array('tag'=>'h2');
			$ci->config->item('ul') ? $ul = $ci->config->item('ul') : $ul = array('tag'=>'ul');
			$ci->config->item('li') ? $li = $ci->config->item('li') : $li = array('tag'=>'li');
			$ci->config->item('a') ? $a = $ci->config->item('a') : $a = array();

			/*
			 * Set the Heading of each pod
			 */
 			$_heading = ($ci->config->item('_heading')) ? $_heading = $ci->config->item('_heading'):$_heading=ucfirst(basename($obj['path']));

 			/*
 			 * Set the properties of the Pod parent and each Pod wrap
 			 */
 			$podParent = array('tag' => 'div', 'class' => 'pods');
 			$podKids = array('tag' => 'div', 'class' => 'pod one-third');

			/*
			 * Create a class property to hold the data of the model
			 */
			/*
			pod(array $data,
				array $wrapperAttribs = array('tag' => 'div', 'class' => 'pods'),
				array $podAttribs = array('tag' => 'div', 'class' => 'pod one-third'),
				array $headingAttribs = array('tag' => 'h2', 'class' => 'headingClass'),
				array $ulAttribs = array('tag' => 'ul', 'class' => 'podUlClass'),
				array $liAttribs = array('tag' => 'li', 'class' => 'liClass'),
				array $aAttribs = array('class' => 'linkClass')
			*/
			$pod[$_heading] = $ci->$_model->$_method($args);

//			$helper->setWrapperAttribs(array('tag' => 'div', 'class' => 'pods'));
//			$helper->setAAttribs(array('class' => 'LinkClass'));
//			$html .= $helper->pod($pod);
$helper->setWrapperAttribs(array('tag' => 'div', 'class' => 'pods'));
$helper->setAAttribs(array());
$helper->setHeadingAttribs($head_tag);
$helper->setPodAttribs($podKids);
$helper->setUlAttribs($ul);
$helper->setLiAttribs($li);
$html .= $helper->pod($pod);
			$ci->load->remove_package_path();
 		}// end foreach



 		return $html;
 	}
}