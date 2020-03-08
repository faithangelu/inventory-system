<?php 

class Model_stores extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the active store data */
	public function getStores()
	{
		$sql = "SELECT * FROM stores WHERE store_deleted = 0";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the active store data */
	public function getActiveStore()
	{
		$sql = "SELECT * FROM stores WHERE store_active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the brand data */
	public function getStoresData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM stores where store_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM stores";
		$query = $this->db->query($sql);
		return $query->result_array();
	}	

	/* get the brand data */
	public function getStoresDatabyUser($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM stores 
					LEFT JOIN stores_branch_group ON stores.store_id = stores_branch_group.store_branch_store_id 
					LEFT JOIN users ON users.user_id = stores_branch_group.store_branch_user_id 
					WHERE users.user_id = ?";
			$query = $this->db->query($sql, array($id));
			// p($query->result()); exit;
			return $query->result();
		}

		$sql = "SELECT * FROM stores";
		$query = $this->db->query($sql);
		return $query->result_array();
	}	

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('stores', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('store_id', $id);
			$update = $this->db->update('stores', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('store_id', $id);
			$delete = $this->db->update('stores', array('store_deleted' => 1));
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalStores()
	{
		$sql = "SELECT * FROM stores WHERE store_active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}

	public function insert_batch($data)
	{
		if($data) {
			$insert = $this->db->insert_batch('stores', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function get_area_of_responsibility() {
		$sql = "SELECT * FROM stores_area_of_responsibility WHERE store_area_of_responsibility_deleted = 0";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function get_area_of_responsibility_name($id = null) 
	{
		// var_dump($id); exit;
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

	public function get_area_distributed_partners_per_store($id) {
		$sql = "SELECT * FROM stores_area_distributed_partner
				LEFT JOIN stores_area_distributed_group 
				ON stores_area_distributed_partner.store_area_distributed_partner_id = stores_area_distributed_group.store_area_distributed_area_distributed_partner_id
				WHERE stores_area_distributed_partner.store_area_distributed_partner_id = ?
		";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function get_area_distributed_partner() {
		$sql = "SELECT * FROM stores_area_distributed_partner WHERE store_area_distributed_partner_deleted = 0";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	
	public function area_distributed_partner_create($data)
	{
		if($data) {
			$insert = $this->db->insert('stores_area_distributed_partner', $data);
			return ($insert == true) ? true : false;
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