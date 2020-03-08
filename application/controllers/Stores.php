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
		} // /foreach
		// exit;

		echo json_encode($result);
	}

	/*
    * If the validation is not valid, then it provides the validation error on the json format
    * If the validation for each input is valid then it inserts the data into the database and 
    returns the appropriate message in the json format.
    */
	public function create()
	{
		if(!in_array('createStore', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('store_name', 'Store name', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('store_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_stores->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the brand information';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}	

	/*
    * If the validation is not valid, then it provides the validation error on the json format
    * If the validation for each input is valid then it updates the data into the database and 
    returns a n appropriate message in the json format.
    */
	public function update($id)
	{
		if(!in_array('updateStore', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_store_name', 'Store name', 'trim|required');
			$this->form_validation->set_rules('edit_active', 'Active', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'name' => $this->input->post('edit_store_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_stores->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated the brand information';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again!!';
		}

		echo json_encode($response);
	}

	/*
	* If checks if the store id is provided on the function, if not then an appropriate message 
	is return on the json format
    * If the validation is valid then it removes the data into the database and returns an appropriate 
    message in the json format.
    */
	public function remove()
	{
		if(!in_array('deleteStore', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$store_id = $this->input->post('store_id');

		$response = array();
		if($store_id) {
			$delete = $this->model_stores->remove($store_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the brand information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}

	
	public function file_import()
	{
		$file = $_FILES['file'];

		print_r($file);

		$fields = array(
			'id', 'name', 'active'
		);		

		if ($content = file_get_contents($file['tmp_name']))
		{			
			$content = $file['tmp_name'];
			$csv = array_map('str_getcsv', file($content));

			if (count($csv) > 1)
			{
				unset($csv[0]);

				$chunk = array_chunk($csv, 1000, true);
				foreach ($chunk as $key => $batch)
				{
					$batch_data = FALSE;
					
													
					foreach ($batch as $k => $record)
					{			
						foreach ($record as $i => $cleanrecord)
						{						
							$batch_data[$k][$fields[$i]] = utf8_encode($cleanrecord); 					
						}
					}

					if (! ($status = $this->model_stores->insert_batch($batch_data))) {
						echo json_encode(array('success' => false, 'message' => 'Error occured. Unable to import the data. Please try again.')); exit;

					} else {
						echo json_encode(array('success' => true, 'message' => 'Data has been successfully imported.')); exit;

					}	
				}									
			}
			
		}	
		
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

	public function store_details($param = FALSE, $id = FALSE) {
		$this->data['page_title'] = ucwords(str_replace("_", " ", $param));

		if ($param == 'area_of_responsibility') {
			$this->data[' . $param . '] = $this->model_stores->get_area_of_responsibility();
		} 
		else if ($param == 'area_distributed_partner') {
			$this->data['area_of_responsibility'] = $this->model_stores->get_area_of_responsibility();
			$this->data[' . $param . '] = $this->model_stores->get_area_distributed_partner();	
		} 
		else if ($param == 'area_distributed_partners_per_store') {
			$this->data[' . $param . '] = $this->model_stores->get_area_distributed_partners_per_store($id);	
		} 

		$this->render_template('stores/' . $param, $this->data);	
	}

	public function fetch_area_of_responsibility() {
		$result = array('data' => array());

		$data = $this->model_stores->get_area_of_responsibility();

		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			// $buttons = '';

			if(in_array('updateStore', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary btn-sm" onclick="editFunc('.$value['store_area_of_responsibility_id'].')" data-toggle="modal" data-target="#editModal" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></button> <a type="button" class="btn btn-info btn-sm" href="' . base_url('stores/store_details/area_distributed_partners_per_store/' . $value['store_area_of_responsibility_id']) . '" data-toggle="tooltip" title="Area Distributed Partners"><i class="fas fa-code-branch"></i></a>';
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

		$data = $this->model_stores->get_area_distributed_partner();

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
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
	
	public function fetch_area_distributed_partners_per_store() 
	{
		$result = array('data' => array());

		$data = $this->model_stores->get_area_distributed_partner();

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
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function get_area_distributed_partners_per_store() 
	{
		$result = array('data' => array());

		$data = $this->model_stores->get_area_distributed_partners_per_store();

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
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}


	public function fetch_area_of_responsibility_user($id) 
	{
		if($id) {
			$data = $this->model_stores->get_area_of_responsibility_name($id);
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
				if ($this->input->post('page') == 'area_of_responsibility') 
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
				else if ($this->input->post('page') == 'area_distributed_partner') 
				{
					$response['success'] = FALSE;
					$response['message'] = 'Please complete the following fields';
					$response['errors'] = array(					
						'store_area_distributed_partner_name' => form_error('store_area_distributed_partner_name'),
						'store_area_distributed_partner_status' => form_error('store_area_distributed_partner_status'),
					);
					echo json_encode($response);
					exit;
				}
			}
		}


	}

	private function _save($action = 'add', $id = 0) {
		// var_dump($this->input->post()); exit;
		if ($this->input->post('page') == 'area_of_responsibility') {
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
				$return = $this->model_stores->area_of_responsibility_create($data);
			}
			else if ($action == 'update')
			{
				$return = $this->model_stores->area_of_responsibility_update($id, $data);
			} 
			else if($action == 'delete') 
			{
				$return = $this->model_stores->area_of_responsibility_remove($id);
			}

			return $return;
		} 
		else if ($this->input->post('page') == 'area_distributed_partner') 
		{
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
				$return = $this->model_stores->area_distributed_partner_create($data);
			}
			else if ($action == 'update')
			{
				$return = $this->model_stores->area_distributed_partner_update($id, $data);
			} 
			else if($action == 'delete') 
			{
				$return = $this->model_stores->area_distributed_partner_remove($id);
			}

			return $return;
		}

		

	}



	
}