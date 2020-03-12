<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stores extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');

		$this->data['logged_in'] = $this->session->all_userdata();
		$this->not_logged_in();
		
		$this->data['page_title'] = 'Stores';

		$this->load->model('model_stores');
		$this->load->model('model_products');
	}

	/* 
    * It only redirects to the manage stores page
    */
	public function index()
	{
		if(!in_array('viewStore', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page'] = "hi";

		$store_data = $this->model_stores->getStoresData();

		$result = array();
		foreach ($store_data as $k => $v) {
 
			$result[$k]['store_data'] = $v;
			
		}
		
		$updated_user = $this->model_stores->find_last_update();
		foreach ($updated_user as $k => $v) {
			$date = date_create($v['store_created_on']);
			$this->data['updated_date'] = date_format($date, 'M d, Y');
			$this->data['updated_user'] = $v['store_created_by'];
		}
		
		$this->data['store_data'] = $result;
		$this->render_template('stores/index', $this->data);	
	}

	public function fetchProductsDataById($id) 
	{
		if($id) {
			$data = $this->model_products->getProductsData($id);
			echo json_encode($data);
		}
	}
	/*
	* It retrieve the specific store information via a store id
	* and returns the data in json format.
	*/
	
	/*
	* It retrieves all the store data from the database 
	* This function is called from the datatable ajax function
	* The data is return based on the json format.
	*/
	public function fetchStoresData()
	{
		$result = array('data' => array());

		$data = $this->model_stores->getStores();

		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			// $buttons = '';

			if(in_array('updateStore', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary btn-sm" onclick="editFunc('.$value['store_id'].')" data-toggle="modal" data-target="#editModal" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></button>
					<button onclick="window.location.href=&#39;' . base_url('stores/product_per_store/'.$value['store_id']) . '&#39;" class="btn btn-info btn-sm" data-toggle="tooltip" title="Products"><i class="fa fa-product-hunt"></i></button>
					';
			}

			if(in_array('deleteStore', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['store_id'].')" data-toggle="modal" data-target="#removeModal" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value['store_status'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['store_id'],
				$value['store_name'],
				// $value['store_active'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* It retrieves all the store data from the database 
	* This function is called from the datatable ajax function
	* The data is return based on the json format.
	*/
	public function getActiveProductPerStore($id)
	{
		$result = array('data' => array());

		$data = $this->model_products->getActiveProductPerStore($id);

		foreach ($data as $key => $value) {
			
			// button
			$buttons = '';

			// $buttons = '';

			if(in_array('updateStore', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary btn-sm" onclick="editFunc('.$value->product_id.')" data-toggle="modal" data-target="#editModal" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></button>
					';
			}

			if(in_array('deleteStore', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value->product_id.')" data-toggle="modal" data-target="#removeModal" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value->store_product_product_status == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value->product_id,
				$value->product_name,
				$status,
				$buttons
			);
		} 
		echo json_encode($result);
	}

	public function form($action = 'add', $id = FALSE) {

		if ($this->input->post())
		{
			if ($this->_save($action, $id))
			{
				echo json_encode(array('success' => true, 'message' => 'Saved Successfully')); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = 'Please complete the following fields';
				$response['errors'] = array(					
					'store_name' => form_error('store_name'),
					'store_status' => form_error('store_status'),
				);
				echo json_encode($response);
				exit;
			}
		}
	}

	private function _save($action = 'add', $id = 0) {
		$this->form_validation->set_rules('store_name', 'Account Name Branch', 'trim|required');
		$this->form_validation->set_rules('store_status', 'Status', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if ($this->form_validation->run() == FALSE) {
			return FALSE;
		}

		$data = array(
			'store_name' => $this->input->post('store_name'),
			'store_status' => $this->input->post('store_status'),	
			'store_deleted' => 0,	
			'store_created_on' => date('Y-m-d H:i:s'),	
			'store_created_by' => $this->data['logged_in']['username'],	
		);

		if ($action == 'add')
		{
			$return = $this->model_stores->create($data);
		}
		else if ($action == 'update')
		{
			$return = $this->model_stores->update($id, $data);
		} 
		else if($action == 'delete') 
		{
			$return = $this->model_stores->remove($id);
		}

		return $return;
	}	

	public function product_per_store($id) {

		$product_per_store = $this->model_products->getActiveProductPerStore($id);

		$result = array();
		foreach ($product_per_store as $k => $v) {
			$result[$k]['product_per_store'] = $v;
		}
		$this->data['product_per_store'] = $result;
		
		$this->render_template('stores/products_per_store', $this->data);	
	}

}