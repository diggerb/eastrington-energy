<?php
class page {
	public $_header;
	private $_extras = array();
	private $_exclude = array();
	private $_css = array();
	private $_js = array();
	private $_main;

	//defaults to get: headerTemplate.php, menuTemplate.php, menu.css and JQuery

	//ob_end_clean(); <-- not here though

	public function __construct($user, $extras = array(), $exclude = array()){
		$this->_user = $user;
		//$this->_extras = $extras;
		$this->_exclude = $exclude;

		if(count($extras) == 0){
			$this->_extras = array();
		}

		if(count($extras['js']) != 0){
			if(in_array('jcrop', $extras['js'])){
				$this->_js = $this->jcrop();
				$extras['js'] = array_diff($extras['js'], array('jcrop'));
			}
		}

		$this->_js = $this->js($extras['js']);

		$this->_css = $this->css($extras['css']);

		$this->_main = $this->header();
		$this->_main .= $this->menu();

		echo $this->_main;
	}

	public function header(){
		include('includes/headerTemplate.php');
	}

	public function menu(){
		include('includes/menuTemplate.php');
	}

	public function js($files = array()){
		foreach($files as $file){
			$js[] = '<script src="js/'.$file.'.js"></script>';
		}

		$js[] = $this->jquery();

		return $js;
	}

	public function jquery(){
		include('js/jquery.php');
	}

	public function jcrop(){
		
	}

	public function css($files = array()){
		foreach($files as $file){
			$css[] = '<link rel="stylesheet" type="text/css" href="css/'.$file.'.css">';
		}

		$css[] = '<link rel="stylesheet" type="text/css" href="css/menu.css">';

		return $css;
	}

	public function get($property){
		if(isset($this->$property)){
			return $this->$property;
		}

		return false;
	}
}