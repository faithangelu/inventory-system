<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->data['logged_in'] = $this->session->all_userdata();
		$this->not_logged_in();

		$this->data['page_title'] = 'Orders';

		$this->load->model('model_orders');
		$this->load->model('model_products');
		$this->load->model('model_company');
		$this->load->model('model_stores');
		$this->load->model('model_inventory');

		/* $this->load->helper('assets'); */
	}

	/* 
	* It only redirects to the manage order page
	*/
	public function index()
	{
		// if(!in_array('viewOrder', $this->permission)) {
        //     redirect('dashboard', 'refresh');
        // }

        $store_data = $this->model_stores->getStoresDatabyUser($this->data['logged_in']['id']);

		$result = array();
		foreach ($store_data as $k => $v) { 
            $result[$k] = $v;                    
            // print_r($result); 
			// $group = $this->model_stores->getUserGroup($v['id']);
			// $result[$k]['user_group'] = $group;
		}
		// exit;
        $this->data['store_data'] = $result;        
        $this->data['page_title'] = 'Store Inventory';
        		$this->data['logged_in'] = $this->session->all_userdata();

		$this->render_template('inventory/index', $this->data);		
	}

	/*
	* Fetches the orders data from the orders table 
	* this function is called from the datatable ajax function
	*/
	public function fetchProductData()
	{
		$result = array('data' => array());

		$data = $this->model_products->getProductData();

		foreach ($data as $key => $value) {


			$result['data'][$key] = array(

				$value['name'],
			);
		} // /foreach

		echo json_encode($result);
	}	



	public function fetchProductsDataById($id) 
	{
		if($id) {
			$data = $this->model_products->getProductsData($id);
			echo json_encode($data);
		}
	}

	public function fetchStoresData()
	{
		$result = array('data' => array());

		$data = $this->model_stores->getStores();

		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			// $buttons = '';

			if(in_array('updateInventory', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary btn-sm" onclick="editFunc('.$value['store_id'].')" data-toggle="modal" data-target="#editModal" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></button>';
			}
			
			if(in_array('updateInventory', $this->permission)) {
				$buttons = '<button onclick="window.location.href=&#39;' . base_url('stores/product_per_store/'.$value['store_id']) . '&#39;" class="btn btn-info btn-sm" data-toggle="tooltip" title="Products"><i class="fa fa-product-hunt"></i></button>
				';
			}

			if(in_array('deleteInventory', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['store_id'].')" data-toggle="modal" data-target="#removeModal" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value['store_active'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['store_id'],
				$value['store_name'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* If the validation is not valid, then it redirects to the create page.
	* If the validation for each input field is valid then it inserts the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function create()
	{
		if(!in_array('createOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Add Inventory';		

		$data = array();
		for ($i = 0; $i < count($this->input->post('product_id')); $i++) {
			$data[$i] = array(
			'inventory_product_id' => isset($this->input->post('product_id')[$i]) ? $this->input->post('product_id')[$i] : $this->input->post('product_id')[$i],
			'inventory_user_id' => $this->input->post('user_id')[$i], 
			'inventory_store_id' => $this->input->post('store_id')[$i], 
			'inventory_osp' => $this->input->post('osp')[$i],
			'inventory_warehouse_case' => $this->input->post('warehouse')[$i],
			'inventory_selling_area_case' => $this->input->post('selling_area')[$i],
			'inventory_delivery_case' => $this->input->post('delivery')[$i],
			'inventory_stock_transfer' => $this->input->post('stock_transfer')[$i],
			'inventory_notes' => $this->input->post('notes')[$i],
			'inventory_date' => date("Y-m-d H:i:s"),
			);

		};
		
		$create = $this->model_inventory->insert_batch($data);        	
    	
    	if($create) {
    		$this->session->set_flashdata('success', 'Successfully created');
    		redirect('inventory/start_inventory/'.$create, 'refresh');
    	}
    	else {
    		$this->session->set_flashdata('errors', 'Error occurred!!');
    		redirect('inventory/start_inventory/'.$create, 'refresh');
    	}
	}

	
	public function getProductValueById()
	{
		$product_id = $this->input->post('product_id');
		if($product_id) {
			$product_data = $this->model_products->getProductData($product_id);
			echo json_encode($product_data);
		}
	}

	public function start_inventory($id)
	{
		if(!in_array('createInventory', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$getStoreBranch = $this->model_products->getActiveProductPerStore($id);

		$this->data['page_title'] = 'Start Inventory Count';
		$this->data['store_branch'] = $getStoreBranch;

	
		if ($this->is_mobile()) {
            $this->render_template('inventory/create_mobile', $this->data);
        } else {
            $this->render_template('inventory/create', $this->data);
		}
	}

	/*
	* It gets the product id and fetch the order data. 
	* The order print logic is done here 
	*/
	public function printDiv($id)
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
	}


}