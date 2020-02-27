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
		
		if ($this->is_mobile()) {
			$this->render_template('users/create', $this->data);
		} else {			
			$this->render_template('users/index', $this->data);
		}
	}

	public function create()
	{
		if(!in_array('createUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();
		
		$this->form_validation->set_rules('groups', 'Group', 'required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|is_unique[users.username]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');
		$this->form_validation->set_rules('fname', 'First name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case
            $password = $this->password_hash($this->input->post('password'));
        	$data = array(
        		'username' => $this->input->post('username'),
        		'password' => $password,
        		'email' => $this->input->post('email'),
        		'firstname' => $this->input->post('fname'),
        		'lastname' => $this->input->post('lname'),
        		'phone' => $this->input->post('phone'),
        		'gender' => $this->input->post('gender'),
        		// 'store_branch_id' => json_encode($this->input->post('stores')),
        		'status' => $this->input->post('active')
        	);

        	// var_dump($data);

        	$create = $this->model_users->create($data, $this->input->post('groups'), $this->input->post('stores'));

        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('users/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('users/create', 'refresh');

        		// $response['success'] = true;
        		// $response['messages'] = 'Succesfully created';
        	}
        	// else {
        	// 	$response['success'] = false;
        	// 	$response['messages'] = 'Error in the database while creating the brand information';			
        	// }
        }
        else {
            // false case
        	// $group_data = $this->model_groups->getGroupData();
        	// $response = $this->data['group_data'] =  $group_data;
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }	
		
		echo json_encode($response);
	}

	public function password_hash($pass = '')
	{
		if($pass) {
			$password = password_hash($pass, PASSWORD_DEFAULT);
			return $password;
		}
	}

	public function edit($id = null)
	{
		if(!in_array('updateUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		

		if($id) {
			$this->form_validation->set_rules('groups', 'Group', 'required');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('fname', 'First name', 'trim|required');


			if ($this->form_validation->run() == TRUE) {
	            // true case
		        // if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
		        	$data = array(
		        		'username' => $this->input->post('username'),
		        		'email' => $this->input->post('email'),
		        		'firstname' => $this->input->post('fname'),
		        		'lastname' => $this->input->post('lname'),
		        		'phone' => $this->input->post('phone'),
		        		'gender' => $this->input->post('gender'),
		        	);

		        	$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
		        	if($update == true) {
		        		$this->session->set_flashdata('success', 'Successfully created');
		        		redirect('users/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('errors', 'Error occurred!!');
		        		redirect('users/edit/'.$id, 'refresh');
		        	}
		        // }
		   //      else {
		   //      	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
					// $this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					// if($this->form_validation->run() == TRUE) {

					// 	$password = $this->password_hash($this->input->post('password'));

					// 	$data = array(
			  //       		'username' => $this->input->post('username'),
			  //       		'password' => $password,
			  //       		'email' => $this->input->post('email'),
			  //       		'firstname' => $this->input->post('fname'),
			  //       		'lastname' => $this->input->post('lname'),
			  //       		'phone' => $this->input->post('phone'),
			  //       		'gender' => $this->input->post('gender'),
			  //       	);

			  //       	$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
			  //       	if($update == true) {
			  //       		$this->session->set_flashdata('success', 'Successfully updated');
			  //       		redirect('users/', 'refresh');
			  //       	}
			  //       	else {
			  //       		$this->session->set_flashdata('errors', 'Error occurred!!');
			  //       		redirect('users/edit/'.$id, 'refresh');
			  //       	}
					// }
			  //       else {
			  //           // false case
			  //       	$user_data = $this->model_users->getUserData($id);
			  //       	$groups = $this->model_users->getUserGroup($id);

			  //       	$this->data['user_data'] = $user_data;
			  //       	$this->data['user_group'] = $groups;

			  //           $group_data = $this->model_groups->getGroupData();
			  //       	$this->data['group_data'] = $group_data;

					// 	$this->render_template('users/edit', $this->data);	
			  //       }	

		   //      }
	        }
	        else {
	            // false case
	        	$user_data = $this->model_users->getUserData($id);
	        	$groups = $this->model_users->getUserGroup($id);

	        	$this->data['user_data'] = $user_data;
	        	$this->data['user_group'] = $groups;

	            $group_data = $this->model_groups->getGroupData();
	        	$this->data['group_data'] = $group_data;

				$this->render_template('users/edit', $this->data);	
	        }	
		}	
	}

	public function delete($id)
	{
		if(!in_array('deleteUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			if($this->input->post('confirm')) {
					$delete = $this->model_users->delete($id);
					if($delete == true) {
		        		$this->session->set_flashdata('success', 'Successfully removed');
		        		redirect('users/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('error', 'Error occurred!!');
		        		redirect('users/delete/'.$id, 'refresh');
		        	}

			}	
			else {
				$this->data['id'] = $id;
				$this->render_template('users/delete', $this->data);
			}	
		}
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
			echo json_encode($data);
		}
	}


}