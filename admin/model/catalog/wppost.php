<?php
class ModelCatalogWppost extends Model {
	public function addwppost($data) {
		foreach ($data['wppost_description'] as $language_id => $value) {
$sql="INSERT INTO " . DB_PREFIX . "posts ( post_title,post_content, post_excerpt,post_type, post_date) VALUES ('". $this->db->escape($value['name']) ."', '". $this->db->escape($value['meta_description']) ."', '". $this->db->escape($value['excerpt']) ."', '". $this->db->escape($value['term_id'])."','".date("Y-m-d H:i:s",time())."')";
					 $this->db->query($sql);
					
		}

		$this->cache->delete('wpcms');
	}

	public function editWppost($Wpcms_id, $data) {
		 foreach ($data['wppost_description'] as $language_id => $value) {
			$this->db->query("UPDATE " . DB_PREFIX ."posts SET post_title = '".$value['name']."' , post_excerpt='".$value['excerpt']."' ,post_content='".$value['meta_description']."' , post_type = '".$value['term_id']."'  WHERE ID =" . (int)$Wpcms_id );
			}
		$this->cache->delete('Wppost');
	
	}

	public function deleteWppost($Wpcms_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "posts WHERE ID = '" . (int)$Wpcms_id . "'");

		$this->cache->delete('Wppost');
	} 

	// Function to repair any erroneous categories that are not in the Wpcms path table.
	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "posts WHERE ID = '" . (int)$parent_id . "'");

		foreach ($query->rows as $Wpcms) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "Wpcms_path` WHERE Wpcms_id = '" . (int)$Wpcms['Wpcms_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "Wpcms_path` WHERE Wpcms_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "Wpcms_path` SET Wpcms_id = '" . (int)$Wpcms['Wpcms_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "Wpcms_path` SET Wpcms_id = '" . (int)$Wpcms['Wpcms_id'] . "', `path_id` = '" . (int)$Wpcms['Wpcms_id'] . "', level = '" . (int)$level . "'");

			$this->repairCategories($Wpcms['Wpcms_id']);
		}
	}

	public function getWppost($Wpcms_id) {
		$query = $this->db->query("SELECT * from " . DB_PREFIX . "posts  where ID=".$Wpcms_id);
       
		return $query->row;
	} 

	public function getCategories($data) {
		$sql = "SELECT * from " . DB_PREFIX . "posts ORDER BY ID desc";
		
		

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

	public function getWppostDescriptions($Wpcms_id) {
		$Wppost_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "posts WHERE ID = '" . (int)$Wpcms_id . "'");

		foreach ($query->rows as $result) {
			$Wppost_description_data = array(
				'name'             => $result['post_title'],
				'excerpt'          =>$result['post_excerpt'],
				'meta_keyword'     => $result['post_type'],
				'meta_description' => $result['post_content']
				
			);
		}

		return $Wppost_description_data;
		
	}	
     public function getWpcms() {
		$Wpcms_description_data = array();

		$query = $this->db->query("SELECT  term_id, name  FROM  oc_terms ");

		foreach ($query->rows as $result) {
			$Wpcms_description_data[$result['term_id']] = array(
				'id'             => $result['term_id'],
				'name'          =>$result['name']
				
			);
		}

		return $Wpcms_description_data;
		#var_dump($Wpcms_description_data);
		
	}
	public function getWppostFilters($Wpcms_id) {
		$Wpcms_filter_data = array();

		$query = $this->db->query("SELECT ID FROM " . DB_PREFIX . "posts WHERE ID = '" . (int)$Wpcms_id . "'");

		foreach ($query->rows as $result) {
			$Wpcms_filter_data[] = $result['ID'];
		}

		return $Wpcms_filter_data;
	}

	public function getWppostStores($Wpcms_id) {
		$Wpcms_store_data = array();

		$query = $this->db->query("SELECT ID FROM " . DB_PREFIX . "posts WHERE ID = '" . (int)$Wpcms_id . "'");

		foreach ($query->rows as $result) {
			$Wpcms_store_data[] = $result['ID'];
		}

		return $Wpcms_store_data;
	}

	public function getWppostLayouts($Wpcms_id) {
		$Wpcms_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "posts WHERE ID = '" . (int)$Wpcms_id . "'");

		foreach ($query->rows as $result) {
			$Wpcms_layout_data[$result['ID']] = $result['ID'];
		}

		return $Wpcms_layout_data;
	}

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "posts");

		return $query->row['total'];
	}	

	public function getTotalCategoriesByImageId($image_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "Wpcms WHERE image_id = '" . (int)$image_id . "'");

		return $query->row['total'];
	}

	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "posts WHERE ID = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}		
}
?>