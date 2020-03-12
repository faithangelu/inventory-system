<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->data['logged_in'] = $this->session->all_userdata();
		$this->not_logged_in();


		$this->data['page_title'] = 'Category';

		$this->load->model('model_category');
	}

	/* 
	* It only redirects to the manage category page
	*/
	public function index()
	{

		if(!in_array('viewCategory', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('category/index', $this->data);	
	}	

	/*
	* It checks if it gets the category id and retreives
	* the category information from the category model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function fetchCategoryDataById($id) 
	{
		if($id) {
			$data = $this->model_category->getCategoryData($id);
			echo json_encode($data);
		}

		return false;
	}

	/*
	* Fetches the category value from the category table 
	* this function is called from the datatable ajax function
	*/
	public function fetchCategoryData()
	{
		$result = array('data' => array());

		$data = $this->model_category->getCategoryData();

		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			if(in_array('updateCategory', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-warning" onclick="editFunc('.$value['category_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteCategory', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc('.$value['category_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			$status = ($value['category_status'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['category_name'],
				$status,
				$buttons
			);
		} // /foreach

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
					'category_name' => form_error('category_name'),
					'category_status' => form_error('category_status'),
				);
				echo json_encode($response);
				exit;
			}
		}
	}

	private function _save($action = 'add', $id = 0) {
		$this->form_validation->set_rules('category_name', 'Category', 'trim|required');
		$this->form_validation->set_rules('category_status', 'Status', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if ($this->form_validation->run() == FALSE) {
			return FALSE;
		}

		$data = array(
			'category_name' => $this->input->post('category_name'),
			'category_status' => $this->input->post('category_status'),	
			'category_deleted' => 0,	
		);

		if ($action == 'add')
		{
			$return = $this->model_category->create($data);
		}
		else if ($action == 'update')
		{
			$return = $this->model_category->update($id, $data);
		} 
		else if($action == 'delete') 
		{
			$return = $this->model_category->remove($id);
		}

		return $return;
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


                    if (! ($status = $this->model_products->insert_batch($batch_data))) {
                        echo json_encode(array('success' => false, 'message' => 'Error occured. Unable to import the data. Please try again.')); exit;

                    } else {
                        echo json_encode(array('success' => true, 'message' => 'Data has been successfully imported.')); exit;

                    }   
                }                                   
            }
            
        }           
    }

    // public function getCategory()


}