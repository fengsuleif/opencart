<?php


/**
 * class ControllerModulepavblogcategory 
 */
class ControllerModulepavblogcategory extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->redirect($this->url->link('module/pavblog/frontmodules', 'mod=pavblogcategory&token=' . $this->session->data['token'], 'SSL'));
	}
}
?>
