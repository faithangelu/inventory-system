<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Store_details extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');

		$this->data['logged_in'] = $this->session->all_userdata();
		$this->not_logged_in();
		
		$this->data['page_title'] = 'Stores Details';

		$this->load->model('model_stores');
		$this->load->model('model_store_details');
		$this->load->model('model_products');
	}

	/* 
    * It only redirects to the manage stores page
    */
	// public function index()
	// {
	// 	if(!in_array('viewStore', $this->permission)) {
	// 		redirect('dashboard', 'refresh');
	// 	}

	// 	$this->data['page'] = "hi";

	// 	$store_data = $this->model_stores->getStoresData();

	// 	$result = array();
	// 	foreach ($store_data as $k => $v) {
 
	// 		$result[$k]['store_data'] = $v;
			
	// 	}

	// 	$this->data['store_data'] = $result;
	// 	$this->render_template('stores/index', $this->data);	
	// }

	
	public function view($param = FALSE, $id = FALSE) {
		$param = $this->uri->segment(2);
		
		$this->data['page_title'] = ucwords(str_replace("-", " ", $param));

		if ($param == 'area-of-responsibility') {
			$this->data[' . $param . '] = $this->model_store_details->get_area_of_responsibility();
		} 
		else if ($param == 'area-distributed-partner') {
			$this->data['area_of_responsibility'] = $this->model_store_details->get_area_of_responsibility();
			$this->data[' . $param . '] = $this->model_store_details->get_area_distributed_partner();	
		} 
		else if ($param == 'account-name-branch') {

			$updated_user = $this->model_stores->find_last_update();
			foreach ($updated_user as $k => $v) {
				$date = date_create($v['store_created_on']);
				$this->data['updated_date'] = date_format($date, 'M d, Y');
				$this->data['updated_user'] = $v['store_created_by'];
			}
		} 
		else if ($param == 'stock-keeping-unit')
		
		$this->render_template('store_details/' . $param, $this->data);	
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

			$status = ($value['store_active'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

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


	public function fetch_area_of_responsibility() {
		$result = array('data' => array());

		$data = $this->model_store_details->get_area_of_responsibility();

		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			// $buttons = '';

			if(in_array('updateStore', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary btn-sm" onclick="editFunc('.$value['store_area_of_responsibility_id'].')" data-toggle="modal" data-target="#editModal" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></button> <a type="button" class="btn btn-info btn-sm" href="' . base_url('store_details/area-distributed-partners-per-store/' . $value['store_area_of_responsibility_id']) . '" data-toggle="tooltip" title="Area Distributed Partners"><i class="fas fa-code-branch"></i></a>';
			}

			if(in_array('deleteStore', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['store_area_of_responsibility_id'].')" data-toggle="modal" data-target="#removeModal" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value['store_area_of_responsibility_status'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['store_area_of_responsibility_id'],
				$value['store_area_of_responsibility_name'],
				$value['store_area_of_responsibility_description'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function fetch_area_distributed_partner() 
	{
		$result = array('data' => array());

		$data = $this->model_store_details->get_area_distributed_partner();

		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			// $buttons = '';

			if(in_array('updateStore', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary btn-sm" onclick="editFunc('.$value['store_area_distributed_partner_id'].')" data-toggle="modal" data-target="#editModal" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></button>
					';
			}

			if(in_array('deleteStore', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['store_area_distributed_partner_id'].')" data-toggle="modal" data-target="#removeModal" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value['store_area_distributed_partner_status'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['store_area_distributed_partner_id'],
				$value['store_area_distributed_partner_name'],
				$value['store_area_distributed_partner_description'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
	
	public function fetch_area_distributed_partners_per_store($id) 
	{	
		$result = array('data' => array());

		$data = $this->model_store_details->get_area_distributed_partners_per_store($id);
		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			if(in_array('updateStore', $this->permission)) {				
				$buttons = '<button type="button" class="btn btn-primary btn-sm" onclick="editFunc('.$value->store_area_distributed_partner_id.')" data-toggle="modal" data-target="#editModal" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></button>
					';
			}

			if(in_array('deleteStore', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value->store_area_distributed_partner_id.')" data-toggle="modal" data-target="#removeModal" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value->store_area_distributed_partner_status == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';


			if (!empty($value->store_area_distributed_partner_status)) {					
				$result['data'][$key] = array(
					$value->store_area_distributed_partner_id,
					$value->store_area_distributed_partner_name,
					$value->store_area_distributed_partner_description,
					$status,
					$buttons
				);
			}
		} // /foreach

		echo json_encode($result);
	}


	public function fetch_area_of_responsibility_per_id($id) 
	{
		if($id) {
			$data = $this->model_stores->get_area_of_responsibility_per_id($id);
			echo json_encode($data); 
		}
	}

	public function fetch_area_distribution_partner_per_id($id) 
	{
		if($id) {
			$data = $this->model_store_details->get_area_distributed_partner_per_id($id);
			echo json_encode($data); 
		}
	}

	public function fetch_area_distributed_partners_per_store_id($id) 
	{
		if($id) {
			$data = $this->model_store_details->get_area_distributed_partners_per_store_id($id);
			// var_dump($data); exit;
			echo json_encode($data); 
		}
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
				if ($this->input->post('page') == 'area-of-responsibility') 
				{
					$response['success'] = FALSE;
					$response['message'] = 'Please complete the following fields';
					$response['errors'] = array(					
						'store_area_of_responsibility_name' => form_error('store_area_of_responsibility_name'),
						'store_area_of_responsibility_description' => form_error('store_area_of_responsibility_description'),
						'store_area_of_responsibility_status' => form_error('store_area_of_responsibility_status'),
					);
					echo json_encode($response);
					exit;
				}
				else if ($this->input->post('page') == 'area-distributed-partner' || $this->input->post('page') == 'area-distributed-partners-per-store') 
				{
					$response['success'] = FALSE;
					$response['message'] = 'Please complete the following fields';				
					$response['errors'] = array(					
						'store_area_distributed_partner_aor' => form_error('store_area_distributed_partner_aor[]'),
						'store_area_distributed_partner_name' => form_error('store_area_distributed_partner_name'),
						'store_area_distributed_partner_description' => form_error('store_area_distributed_partner_description'),
						'store_area_distributed_partner_status' => form_error('store_area_distributed_partner_status'),
					);
					echo json_encode($response);
					exit;
				}
				else if ($this->input->post('page') == 'area-distributed-partners-per-store') 
				{
					$response['success'] = FALSE;
					$response['message'] = 'Please complete the following fields';
					$response['errors'] = array(					
						'store_area_distributed_partner_name' => form_error('store_area_distributed_partner_name'),
						'store_area_distributed_partner_description' => form_error('store_area_distributed_partner_description'),
						'store_area_distributed_partner_status' => form_error('store_area_distributed_partner_status'),
					);
					echo json_encode($response);
					exit;
				}
			}
		}


	}

	private function _save($action = 'add', $id = 0) {
		
		if ($this->input->post('page') == 'area-of-responsibility') {
			$this->form_validation->set_rules('store_area_of_responsibility_name', 'Area of Responsibility', 'trim|required');
			$this->form_validation->set_rules('store_area_of_responsibility_description', 'Area of Responsibility Description', 'trim|required');
			$this->form_validation->set_rules('store_area_of_responsibility_status', 'Status', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if ($this->form_validation->run() == FALSE) {
				return FALSE;
			}

			$data = array(
				'store_area_of_responsibility_name' => $this->input->post('store_area_of_responsibility_name'),
				'store_area_of_responsibility_description' => $this->input->post('store_area_of_responsibility_description'),
				'store_area_of_responsibility_status' => $this->input->post('store_area_of_responsibility_status'),	
				'store_area_of_responsibility_deleted' => 0,	
			);

			if ($action == 'add')
			{
				$return = $this->model_store_details->area_of_responsibility_create($data);
			}
			else if ($action == 'update')
			{
				$return = $this->model_store_details->area_of_responsibility_update($id, $data);
			} 
			else if($action == 'delete') 
			{
				$return = $this->model_store_details->area_of_responsibility_remove($id);
			}

			return $return;
		} 
		else if ($this->input->post('page') == 'area-distributed-partner' || $this->input->post('page') == 'area-distributed-partners-per-store' ) 
		{
			if ($this->input->post('page') == 'area-distributed-partner') {
				$this->form_validation->set_rules('store_area_distributed_partner_aor[]', 'Area of Responsibility', 'trim|required');
			}
			$this->form_validation->set_rules('store_area_distributed_partner_name', 'Area Distributed Partner', 'trim|required');
			$this->form_validation->set_rules('store_area_distributed_partner_description', 'Area Distributed Partner Description', 'trim|required');
			$this->form_validation->set_rules('store_area_distributed_partner_status', 'Status', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if ($this->form_validation->run() == FALSE) {
				return FALSE;
			}

			$data = array(
				'store_area_distributed_partner_name' => $this->input->post('store_area_distributed_partner_name'),
				'store_area_distributed_partner_description' => $this->input->post('store_area_distributed_partner_description'),
				'store_area_distributed_partner_status' => $this->input->post('store_area_distributed_partner_status'),	
				'store_area_distributed_partner_deleted' => 0,	
			);

			if ($action == 'add')
			{
				$group = ($this->input->post('store_area_distributed_partner_aor[]')) ? $this->input->post('store_area_distributed_partner_aor') :  $this->input->post('store_id');
				$return = $this->model_store_details->area_distributed_partner_create($data, $group );
			}
			else if ($action == 'update')
			{
				$return = $this->model_store_details->area_distributed_partner_update($id, $data);
			} 
			else if($action == 'delete') 
			{
				$return = $this->model_store_details->area_distributed_partner_remove($id);
			}

			return $return;
		}
	}	
}