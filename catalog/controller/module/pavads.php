<?php



class ControllerModulePavads extends Controller {

	protected function index($setting) {
		static $module = 0;
	
		$this->load->model('tool/image');
		
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/pavads.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/pavads.css');
		}

		$default = array(
			'prefix'        => 'prefix_class',
			'sort_order'    => '2',
			'status'        => '0',
			'banner'        => '1',
			'banner_layout' => 'img1',
		);
		
		$data  = array_merge($default, $setting); //echo "<pre>"; print_r($data); die;

		$this->data['language']        = $this->config->get('config_language_id');
		$this->data['prefix']          = $data['prefix'];
		$this->data['status']          = $data['status'];
		$this->data['banner_layout']   = $data['banner_layout'];
		$this->data['banner']          = $data['banner'];
		
		$lstbanner = $this->getBanner($data['banner']);

		$lstdefault = array(
			"banner_id" => "109",
    		"name"      => "Banner",
    		"status"    => "1",
    		"params"    => array(),
		);

		$lstdata  = array_merge($lstdefault, $lstbanner);

		$this->data['banners'] = $lstdata;

			
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/pavads.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/pavads.tpl';
		} else {
			$this->template = 'default/template/module/pavads.tpl';
		}
		
		$this->render();
	}

	protected function getBanner($banner_id) {
		
		$this->load->model('tool/image');

		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "pavads_banner WHERE banner_id = '" . (int)$banner_id . "'");
		$data = $query->row;
		if(!empty($data["params"])){
			$tmp = unserialize($data['params']);
			foreach ($tmp['banners'] as &$item) {
				$item['thumb'] = 'image/'.$item['image'];//$this->model_tool_image->resize($item['image'], $item['width'], $item['height']);
			}
			$data["params"] = $tmp['banners'];
		}
		return $data;
	}
}
?>