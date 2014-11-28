<?php  
class ControllerModulePavproductfeatured extends Controller {
	protected function index($setting) {
		static $module = 0;
		
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->language->load('module/pavproductfeatured');
		
		$this->data['button_cart'] = $this->language->get('button_cart');
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/pavproductfeatured.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/pavproductfeatured.css');
		} else {
			//$this->document->addStyle('catalog/view/theme/default/stylesheet/pavproductfeatured.css');
		}
		$default = array(
			'latest' => 1,
			'limit' => 9
		);
		$products = array();
	
	 	$this->data['addition_class'] = $setting['class'];
		$this->data['width'] = $setting['width'];
		$this->data['height'] = $setting['height'];
		$this->data['cols']   = (int)$setting['cols'];
		$this->data['itemsperpage']   = (int)$setting['itemsperpage'];
		$this->data['tabs'] = array();

		$banner = '';
		if( isset($setting['image'][$this->config->get('config_language_id')]) ) {
			$banner = 	$setting['image'][$this->config->get('config_language_id')];
		}elseif( isset($setting['image']) ) {
			foreach ( $setting['image'] as $key => $image) {
				 if( $image ){
				 	$banner = $image;
				 	break;
				 }
			}
		}
		$this->data['banner'] = $banner;
	    $data = array(
			'sort'  => 'p.sort_order',
			'order' => 'DESC',
			'start' => 0,
			'featured_product' => isset($setting['featured_product'])?$setting['featured_product']:'',
			'limit' => $setting['limit']
		);
		//print_r($data);

		if( isset($setting['description'][$this->config->get('config_language_id')]) ) {
			$this->data['message'] = html_entity_decode($setting['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}else {
			$this->data['message'] = '';
		}
		$this->data['heading_title'] = $this->language->get('heading_title');
		$products = $this->getProducts( $this->getFeatured($data), $setting );
		
		$this->data['products'] = $products;
		$this->data['module'] = $module++;
						
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/pavproductfeatured.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/pavproductfeatured.tpl';
		} else {
			$this->template = 'default/template/module/pavproductfeatured.tpl';
		}
		
		$this->render();
	}
	private function getFeatured($option = array()){
		$data = array(
				'product_id'  =>$option['featured_product'],
			
		);
		
		
		//$return=$this->model_catalog_product->getProducts($data);
		//return $return;
		
		
		$return=$this->model_catalog_product->getProducts();
 $num=count($return);
 $chang=$num-$num%4;
 
 $new=array_slice($return,0,$chang);
 
 return $new;
	}
	private function getProducts( $results, $setting ){
		$products = array();
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
			} else {
				$image = false;
			}
						
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
					
			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}
			 
			$products[] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
					'new'  => $result['new'],
					'baoyou'  => $result['baoyou'],
					'jingpin'  => $result['jingpin'],
					'deguo'  => $result['deguo'],
					'xiaoliang'  => $result['xiaoliang'],
					'song'  => $result['song'],
				'name'    	 => $result['name'],
				'price'   	 => $price,
				'special' 	 => $special,
				'rating'     => $rating,
				'description'=> (html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')),
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			);
		}
		return $products;
	}
}
?>