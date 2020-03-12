<?php 

class Model_store_details extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_area_of_responsibility() {
		$sql = "SELECT * FROM stores_area_of_responsibility WHERE store_area_of_responsibility_deleted = 0";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function get_area_of_responsibility_per_id($id = null) 
	{
		if($id) {
			$sql = "SELECT * FROM stores_area_of_responsibility WHERE store_area_of_responsibility_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM stores_area_of_responsibility WHERE store_area_of_responsibility_id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function area_of_responsibility_create($data)
	{
		if($data) {
			$insert = $this->db->insert('stores_area_of_responsibility', $data);
			return ($insert == true) ? true : false;
		}
	}
	
	public function area_of_responsibility_update($id, $data)
	{
		if($data && $id) {
			$this->db->where('store_area_of_responsibility_id', $id);
			$update = $this->db->update('stores_area_of_responsibility', $data);
			return ($update == true) ? true : false;
			
		}
	}
	
	public function area_of_responsibility_remove($id)
	{
		if($id) {
			$update = $this->db->update('stores_area_of_responsibility', array('store_area_of_responsibility_deleted' => 1 ));
			return ($update == true) ? true : false;
			
		}
	}

	public function get_area_distributed_partner() {
		$sql = "SELECT * FROM stores_area_distributed_partner WHERE store_area_distributed_partner_deleted = 0";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function get_area_distributed_partner_per_id($id) {
		if($id) {
			$sql = "SELECT * FROM stores_area_distributed_partner WHERE store_area_distributed_partner_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM stores_area_distributed_partner WHERE store_area_distributed_partner_id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
	
	public function get_area_distributed_partners_per_store_id($id) {
		if($id) {
			$sql = "SELECT * FROM stores_area_of_responsibility 
				LEFT JOIN stores_area_distributed_group 
				ON stores_area_of_responsibility.store_area_of_responsibility_id = stores_area_distributed_group.store_area_distributed_area_of_responsibility_id
				LEFT JOIN stores_area_distributed_partner 
				ON stores_area_distributed_group.store_area_distributed_area_distributed_partner_id = stores_area_distributed_partner.store_area_distributed_partner_id
				WHERE stores_area_of_responsibility.store_area_of_responsibility_id = ?";			
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM stores_area_distributed_partner 
				LEFT JOIN stores_area_distributed_group 
				ON stores_area_of_responsibility.store_area_of_responsibility_id = stores_area_distributed_group.store_area_distributed_area_of_responsibility_id
				LEFT JOIN stores_area_distributed_partner 
				ON stores_area_distributed_group.store_area_distributed_area_distributed_partner_id = stores_area_distributed_partner.store_area_distributed_partner_id
				WHERE stores_area_of_responsibility.store_area_of_responsibility_id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function get_area_distributed_partners_per_store($store_id) {
		if($store_id) {
			$sql = "SELECT * FROM stores_area_of_responsibility 
					LEFT JOIN stores_area_distributed_group 
					ON stores_area_of_responsibility.store_area_of_responsibility_id = stores_area_distributed_group.store_area_distributed_area_of_responsibility_id
					LEFT JOIN stores_area_distributed_partner 
					ON stores_area_distributed_group.store_area_distributed_area_distributed_partner_id = stores_area_distributed_partner.store_area_distributed_partner_id
					WHERE stores_area_of_responsibility.store_area_of_responsibility_id = ?";
			$query = $this->db->query($sql, array($store_id));
			return $query->result();
		}

		// $sql = "SELECT * FROM stores_area_of_responsibility 
		// LEFT JOIN stores_area_distributed_group 
		// ON stores_area_of_responsibility.store_area_of_responsibility_id = stores_area_distributed_group.store_area_distributed_area_of_responsibility_id
		// LEFT JOIN stores_area_distributed_partner 
		// ON stores_area_distributed_group.store_area_distributed_area_distributed_partner_id = stores_area_distributed_partner.store_area_distributed_partner_id
		// WHERE stores_area_of_responsibility.store_area_of_responsibility_id != ?";
		// $query = $this->db->query($sql, array(1));
		// return $query->result_array();
	}

	
	public function area_distributed_partner_create($data = '', $aor_id = null)
	{
		if($data && $aor_id) {
			$insert = $this->db->insert('stores_area_distributed_partner', $data);

			$user_id = $this->db->insert_id();
			if (is_array($aor_id)) {
				foreach ($aor_id as $key => $value) {
				
					$aor_data = array(
						'store_area_distributed_area_distributed_partner_id' => $user_id,
						'store_area_distributed_area_of_responsibility_id' => $value
					);
					
					$aor_data = $this->db->insert('stores_area_distributed_group', $aor_data);
				}	
			} else {
				$aor_data = $this->db->insert('stores_area_distributed_group', array('store_area_distributed_area_distributed_partner_id' => $user_id, 'store_area_distributed_area_of_responsibility_id' => $aor_id));
			}

			return ($insert == true && $aor_data) ? true : false;		

		}
	}
	
	public function area_distributed_partner_update($id, $data)
	{
		if($data && $id) {
			$this->db->where('store_area_distributed_partner_id', $id);
			$update = $this->db->update('stores_area_distributed_partner', $data);
			return ($update == true) ? true : false;
			
		}
	}
	
	public function area_distributed_partner_remove($id)
	{
		if($id) {
			$update = $this->db->update('store_area_distributed_partner', array('store_area_distributed_partner_deleted' => 1));
			return ($update == true) ? true : false;
			
		}
	}

	public function get_account_name_branch() {

	}

}