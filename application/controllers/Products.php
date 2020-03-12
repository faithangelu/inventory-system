<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

        $this->data['logged_in'] = $this->session->all_userdata();
		$this->not_logged_in();


		$this->data['page_title'] = 'Products';

		$this->load->model('model_products');
		$this->load->model('model_brands');
		$this->load->model('model_category');
		$this->load->model('model_stores');
		$this->load->model('model_attributes');
	}

    /* 
    * It only redirects to the manage product page
    */
	public function index()
	{
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->render_template('products/index', $this->data);	
	}

    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
	public function fetchProductData()
	{
		$result = array('data' => array());

		$data = $this->model_products->getProduct();

        // var_dump($data); exit;

		foreach ($data as $key => $value) {

            // $store_data = $this->model_stores->getStoresData($value['store_id']);
			// button
   //          $buttons = '';
   //          if(in_array('updateProduct', $this->permission)) {
   //  			$buttons .= '<a href="'.base_url('products/update/'.$value['product_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
   //          }

   //          if(in_array('deleteProduct', $this->permission)) { 
   //  			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
   //          }
			

			// $img = '<img src="'.base_url($value['image']).'" alt="'.$value['name'].'" class="img-circle" width="50" height="50" />';

   //          $availability = ($value['availability'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

   //          $qty_status = '';
   //          if($value['qty'] <= 10) {
   //              $qty_status = '<span class="label label-warning">Low !</span>';
   //          } else if($value['qty'] <= 0) {
   //              $qty_status = '<span class="label label-danger">Out of stock !</span>';
   //          }


			$result['data'][$key] = array(				
				$value['product_id'],
                $value['product_name'],
                $value['product_category_id'],
                $value['product_size']
			);
		} // /foreach

		echo json_encode($result);
	}	

    /*
    * If the validation is not valid, then it redirects to the create page.
    * If the validation for each input field is valid then it inserts the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function create()
	{
		if(!in_array('createProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
		// $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
		// $this->form_validation->set_rules('price', 'Price', 'trim|required');
		// $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
        // $this->form_validation->set_rules('store', 'Store', 'trim|required');
		// $this->form_validation->set_rules('availability', 'Availability', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {
            // true case
        	$upload_image = $this->upload_image();

        	$data = array(
        		'name' => $this->input->post('product_name'),
        		'sku' => $this->input->post('sku'),
        		'price' => $this->input->post('price'),
        		'qty' => $this->input->post('qty'),
        		'image' => $upload_image,
        		'description' => $this->input->post('description'),
        		'attribute_value_id' => json_encode($this->input->post('attributes_value_id')),
        		'brand_id' => json_encode($this->input->post('brands')),
        		'category_id' => json_encode($this->input->post('category')),
                'store_id' => $this->input->post('store'),
        		'availability' => $this->input->post('availability'),
        	);

        	$create = $this->model_products->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('products/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('products/create', 'refresh');
        	}
        }
        else {
            // false case

        	// attributes 
        	$attribute_data = $this->model_attributes->getActiveAttributeData();

        	$attributes_final_data = array();
        	foreach ($attribute_data as $k => $v) {
        		$attributes_final_data[$k]['attribute_data'] = $v;

        		$value = $this->model_attributes->getAttributeValueData($v['id']);

        		$attributes_final_data[$k]['attribute_value'] = $value;
        	}

        	$this->data['attributes'] = $attributes_final_data;
			$this->data['brands'] = $this->model_brands->getActiveBrands();        	
			$this->data['category'] = $this->model_category->getActiveCategroy();        	
			$this->data['stores'] = $this->model_stores->getActiveStore();        	

            $this->render_template('products/create', $this->data);
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
                $response['success'] = FALSE;
                $response['message'] = 'Please complete the following fields';
                $response['errors'] = array(					
                    'product_name' => form_error('product_name'),
                    'product_description' => form_error('product_description'),
                    // 'product_status' => form_error('product_status'),
                );
                echo json_encode($response);
                exit;
            }
		}


	}

	private function _save($action = 'add', $id = 0) {

        $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('product_description', 'Product Name Description', 'trim|required');
        // $this->form_validation->set_rules('product_status', 'Status', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        }

        $data = array(
            'product_name' => $this->input->post('product_name'),
            'product_description' => $this->input->post('product_description'),
            // 'product_status' => $this->input->post('product_status'),	
            'product_deleted' => 0,	
        );

        if ($action == 'add')
        {
            $return = $this->model_products->create($data);
        }
        else if ($action == 'update')
        {
            $return = $this->model_products->update($id, $data);
        } 
        else if($action == 'delete') 
        {
            $return = $this->model_products->remove($id);
        }

        return $return;

	}

    /*
    * This function is invoked from another function to upload the image into the assets folder
    * and returns the image path
    */
	public function upload_image()
    {
    	// assets/images/product_image
        $config['upload_path'] = 'assets/images/product_image';
        $config['file_name'] =  uniqid();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000';

        // $config['max_width']  = '1024';s
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('product_image'))
        {
            $error = $this->upload->display_errors();
            return $error;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $type = explode('.', $_FILES['product_image']['name']);
            $type = $type[count($type) - 1];
            
            $path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
            return ($data == true) ? $path : false;            
        }
    }

}