<?php
/******************************************************
 * @package Pav ads for Opencart 1.5.x
 * @version 1.0
 * @author pavotheme (http://pavotheme.com)
 * @copyright	Copyright (C) May 2013 pavotheme.com <@emai:pavotheme@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 1
*******************************************************/

class ControllerModulePavads extends Controller {
	private $error = array();

	public function index() {

		$this->language->load('module/pavads');
		$this->load->model('setting/setting');
		$this->load->model('tool/image');
		$this->load->model('pavads/banner');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('view/javascript/sliderlayer/jquery-cookie.js');

		//install data sample
		$this->model_pavads_banner->installModule();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$action = isset($this->request->post["action"])?$this->request->post["action"]:"";
			unset($this->request->post['action']);

			$this->model_setting_setting->editSetting('pavads', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if($action == "save_stay"){
				$this->redirect($this->url->link('module/pavads', 'token=' . $this->session->data['token'], 'SSL'));
			} elseif($action == "delete") {
				$this->delete();
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
		

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['tab_module'] = $this->language->get('tab_module');

		// Text
		$this->data['prefix_class'] = $this->language->get('prefix_class');
		// Button
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_save_stay'] = $this->language->get('button_save_stay');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		// Entry
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_tabs'] = $this->language->get('entry_tabs');
		$this->data['entry_banner_layouts'] = $this->language->get('entry_banner_layouts');
		$this->data['entry_caption'] = $this->language->get('entry_caption');
		
		// Value
		$this->data['no_image'] = '';
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');	
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);	
		
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_enabled'] = $this->language->get('text_enabled');


		$this->data['positions'] = array( 'mainmenu',
										  'slideshow',
										  'showcase',
										  'promotion',
										  'content_top',
										  'column_left',
										  'column_right',
										  'content_bottom',
										  'mass_bottom',
										  'footer_top',
										  'footer_center',
										  'footer_bottom');

		$themeConfig = $this->config->get( 'themecontrol' );
		if( isset($themeConfig['default_theme']) ){
			$layoutxml = DIR_CATALOG.'view/theme/'.$themeConfig['default_theme'].'/development/layout/default.php';
			if( file_exists($layoutxml) ){
				include( $layoutxml );
		 		$this->data['positions'] = PavoLayoutPositions::getList();
			}
		}	
		$this->data['layout_groups'] = array( 	array('layout_id' => 1, 'name' => $this->language->get('layout_1')),
												array('layout_id' => 2, 'name' => $this->language->get('layout_2')), );
										
		// Token
		$this->data['token'] = $this->session->data['token'];

		// Language
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$this->data['languages'] = $languages;

		$this->load->model('design/layout');

		$this->data['layouts'] = array();
		$this->data['layouts'][] = array('layout_id'=>99999, 'name' => $this->language->get('text_all_page') );
		
		$this->data['layouts'] = array_merge($this->data['layouts'],$this->model_design_layout->getLayouts());

		$this->data['action'] = $this->url->link('module/pavads', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['createnew'] = $this->url->link('module/pavads/insert', 'token=' . $this->session->data['token'], 'SSL');
				

		$this->breadcrumbs();
		
		$this->data['modules'] = array();
		if (isset($this->request->post['pavads_module'])) {
			$this->data['modules'] = $this->request->post['pavads_module'];
		} elseif ($this->config->get('pavads_module')) { 
			$this->data['modules'] = $this->config->get('pavads_module');
		}

		//data banners for selectbox
		$selectbanners = $this->model_pavads_banner->getListBanners();

		$this->data['selectbanners'] = empty($selectbanners)?array():$selectbanners;

		//Get List Banner
		$this->getList();

		$this->template = 'module/pavads/pavads.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function breadcrumbs(){
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/pavads', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
	}

	public function getList() {
		 
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['banners'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$banner_total = $this->model_pavads_banner->getTotalBanners();

		$results = $this->model_pavads_banner->getBanners($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('module/pavads/update', 'token=' . $this->session->data['token'] . '&banner_id=' . $result['banner_id'] . $url, 'SSL')
			);

			$this->data['banners'][] = array(
				'banner_id' => $result['banner_id'],
				'name'      => $result['name'],	
				'status'    => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),				
				'selected'  => isset($this->request->post['selected']) && in_array($result['banner_id'], $this->request->post['selected']),				
				'action'    => $action
			);
		}
 
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('module/pavads', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('module/pavads', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $banner_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/pavads', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

	}

	public function delete() {
		$this->language->load('module/pavads');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('pavads/banner');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $banner_id) {
				$this->model_pavads_banner->deleteBanner($banner_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('module/pavads', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function insert() {
		$this->language->load('module/pavads');
		$this->load->model('pavads/banner');
		$this->document->setTitle($this->language->get('heading_title_insert'));
		$this->data['heading_title'] = $this->language->get('heading_title_insert');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_pavads_banner->addBanner($this->request->post);

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$action = isset($this->request->post["action"])?$this->request->post["action"]:"";
			unset($this->request->post['action']);

			$this->session->data['success'] = $this->language->get('text_success');

			if($action == "save_stay"){
				$this->redirect($this->url->link('module/pavads/update', 'banner_id='.$this->request->get['banner_id'].'&token=' . $this->session->data['token'] . $url, 'SSL'));
			}else{
				$this->redirect($this->url->link('module/pavads', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm("insert");
	}

	public function update() {
		$this->language->load('module/pavads');
		$this->load->model('pavads/banner');
		$this->document->setTitle($this->language->get('heading_title_edit'));

		$this->data['heading_title'] = $this->language->get('heading_title_edit');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_pavads_banner->editBanner($this->request->get['banner_id'], $this->request->post);

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$action = isset($this->request->post["action"])?$this->request->post["action"]:"";
			unset($this->request->post['action']);

			$this->session->data['success'] = $this->language->get('text_success');

			if($action == "save_stay"){
				$this->redirect($this->url->link('module/pavads/update', 'banner_id='.$this->request->get['banner_id'].'&token=' . $this->session->data['token'] . $url, 'SSL'));
			}else{
				$this->redirect($this->url->link('module/pavads', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm("edit");
	}

	protected function getForm($check) {

		$this->data['check'] = $check;
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');			

		$this->data['entry_banner_name'] = $this->language->get('entry_banner_name');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_link'] = $this->language->get('entry_link');
		$this->data['entry_image'] = $this->language->get('entry_image');		
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_banner'] = $this->language->get('button_add_banner');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_add_module'] = $this->language->get('button_add_module');

		$this->data['tab_image'] = $this->language->get('tab_image');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		if (isset($this->error['banner_image'])) {
			$this->data['error_banner_image'] = $this->error['banner_image'];
		} else {
			$this->data['error_banner_image'] = array();
		}	

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->breadcrumbs();

		if (!isset($this->request->get['banner_id'])) { 
			$this->data['actionbanner'] = $this->url->link('module/pavads/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['actionbanner'] = $this->url->link('module/pavads/update', 'token=' . $this->session->data['token'] . '&banner_id=' . $this->request->get['banner_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('module/pavads', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['banner_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$banner_info = $this->model_pavads_banner->getBanner($this->request->get['banner_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($banner_info)) {
			$this->data['name'] = $banner_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($banner_info)) {
			$this->data['status'] = $banner_info['status'];
		} else {
			$this->data['status'] = true;
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image');

		if (isset($this->request->post['banner_image'])) {
			$banner_images = $this->request->post['banner_image']; 
		} elseif (isset($this->request->get['banner_id'])) {
			$banner_images = $this->model_pavads_banner->getBannerImages($this->request->get['banner_id']);
		} else {
			$banner_images = array();
		}

		$this->data['banner_images'] = array();

		if(isset($banner_images['banners'])) {
			foreach ($banner_images['banners'] as $banner_image) {
				if ($banner_image['image'] && file_exists(DIR_IMAGE . $banner_image['image'])) {
					$image = $banner_image['image'];
				} else {
					$image = 'no_image.jpg';
				}			

				$this->data['banner_images'][] = array(
					'caption'                  => $banner_image['caption'],
					// 'width'                    => $banner_image['width'],
					// 'height'                   => $banner_image['height'],
					'link'                     => $banner_image['link'],
					'image'                    => $image,
					'thumb'                    => $this->model_tool_image->resize($image, 100, 100)
				);	
			} 
		}


		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);		

		$this->template = 'module/pavads/pavads_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'module/pavads')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		// if (isset($this->request->post['banner_image'])) {
		// 	foreach ($this->request->post['banner_image'] as $banner_image_id => $banner_image) {
		// 		foreach ($banner_image['banner_image_description'] as $language_id => $banner_image_description) {
		// 			if ((utf8_strlen($banner_image_description['title']) < 2) || (utf8_strlen($banner_image_description['title']) > 64)) {
		// 				$this->error['banner_image'][$banner_image_id][$language_id] = $this->language->get('error_title'); 
		// 			}					
		// 		}
		// 	}	
		// }
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/pavads')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'module/pavads')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
