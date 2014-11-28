<?php


/**
 * class ControllerModulePavbloglatest 
 */
class ControllerModulePavbloglatest extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->redirect($this->url->link('module/pavblog/frontmodules', 'mod=pavbloglatest&token=' . $this->session->data['token'], 'SSL'));	
		
	}
	
}
?>
