<?php


class ControllerModulePavreassurance extends Controller {
	protected function index($setting) {

		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/pavreassurance.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/pavreassurance.css');
		}

		$language = $this->config->get('config_language_id');
		$prefix_class = isset($setting['prefix']) ? $setting['prefix'] : '';

		$this->data['prefix_class'] = $prefix_class;
		$this->data['language'] = $language;

		$reassurances = isset($setting['pavreassurances'])?$setting['pavreassurances']:array();

		$result = array();
		if (!empty($reassurances)) {
			foreach ($reassurances as $key=>$value) {
				$result[$key]['select_icon'] = $value['select_icon'];
				$result[$key]['title'] = isset($value['title'][$language])?$value['title'][$language]:'';
				$result[$key]['caption'] = isset($value['caption'][$language])?$value['caption'][$language]:'';
				$result[$key]['detail'] = isset($value['detail'][$language])?$value['detail'][$language]:'';
			}
		}

		$this->data['pavreassurances'] = $result;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/pavreassurance.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/pavreassurance.tpl';
		} else {
			$this->template = 'default/template/module/pavreassurance.tpl';
		}
		
		$this->render();
	}
}