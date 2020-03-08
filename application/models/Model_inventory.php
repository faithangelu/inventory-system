<?php 

class Model_inventory extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active inventory information*/
	public function getAllinventory()
	{
		$sql = "SELECT * FROM inventory";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the brand data */
	public function getBrandData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM brands WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM brands";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	// public function update($data, $id)
	// {
	// 	if($data && $id) {
	// 		$this->db->where('inventory_id', $id);
	// 		$update = $this->db->update('brands', $data);
	// 		return ($update == true) ? true : false;
	// 	}
	// }

	// public function remove($id)
	// {
	// 	if($id) {
	// 		$this->db->where('inventory_id', $id);
	// 		$delete = $this->db->delete('brands');
	// 		return ($delete == true) ? true : false;
	// 	}
	// }

	public function insert_batch($data)
	{
		if($data) {
			$insert = $this->db->insert_batch('inventory', $data);
			return ($insert == true) ? true : false;
		}
	}

}