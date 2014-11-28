<?php


/**
 * class ControllerModulepavblogcomment 
 */
class ControllerModulepavblogcomment extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->redirect($this->url->link('module/pavblog/frontmodules', 'mod=pavblogcomment&token=' . $this->session->data['token'], 'SSL'));
	}
	
}
?>
