<?php 

class Users extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->data['logged_in'] = $this->session->all_userdata();
		$this->data['page_title'] = 'Users';
		

		$this->load->model('model_users');
		$this->load->model('model_groups');
		$this->load->model('model_stores');
	}

	
	public function index()
	{
		if(!in_array('viewUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$user_data = $this->model_users->getUserData();

		$result = array();
		foreach ($user_data as $k => $v) {

			$result[$k]['user_info'] = $v;

			$user_group = $this->model_users->getUserGroup($v['user_id']);
			$result[$k]['user_group'] = $user_group;
		}
		
		$this->data['user_data'] = $result;
		$this->data['user_group'] = $this->model_groups->getGroupData();

		$this->data['user_stores'] = $this->model_stores->getStoresData();
		$this->data['page_breadcrumb'] = 'Users';
		
		// if ($this->is_mobile()) {
		// $this->render_template('users/create', $this->data);
		// } else {			
			$this->render_template('users/index', $this->data);
		// }
	}

	public function form($action = 'add', $id = FALSE)
	{
		if(!in_array('createUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
	
		if ($this->input->post())
		{
			if ($this->_save($action, $id))
			{
				echo json_encode(array('success' => true, 'message' => 'Saved Successfully')); exit;
			}
			else
			{	
				$response['success'] = FALSE;
				$response['message'] = 'Please correct or provide the necessary information';
				$response['errors'] = array(					
					'user_groups' 			=> form_error('user_groups'),
					'user_stores' 			=> form_error('user_stores[]'),
					'user_username' 		=> form_error('user_username'),
					'user_email' 			=> form_error('user_email'),
					'user_password' 		=> form_error('user_password'),
					'user_firstname' 		=> form_error('user_firstname'),
					'user_confirm_password' => form_error('user_confirm_password'),
					'user_lastname' 		=> form_error('user_lastname'),
					'user_phone' 			=> form_error('user_phone'),
					'user_gender' 			=> form_error('user_gender')
				);
				
				echo json_encode($response);
				exit;
			}
		}

	}

	private function _save($action = 'add', $id = 0) {
		$this->form_validation->set_rules('user_groups', 'Group', 'trim|required');
		$this->form_validation->set_rules('user_stores[]', 'Stores', 'trim|required');
		$this->form_validation->set_rules('user_username', 'Username', 'trim|required|min_length[5]|max_length[12]|is_unique[users.user_username]');
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|is_unique[users.user_email]');
		$this->form_validation->set_rules('user_password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('user_confirm_password', 'Confirm password', 'trim|required|matches[user_password]');
		$this->form_validation->set_rules('user_firstname', 'First name', 'trim|required');
		$this->form_validation->set_rules('user_lastname', 'Last name', 'trim|required');
		$this->form_validation->set_rules('user_phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('user_gender', 'Gender', 'trim|required');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == FALSE) {
			return FALSE;
		}

		// true case
		$password = $this->password_hash($this->input->post('user_password'));
		$data = array(
			'user_username' => $this->input->post('user_username'),
			'user_password' => $password,
			'user_email' => $this->input->post('user_email'),
			'user_firstname' => $this->input->post('user_firstname'),
			'user_lastname' => $this->input->post('user_lastname'),
			'user_phone' => $this->input->post('user_phone'),
			'user_gender' => $this->input->post('user_gender'),
			'user_status' => $this->input->post('user_status'),
			'user_password_not_hash' => $this->input->post('user_password'),
			'user_deleted' => 0,
		);

		if ($action == 'add')
		{	
			$return = $this->model_users->create($data, $this->input->post('user_groups'), $this->input->post('user_stores[]'));
		}
		else if ($action == 'update')
		{
			$return = $this->model_users->edit($id, $data);
		}

		return $return;

	}

	public function remove()
	{
		if(!in_array('deleteUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$id = $this->input->post('user_id');

		$response = array();
		if($id) {
			$delete = $this->model_users->delete($id);
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

	public function profile()
	{
		if(!in_array('viewProfile', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$user_id = $this->session->userdata('id');

		$user_data = $this->model_users->getUserData($user_id);
		$this->data['user_data'] = $user_data;

		$user_group = $this->model_users->getUserGroup($user_id);
		$this->data['user_group'] = $user_group;

        $this->render_template('users/profile', $this->data);
	}

	public function setting()
	{	
		if(!in_array('updateSetting', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$id = $this->session->userdata('id');

		if($id) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('fname', 'First name', 'trim|required');


			if ($this->form_validation->run() == TRUE) {
	            // true case
		        if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
		        	$data = array(
		        		'username' => $this->input->post('username'),
		        		'email' => $this->input->post('email'),
		        		'firstname' => $this->input->post('fname'),
		        		'lastname' => $this->input->post('lname'),
		        		'phone' => $this->input->post('phone'),
		        		'gender' => $this->input->post('gender'),
		        	);

		        	$update = $this->model_users->edit($data, $id);
		        	if($update == true) {
		        		$this->session->set_flashdata('success', 'Successfully updated');
		        		redirect('users/setting/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('errors', 'Error occurred!!');
		        		redirect('users/setting/', 'refresh');
		        	}
		        }
		        else {
		        	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					if($this->form_validation->run() == TRUE) {

						$password = $this->password_hash($this->input->post('password'));

						$data = array(
			        		'username' => $this->input->post('username'),
			        		'password' => $password,
			        		'email' => $this->input->post('email'),
			        		'firstname' => $this->input->post('fname'),
			        		'lastname' => $this->input->post('lname'),
			        		'phone' => $this->input->post('phone'),
			        		'gender' => $this->input->post('gender'),
			        	);

			        	$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
			        	if($update == true) {
			        		$this->session->set_flashdata('success', 'Successfully updated');
			        		redirect('users/setting/', 'refresh');
			        	}
			        	else {
			        		$this->session->set_flashdata('errors', 'Error occurred!!');
			        		redirect('users/setting/', 'refresh');
			        	}
					}
			        else {
			            // false case
			        	$user_data = $this->model_users->getUserData($id);
			        	$groups = $this->model_users->getUserGroup($id);

			        	$this->data['user_data'] = $user_data;
			        	$this->data['user_group'] = $groups;

			            $group_data = $this->model_groups->getGroupData();
			        	$this->data['group_data'] = $group_data;

						$this->render_template('users/setting', $this->data);	
			        }	

		        }
	        }
	        else {
	            // false case
	        	$user_data = $this->model_users->getUserData($id);
	        	$groups = $this->model_users->getUserGroup($id);

	        	$this->data['user_data'] = $user_data;
	        	$this->data['user_group'] = $groups;

	            $group_data = $this->model_groups->getGroupData();
	        	$this->data['group_data'] = $group_data;

				$this->render_template('users/setting', $this->data);	
	        }	
		}
	}

	public function fetchUsers() 
	{
		$result = array('data' => array());

		$data = $this->model_users->fetchUsers();

		foreach ($data as $key => $value) {
			// var_dump($data);
			// button
			$buttons = '';

			if(in_array('updateStore', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary btn-sm" onclick="editFunc('.$value['user_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteStore', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['user_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value['user_status'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['user_id'],
				$value['user_username'],
				$value['user_email'],
				$value['user_firstname'] . $value['user_lastname'],
				$value['user_phone'],
				$status,
				$buttons
			);

		} // /foreach

		echo json_encode($result);
	}

	public function fetchUserDataById($id) 
	{
		if($id) {
			$data = $this->model_users->getUserData($id);
			echo json_encode($data); exit;
		}
	}

	
	public function password_hash($pass = '')
	{
		if($pass) {
			$password = password_hash($pass, PASSWORD_DEFAULT);
			return $password;
		}
	}
}