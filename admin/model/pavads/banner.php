<?php
/**
 * class ModelPavadsBanner
 */
class ModelPavadsBanner extends Model {

	protected $isinstalled = false;

	public function __construct( $registry ){
		parent::__construct( $registry );
		$this->isInstalled();
	}

	/**
	 * Check installed
	 */
	public function isInstalled() {
		
		$sql = " SHOW TABLES LIKE '".DB_PREFIX."pavads_banner'";
		$query = $this->db->query( $sql );

		if( count($query->rows) <=0 ){ 
			$file = dirname(DIR_APPLICATION).'/admin/model/sample/module.php';
			if( file_exists($file) ){
				require_once( $file );
		 		$sample = new ModelSampleModule( $this->registry );
		 	    $result = $sample->installSampleQuery( $this->config->get('config_template'),'pavads', true );  
			}
			return false;
		}
		$this->isinstalled = true;

		return true;
	}

	public function installModule(){
		$sql = " SHOW TABLES LIKE '".DB_PREFIX."pavads_banner'";
		$query = $this->db->query( $sql );
		if( count($query->rows) <=0 )
			$this->createTables();
	}

	protected function createTables(){
		$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavads_banner` (
                  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
                  `name` varchar(200) DEFAULT NULL,
                  `status` tinyint(4) DEFAULT '1',
                  `store_id` tinyint(4) DEFAULT '0',
                  `params` text  DEFAULT NULL,
                  PRIMARY KEY (`banner_id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
                ";
		$query = $this->db->query( $sql );
	}

	public function getTotalBanners() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "pavads_banner");

		return $query->row['total'];
	}	

	public function addBanner($data) {

		$params = serialize($data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "pavads_banner SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "', params='" . $params . "'");
	
	}

	public function editBanner($banner_id, $data) {

		$params = serialize($data);

		$this->db->query("UPDATE " . DB_PREFIX . "pavads_banner SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "', params = '" . $this->db->escape($params) . "' WHERE banner_id = '" . (int)$banner_id . "'");
			
	}

	public function deleteBanner($banner_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "pavads_banner WHERE banner_id = '" . (int)$banner_id . "'");
	}

	public function getBannerImages($banner_id){
		$query = $this->db->query("SELECT `params` FROM " . DB_PREFIX . "pavads_banner WHERE banner_id = '" . (int)$banner_id . "'");

		$result = $query->row;

		if(!empty($result)) {
			return unserialize($result['params']);
		} 

		return $result;
	}

	public function getBanner($banner_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "pavads_banner WHERE banner_id = '" . (int)$banner_id . "'");

		return $query->row;
	}

	public function getListBanners(){
		$sql = "SELECT * FROM " . DB_PREFIX . "pavads_banner";
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getBanners($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "pavads_banner";

		$sort_data = array(
			'name',
			'status'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}					

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}		

		$query = $this->db->query($sql);

		return $query->rows;
	}
}
