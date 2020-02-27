<?php 

class Model_users extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getUserData($userId = null) 
	{
		if($userId) {
			$sql = "SELECT * FROM users WHERE user_id = ?";
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}

		$sql = "SELECT * FROM users WHERE user_id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function getUserGroup($userId = null) 
	{
		if($userId) {
			$sql = "SELECT * FROM user_group WHERE user_group_user_id = ?";
			$query = $this->db->query($sql, array($userId));
			$result = $query->row_array();

			$group_id = $result['user_group_group_id'];
			$g_sql = "SELECT * FROM groups WHERE group_id = ?";
			$g_query = $this->db->query($g_sql, array($group_id));
			$q_result = $g_query->row_array();
			return $q_result;
		}
	}

	// public 

	public function create($data = '', $group_id = null, $store_id = null)
	{		
		// exit;
		if($data && $group_id && $store_id) {
			$create = $this->db->insert('users', $data);

			$user_id = $this->db->insert_id();

			$group_data = array(
				'user_group_user_id' => $user_id,
				'user_group_group_id' => $group_id
			);

			foreach ($store_id as $key => $value) {
				# code...
				$store_data = array(
					'store_branch_user_id' => $user_id,
					'store_branch_stores_id' => $value,
				);
				
				$store_data = $this->db->insert('stores_branch_group', $store_data);
			}			

			$group_data = $this->db->insert('user_group', $group_data);

			return ($create == true && $group_data && $store_data) ? true : false;
		}
	}

	public function edit($data = array(), $id = null, $group_id = null)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('users', $data);

		if($group_id) {
			// user group
			$update_user_group = array('user_group_group_id' => $group_id);
			$this->db->where('user_group_user_id', $id);
			$user_group = $this->db->update('user_group', $update_user_group);
			return ($update == true && $user_group == true) ? true : false;	
		}
			
		return ($update == true) ? true : false;	
	}

	public function delete($id)
	{
		$this->db->where('user_id', $id);
		$delete = $this->db->delete('users');
		return ($delete == true) ? true : false;
	}

	public function countTotalUsers()
	{
		$sql = "SELECT * FROM users";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function fetchUsers() 
	{
		$sql = "SELECT * FROM users WHERE user_status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
	
}