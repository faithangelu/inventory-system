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
		$sql = "SELECT * FROM stores WHERE store_status = ?";
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

	public function find_last_update() {
		// $sql = " WHERE store_active = ?";
		$query = $this->db->query("SELECT store_created_on, store_created_by FROM stores ORDER BY store_id DESC LIMIT 1");
		$result = $query->result_array();
		return $result;
	}
}