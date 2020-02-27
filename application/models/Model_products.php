<?php 

class Model_products extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the all brand */
	public function getProduct()
	{
		$sql = "SELECT * FROM products ORDER BY product_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/* get the brand data */
	public function getProductData($id)
	{
		if($id) {
			$sql = "SELECT * FROM products where product_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM products ORDER BY product_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// public function getActiveProductData()
	// {
	// 	$sql = "SELECT * FROM products WHERE product_ = ? ORDER BY id DESC";
	// 	$query = $this->db->query($sql, array(1));
	// 	return $query->result_array();
	// }

	public function getActiveProductPerStore($id) 
	{
		$sql = "SELECT * FROM products 
				LEFT JOIN stores_product_group ON products.product_id = stores_product_group.store_product_product_id 
				LEFT JOIN stores ON stores_product_group.store_product_store_id = stores.store_id 
				WHERE stores.store_id = ?
				-- AND product_status = 1
			";

		$query = $this->db->query($sql, array($id));
		return $query->result();	
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('products', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('product_id', $id);
			$update = $this->db->update('products', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('product_id', $id);
			$delete = $this->db->delete('products');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalProducts()
	{
		$sql = "SELECT * FROM products";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function insert_batch($data)
	{
		if($data) {
			$insert = $this->db->insert_batch('products', $data);
			return ($insert == true) ? true : false;
		}
	}
}