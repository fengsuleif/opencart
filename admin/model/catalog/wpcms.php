<?php
class ModelCatalogWpcms extends Model {
	public function addWpcms($data) {
		

		foreach ($data['wpcms_description'] as $language_id => $value) {
			#$this->db->query("INSERT INTO " . DB_PREFIX . "wpcms_description SET wpcms_id = '" . (int)$wpcms_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
					$this->db->query("INSERT INTO " . DB_PREFIX . "terms ( name, slug, term_group) VALUES ('". $this->db->escape($value['name']) ."', '". $this->db->escape($value['slug']) ."', 0)");
		
		}
		$this->cache->delete('wpcms');
	}

	public function editWpcms($Wpcms_id, $data) {
	
	

           foreach ($data['wpcms_description'] as $language_id => $value) {
			$this->db->query("UPDATE " . DB_PREFIX ."terms SET name = '".$value['name']."' , slug='".$value['meta_description']."' WHERE term_id =" . (int)$Wpcms_id );
			}
		$this->cache->delete('Wpcms');
	}

	public function deleteWpcms($Wpcms_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "terms WHERE term_id = '" . (int)$Wpcms_id . "'");
		$this->cache->delete('Wpcms');
	} 

	// Function to repair any erroneous categories that are not in the Wpcms path table.
	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "terms WHERE term_id = '" . (int)$parent_id . "'");

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

	public function getWpcms($Wpcms_id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "terms WHERE term_id = " . (int)$Wpcms_id );
       
		return $query->row;
	} 

	public function getCategories($data) {
		
    $sql="SELECT * from " . DB_PREFIX . "terms order by term_id ";
		
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
		$query = $this->db->query("");

		return $query->rows;
	}

	public function getWpcmsDescriptions($wpcms_id) {
			$wpcms_description_data = array();
		$query = $this->db->query("SELECT term_id,name,slug  FROM " . DB_PREFIX ."terms WHERE term_id = '" . (int)$wpcms_id . "'");

		foreach ($query->rows as $result) {
	
			$wpcms_description_data = array(
				'name'             => $result['name'],
				'meta_description' => $result['slug']
			);
		}

		return $wpcms_description_data;
		
	}	
	public function getWpcmsFilters($Wpcms_id) {
		$Wpcms_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "Wpcms_filter WHERE Wpcms_id = '" . (int)$Wpcms_id . "'");

		foreach ($query->rows as $result) {
			$Wpcms_filter_data[] = $result['filter_id'];
		}

		return $Wpcms_filter_data;
	}

	public function getWpcmsStores($Wpcms_id) {
		$Wpcms_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "Wpcms_to_store WHERE Wpcms_id = '" . (int)$Wpcms_id . "'");

		foreach ($query->rows as $result) {
			$Wpcms_store_data[] = $result['store_id'];
		}

		return $Wpcms_store_data;
	}

	public function getWpcmsLayouts($Wpcms_id) {
		$Wpcms_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "Wpcms_to_layout WHERE Wpcms_id = '" . (int)$Wpcms_id . "'");

		foreach ($query->rows as $result) {
			$Wpcms_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $Wpcms_layout_data;
	}

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "terms");

		return $query->row['total'];
	}	

	public function getTotalCategoriesByImageId($image_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "Wpcms WHERE image_id = '" . (int)$image_id . "'");

		return $query->row['total'];
	}

	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "Wpcms_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}		
}
?>